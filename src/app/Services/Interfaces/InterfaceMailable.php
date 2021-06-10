<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface InterfaceMailable
{
    /**
     * @param Mail $mail
     * @return InterfaceMailable
     */
    public function setMail(Mail $mail): InterfaceMailable;

    /**
     * @param Mailer $mailer
     * @return InterfaceMailable
     */
    public function setMailServer(Mailer $mailer): InterfaceMailable;

    /**
     * @return bool
     */
    public function send(): bool;
}
