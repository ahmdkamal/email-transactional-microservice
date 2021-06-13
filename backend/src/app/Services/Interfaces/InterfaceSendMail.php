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

    /**
     * To Set the main server to send with
     * @param InterfaceMailServer $mainServer
     * @return InterfaceSendMail
     */
    public function setMainServer(InterfaceMailServer $mainServer): InterfaceSendMail;

    /**
     * To Set the fallback servers
     * @param array<InterfaceSendMail> $fallbackServers
     * @return $this
     */
    public function setFallbackServers(array $fallbackServers): InterfaceSendMail;
}
