<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Cliente;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class correoMensual extends Mailable
{


    use Queueable, SerializesModels;

    protected $datos;
    protected $pdfContent;


    /**
     * Create a new message instance.
     */
    public function __construct(Cliente $datos, $pdfContent)
    {
        $this->datos = $datos;
        $this->pdfContent = $pdfContent;
    }
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Correo Mensual',
        );
    }



    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }




    public function build()
    {
        $pdfContent = $this->pdfContent->output();

        // Adjunta los datos renderizados como un archivo PDF
        return $this->view('emails.bienvenida')
                    ->with(['datos' => $this->datos])
                    ->attachData($pdfContent, 'facturaMensual_'.$this->datos->nombre.'.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
