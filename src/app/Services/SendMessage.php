<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceSendMessage;
use App\Services\Interfaces\Mailer;

class SendMessage implements InterfaceSendMessage
{
    /**
     * @var Mail
     */
    protected Mail $mail;

    /**
     * @var Mailer
     */
    protected Mailer $mailer;

    /**
     * @param Mail $mail
     * @return $this
     */
    public function setMail(Mail $mail): SendMessage
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @param Mailer $mailer
     * @return $this
     */
    public function setMailServer(Mailer $mailer): SendMessage
    {
        $this->mailer = $mailer;
        return $this;
    }

    /**
     * @return bool
     */
    public function send(): bool
    {
        if ($this->mailer->send($this->mail)) {
            return true;
        }
        return false;
    }
}
