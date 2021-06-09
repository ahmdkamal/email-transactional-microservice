<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

abstract class Mailer
{
    /**
     * @var Mailer|null
     */
    private ?Mailer $next = null;

    /**
     * This method can be used to build a chain of mailer objects.
     * @param Mailer $next
     * @return Mailer
     */
    public function linkWith(Mailer $next): Mailer
    {
        $this->next = $next;
        return $next;
    }

    /**
     * @param Mail $mail
     * @return bool
     */
    public function send(Mail $mail): bool
    {
        if (!$this->next) {
            return false;
        }

        return $this->next->send($mail);
    }

    /**
     * @param Mail $mail
     * @return mixed
     */
    protected abstract function buildEmailObject(Mail $mail);
}
