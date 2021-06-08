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

    public function send(Mail $mail): bool
    {
        if (!$this->next) {
            return false;
        }

        return $this->next->send($mail);
    }

    protected abstract function buildEmailObject(Mail $mail);
}
