<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface InterfaceSendMessage
{
    /**
     * @param Mail $mail
     * @return InterfaceSendMessage
     */
    public function setMail(Mail $mail): InterfaceSendMessage;

    /**
     * @param Mailer $mailer
     * @return InterfaceSendMessage
     */
    public function setMailServer(Mailer $mailer): InterfaceSendMessage;

    /**
     * @return bool
     */
    public function send(): bool;
}
