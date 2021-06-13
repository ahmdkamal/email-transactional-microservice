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
     * SendMailService constructor.
     * @param EmailRepositoryInterface $emailRepository
     */

    public function __construct(protected EmailRepositoryInterface $emailRepository)
    {
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

        SendMailJob::dispatch($email->id);
    }
}
