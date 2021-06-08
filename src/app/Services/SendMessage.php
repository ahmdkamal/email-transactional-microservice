<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceSendMessage;
use App\Services\Interfaces\Mailer;

class SendMessage implements InterfaceSendMessage
{
    protected Mail $mail;

    protected Mailer $mailer;

    public function setMail(Mail $mail): SendMessage
    {
        $this->mail = $mail;
        return $this;
    }

    public function setMailServer(Mailer $mailer): SendMessage
    {
        $this->mailer = $mailer;
        return $this;
    }

    public function send(): bool
    {
        if ($this->mailer->send($this->mail)) {
            return true;
        }
        return false;
    }
}
