<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceMailable;
use App\Services\Interfaces\Mailer;

class Mailable implements InterfaceMailable
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
    public function setMail(Mail $mail): Mailable
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @param Mailer $mailer
     * @return $this
     */
    public function setMailServer(Mailer $mailer): Mailable
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
