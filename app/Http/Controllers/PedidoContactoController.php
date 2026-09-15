<?php

namespace App\Http\Controllers;

use App\Mail\RespostaPedidoContacto;
use App\Models\PedidoContacto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class PedidoContactoController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'pesquisa' => ['nullable', 'string', 'max:100'],
            'estado' => ['nullable', Rule::in(array_keys(PedidoContacto::ESTADOS))],
            'ordem' => ['nullable', Rule::in(['recentes', 'antigos'])],
        ]);
        $pesquisa = trim($data['pesquisa'] ?? '');
        $estado = $data['estado'] ?? '';
        $ordem = $data['ordem'] ?? 'recentes';
        $pedidos = PedidoContacto::query()
            ->when($pesquisa, fn ($query) => $query->where(function ($query) use ($pesquisa) {
                foreach (['nome', 'email', 'assunto', 'mensagem'] as $column) {
                    $query->orWhere($column, 'like', '%'.$pesquisa.'%');
                }
            }))
            ->when($estado, fn ($query) => $query->where('estado', $estado))
            ->orderBy('created_at', $ordem === 'antigos' ? 'asc' : 'desc')
            ->orderBy('id', $ordem === 'antigos' ? 'asc' : 'desc')
            ->paginate(15)->withQueryString();

        return view('Contactos.admin.index', compact('pedidos', 'pesquisa', 'estado', 'ordem'));
    }

    public function show(PedidoContacto $pedido)
    {
        if (! $pedido->lido_em) {
            $pedido->update(['lido_em' => now()]);
            $pedido->eventos()->create(['tipo' => 'read', 'descricao' => 'Pedido lido', 'user_id' => auth()->id()]);
        }
        $pedido->load(['respostas' => fn ($q) => $q->orderBy('enviado_em'), 'eventos' => fn ($q) => $q->orderBy('created_at')->orderBy('id')]);

        return view('Contactos.admin.show', compact('pedido'));
    }

    public function update(Request $request, PedidoContacto $pedido)
    {
        $data = $request->validate([
            'estado' => ['required', Rule::in(array_keys(PedidoContacto::ESTADOS))],
            'notas_internas' => ['nullable', 'string', 'max:5000'],
        ]);
        if ($data['estado'] === 'replied' && ! $pedido->respondido_em) {
            throw ValidationException::withMessages(['estado' => 'O pedido só pode ser marcado como respondido após o envio de um email.']);
        }
        DB::transaction(function () use ($pedido, $data, $request) {
            $oldStatus = $pedido->estado;
            $oldNotes = $pedido->notas_internas;
            $pedido->update(['estado' => $data['estado'], 'notas_internas' => $data['notas_internas'] ?? null]);
            if ($oldStatus !== $pedido->estado) {
                $pedido->eventos()->create(['tipo' => 'status', 'descricao' => 'Estado alterado para '.$pedido->estado_texto, 'user_id' => $request->user()->id]);
            }
            if ($oldNotes !== $pedido->notas_internas) {
                $pedido->eventos()->create(['tipo' => 'notes', 'descricao' => 'Notas internas atualizadas', 'user_id' => $request->user()->id]);
            }
        });

        return redirect()->route('admin.contactos.show', $pedido)->with('success', 'Pedido atualizado.');
    }

    public function archive(PedidoContacto $pedido)
    {
        if ($pedido->estado !== 'archived') {
            DB::transaction(function () use ($pedido) {
                $pedido->update(['estado' => 'archived']);
                $pedido->eventos()->create(['tipo' => 'status', 'descricao' => 'Pedido arquivado', 'user_id' => auth()->id()]);
            });
        }

        return redirect()->route('admin.contactos.show', $pedido)->with('success', 'Pedido arquivado.');
    }

    public function reply(PedidoContacto $pedido)
    {
        return view('Contactos.admin.reply', compact('pedido'));
    }

    public function sendReply(Request $request, PedidoContacto $pedido)
    {
        $data = $request->validate([
            'assunto' => ['required', 'string', 'min:3', 'max:160'],
            'mensagem' => ['required', 'string', 'min:10', 'max:10000'],
        ]);
        $mailer = config('mail.default');
        if (! in_array($mailer, ['smtp', 'sendmail', 'mailgun', 'ses', 'postmark', 'resend'], true)) {
            return back()->withInput()->withErrors(['email' => 'O envio real de email não está configurado. Configure MAIL_MAILER e as credenciais do serviço de email antes de responder.']);
        }
        try {
            Mail::to($pedido->email)->send(new RespostaPedidoContacto($pedido, $data['assunto'], $data['mensagem']));
        } catch (Throwable $error) {
            Log::error('Falha ao enviar resposta de pedido de contacto', ['pedido_id' => $pedido->id, 'error' => $error]);
            return back()->withInput()->withErrors(['email' => 'Não foi possível enviar a resposta. Verifique a configuração de email e tente novamente.']);
        }

        DB::transaction(function () use ($pedido, $data, $request) {
            $sentAt = now();
            $pedido->respostas()->create(['user_id' => $request->user()->id, 'assunto' => $data['assunto'], 'mensagem' => $data['mensagem'], 'enviado_em' => $sentAt]);
            $pedido->update(['estado' => 'replied', 'respondido_em' => $sentAt]);
            $pedido->eventos()->create(['tipo' => 'reply', 'descricao' => 'Resposta enviada por email', 'user_id' => $request->user()->id]);
        });

        return redirect()->route('admin.contactos.show', $pedido)->with('success', 'Resposta enviada e registada.');
    }
}
