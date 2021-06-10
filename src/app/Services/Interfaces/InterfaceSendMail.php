<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface InterfaceSendMail
{
    /**
     * @param Mail $mail
     * @return bool
     */
    public function send(Mail $mail): bool;
}
