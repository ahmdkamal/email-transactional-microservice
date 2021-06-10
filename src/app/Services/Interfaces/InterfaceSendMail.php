<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface InterfaceSendMail
{
    /**
     * @param Mail $mail
     * @return InterfaceSendMail
     */
    public function setMail(Mail $mail): InterfaceSendMail;

    /**
     * @param Mailer $mailer
     * @return InterfaceSendMail
     */
    public function setMailServer(Mailer $mailer): InterfaceSendMail;

    /**
     * @return bool
     */
    public function send(): bool;
}
