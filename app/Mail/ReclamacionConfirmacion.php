<?php

namespace App\Mail;

use App\Models\Reclamacion;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ReclamacionConfirmacion extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Reclamacion $reclamacion) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Hemos recibido tu reclamación - Código ' . $this->reclamacion->codigo,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.reclamacion-confirmacion',
        );
    }
}