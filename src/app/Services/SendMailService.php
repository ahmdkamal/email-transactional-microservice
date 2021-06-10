<?php

namespace App\Services;

use App\Entities\Mail;
use App\Jobs\SendMailJob;
use App\Models\Email;
use App\Repositories\Interfaces\InterfaceEmailRepository;
use App\Services\Interfaces\InterfaceSendMailService;
use App\Services\Interfaces\InterfaceSendMessage;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SendMailService implements InterfaceSendMailService
{
    /**
     * @var InterfaceSendMessage
     */
    protected InterfaceSendMessage $sendMessage;

    /**
     * @var InterfaceEmailRepository
     */
    protected InterfaceEmailRepository $emailRepository;

    /**
     * SendMailService constructor.
     * @param InterfaceSendMessage $sendMessage
     * @param InterfaceEmailRepository $emailRepository
     */
    public function __construct(
        InterfaceSendMessage $sendMessage,
        InterfaceEmailRepository $emailRepository
    )
    {
        $this->sendMessage = $sendMessage;
        $this->emailRepository = $emailRepository;
    }

    /**
     * @param Request $request
     * @return LengthAwarePaginator
     */
    public function index(Request $request): LengthAwarePaginator
    {
        return $this->emailRepository->index($request->per_page ?? 15);
    }

    /**
     * @param Request $request
     */
    public function send(Request $request): void
    {
        // Build mail object ( from, to, bcc, cc, subject, body)
        $mail = (new Mail())
            ->subject($request->subject)
            ->body($request->body)
            ->from($request->from_email, $request->from_name)
            ->to($request->to)
            ->cc($request->cc)
            ->bcc($request->bcc);

        // Build mail servers ( Sendgrid, Mailjet, etc.. )
        // First one to be handle with new key
        // Any further servers should be handled by linkWith
        // You can manager the order you need if the server failed to send
        // Ex: (new Sendgrid('XXXX')->linkWith(new Mailjet('XXXX', 'XXX'))
        // Will check sendgrid first if failed, it will try Mailjet
        $servers = new Sendgrid();
        $servers->linkWith(new Mailjet());

        $this->sendMessage
            ->setMail($mail)
            ->setMailServer($servers);

        $email = new Email($mail->toArray());
        $this->emailRepository->save($email);

        SendMailJob::dispatch($this->sendMessage, $this->emailRepository, $email->id);
    }
}
