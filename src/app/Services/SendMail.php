<?php

namespace App\Services;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceMailable;
use App\Services\Interfaces\InterfaceSendMail;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;

class SendMail implements InterfaceSendMail
{
    /**
     * @var InterfaceMailable
     */
    protected InterfaceMailable $mailable;

    /**
     * SendMail constructor.
     * @param InterfaceMailable $mailable
     */
    public function __construct(InterfaceMailable $mailable)
    {
        $this->mailable = $mailable;
    }

    /**
     * @param Mail $mail
     * @return bool
     */
    public function send(Mail $mail): bool
    {
        // Build mail servers ( Sendgrid, Mailjet, etc.. )
        // First one to be handle with new key
        // Any further servers should be handled by linkWith
        // You can manager the order you need if the server failed to send
        // Ex: (new Sendgrid('XXXX')->linkWith(new Mailjet('XXXX', 'XXX'))
        // Will check sendgrid first if failed, it will try Mailjet
        $servers = new Sendgrid();
        $servers->linkWith(new Mailjet());

        $this->mailable
            ->setMail($mail)
            ->setMailServer($servers);

        return $this->mailable->send();
    }
}
