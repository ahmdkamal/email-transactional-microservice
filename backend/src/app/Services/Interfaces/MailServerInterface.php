<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface MailServerInterface
{
    /**
     * @param Mail $mail
     * @return bool
     */
    public function send(Mail $mail): bool;

    /**
     * @param Mail $mail
     * @return mixed
     */
    public function buildEmailObject(Mail $mail);
}
