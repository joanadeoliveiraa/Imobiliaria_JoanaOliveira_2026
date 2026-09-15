<?php

namespace App\Mail;

use App\Models\PedidoContacto;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RespostaPedidoContacto extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public PedidoContacto $pedido,
        public string $assunto,
        public string $texto,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(subject: $this->assunto);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.resposta-contacto');
    }
}
