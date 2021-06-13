<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\MailServerInterface;
use App\Services\Interfaces\SendMailInterface;

class SendMail implements SendMailInterface
{
    /**
     * @var array <InterfaceMailServer>
     */
    protected array $fallbackServers;

    /**
     * @var MailServerInterface
     */
    protected MailServerInterface $mainServer;

    /**
     * SendMail constructor.
     * @param MailServerInterface $mainServer
     * @param array<MailServerInterface> $fallbackServers
     */
    public function __construct(MailServerInterface $mainServer, array $fallbackServers)
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

    /**
     * To Set the main server to send with
     *
     * @param MailServerInterface $mainServer
     * @return $this
     */
    public function setMainServer(MailServerInterface $mainServer): SendMail
    {
        $this->mainServer = $mainServer;
        return $this;
    }

    /**
     * To Set the fallback servers
     * @param array<SendMail> $fallbackServers
     * @return $this
     */
    public function setFallbackServers(array $fallbackServers): SendMail
    {
        $this->fallbackServers = $fallbackServers;
        return $this;
    }
}
