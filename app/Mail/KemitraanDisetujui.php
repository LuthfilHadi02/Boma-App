<?php

namespace App\Mail;

use App\Models\Mitra;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class KemitraanDisetujui extends Mailable
{
    use Queueable, SerializesModels;

    public $mitra; // 🟢 Variabel penampung data profil mitra

    // Tangkap data lemparan dari MitraApprovalController
    public function __construct(Mitra $mitra)
    {
        $this->mitra = $mitra;
    }

    // Set Judul/Subjek Surat Emailnya pas masuk ke HP Mitra
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Selamat! Pengajuan Kemitraan GOR BOMA Disetujui 🎉',
        );
    }

    // Arahkan ke file HTML kertas surat kita di folder views
    public function content(): Content
    {
        return new Content(
            view: 'emails.kemitraan-disetujui',
        );
    }
}