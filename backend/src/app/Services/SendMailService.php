<?php

namespace App\Services;

use App\Jobs\SendMailJob;
use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Services\Interfaces\SendMailInterface;
use App\Services\Interfaces\SendMailServiceInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class SendMailService implements SendMailServiceInterface
{
    /**
     * @var EmailRepositoryInterface
     */
    protected EmailRepositoryInterface $emailRepository;

    /**
     * @var SendMail
     */
    protected SendMailInterface $sendMail;

    /**
     * SendMailService constructor.
     * @param EmailRepositoryInterface $emailRepository
     * @param SendMail $sendMail
     */
    public function __construct(
        EmailRepositoryInterface $emailRepository,
        SendMailInterface $sendMail
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
        throw_if(!$this->emailRepository->save($email), new \Exception('Something went wrong!', 500));

        SendMailJob::dispatch($this->sendMail, $this->emailRepository, $email->id);
    }
}
