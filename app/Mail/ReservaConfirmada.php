<?php

namespace App\Mail;

use App\Models\Venda;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservaConfirmada extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Venda $reserva)
    {
        $this->reserva->loadMissing(['propriedade', 'clienteRegistado', 'pagamentoSimulado']);
    }

    public function build(): self
    {
        return $this->subject('Confirmação da sua reserva — Olive Properties')
            ->view('emails.reservation-confirmed')
            ->text('emails.reservation-confirmed-text');
    }
}
