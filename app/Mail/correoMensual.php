<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\Cliente;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


/**
 * Clase correoMensual
 *
 * Esta clase representa un correo electrónico mensual que se envía a un cliente con su factura adjunta en formato PDF.
 *
 * @package App\Mail
 */
class correoMensual extends Mailable
{


    use Queueable, SerializesModels;

    /** @var Cliente $datos Los datos del cliente para los que se genera la factura */

    protected $datos;

    /** @var string $pdfContent El contenido del PDF adjunto */
    protected $pdfContent;


    /**
     * Crea una nueva instancia del mensaje.
     *
     * @param Cliente $datos Los datos del cliente
     * @param string $pdfContent El contenido del PDF adjunto
     */
    public function __construct(Cliente $datos, $pdfContent)
    {
        $this->datos = $datos;
        $this->pdfContent = $pdfContent;
    }
    /**
     * Obtiene el sobre del mensaje.
     *
     * @return Envelope
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Correo Mensual',
        );
    }


    /**
     * Obtiene los archivos adjuntos para el mensaje.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }



    /**
     * Construye el mensaje.
     *
     * @return $this
     */
    public function build()
    {
        $pdfContent = $this->pdfContent->output();

        // Adjunta los datos renderizados como un archivo PDF
        return $this->view('emails.bienvenida')
            ->with(['datos' => $this->datos])
            ->attachData($pdfContent, 'facturaMensual_' . $this->datos->nombre . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
