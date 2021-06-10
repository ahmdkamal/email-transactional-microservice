<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceMailServer;
use App\Services\Interfaces\InterfaceSendMail;

class SendMail implements InterfaceSendMail
{
    /**
     * @var array <InterfaceMailServer>
     */
    protected array $fallbackServers;

    /**
     * @var InterfaceMailServer
     */
    protected InterfaceMailServer $mainServer;

    /**
     * SendMail constructor.
     * @param InterfaceMailServer $mainServer
     * @param array<InterfaceMailServer> $fallbackServers
     */
    public function __construct(InterfaceMailServer $mainServer, array $fallbackServers)
    {
        $this->mainServer = $mainServer;
        $this->fallbackServers = $fallbackServers;
    }

    /**
     * @param Mail $mail
     * @return bool
     * @throws \Throwable
     */
    public function send(Mail $mail): bool
    {
        if ($this->mainServer->send($mail)) {
            return true;
        }

        foreach ($this->fallbackServers as $fallbackServer) {
            if ($fallbackServer->send($mail)) {
                return true;
            }
        }

        return false;
    }
}
