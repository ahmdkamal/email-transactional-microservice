<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Models\Email;
use App\Repositories\Interfaces\InterfaceEmailRepository;
use App\Services\Interfaces\InterfaceSendMail;
use App\Services\Interfaces\InterfaceSendMailService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SendMailService implements InterfaceSendMailService
{
    /**
     * @var InterfaceEmailRepository
     */
    protected InterfaceEmailRepository $emailRepository;

    /**
     * @var InterfaceSendMail
     */
    protected InterfaceSendMail $sendMail;

    /**
     * SendMailService constructor.
     * @param InterfaceEmailRepository $emailRepository
     * @param InterfaceSendMail $sendMail
     */
    public function __construct(
        InterfaceEmailRepository $emailRepository,
        InterfaceSendMail $sendMail
    )
    {
        $this->emailRepository = $emailRepository;
        $this->sendMail = $sendMail;
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
        $email = new Email($request->all() + ['content_type' => 'text/plain']);
        $this->emailRepository->save($email);

        SendMailJob::dispatch($this->sendMail, $this->emailRepository, $email->id);
    }
}
