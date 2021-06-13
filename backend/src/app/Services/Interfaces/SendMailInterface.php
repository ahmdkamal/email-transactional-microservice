<?php

namespace App\Services\Interfaces;

use App\Entities\Mail;

interface SendMailInterface
{
    /**
     * @param Mail $mail
     * @return bool
     */
    public function send(Mail $mail): bool;

    /**
     * To Set the main server to send with
     * @param MailServerInterface $mainServer
     * @return SendMailInterface
     */
    public function setMainServer(MailServerInterface $mainServer): SendMailInterface;

    /**
     * To Set the fallback servers
     * @param array<SendMailInterface> $fallbackServers
     * @return $this
     */
    public function setFallbackServers(array $fallbackServers): SendMailInterface;
}
