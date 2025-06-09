<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class DocumentVerified extends Notification
{
    public $status;

    public function __construct($status)
    {
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Status Verifikasi Dokumen')
            ->line($this->status === 'approved'
                ? 'Dokumen Anda telah disetujui.'
                : 'Dokumen Anda ditolak. Silakan unggah ulang.');
    }

    public function toArray($notifiable)
    {
        return [
            'status' => $this->status,
            'message' => $this->status === 'approved' ? 'Dokumen disetujui' : 'Dokumen ditolak',
        ];
    }
}
