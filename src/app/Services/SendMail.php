<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceSendMail;
use App\Services\Interfaces\Mailer;

class SendMail implements InterfaceSendMail
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
    public function setMail(Mail $mail): SendMail
    {
        $this->mail = $mail;
        return $this;
    }

    /**
     * @param Mailer $mailer
     * @return $this
     */
    public function setMailServer(Mailer $mailer): SendMail
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
