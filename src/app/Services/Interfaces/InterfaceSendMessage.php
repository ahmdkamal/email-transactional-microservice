<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface InterfaceSendMessage
{
    public function setMail(Mail $mail): InterfaceSendMessage;

    public function setMailServer(Mailer $mailer): InterfaceSendMessage;

    public function send(): bool;
}
