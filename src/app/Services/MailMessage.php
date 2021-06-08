<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\Mailer;

class MailMessage
{
    protected Mail $mail;

    protected Mailer $mailer;

    public function __construct(Mail $mail)
    {
        $this->mail = $mail;
    }

    public function setMailServer(Mailer $mailer): void
    {
        $this->mailer = $mailer;
    }

    public function send(): bool
    {
        if ($this->mailer->send($this->mail)) {
            return true;
        }
        return false;
    }
}
