<?php

namespace App\Jobs;

use App\Entities\Mail;
use App\Models\Email;
use App\Repositories\Interfaces\EmailRepositoryInterface;
use App\Services\Interfaces\SendMailInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    protected int $emailId;

    /**
     * SendMailJob constructor.
     * @param int $emailId
     */
    public function __construct(int $emailId)
    {
        $this->emailId = $emailId;
    }

    /**
     * @param SendMailInterface $sendMail
     * @param EmailRepositoryInterface $emailRepository
     */
    public function handle(SendMailInterface $sendMail, EmailRepositoryInterface $emailRepository)
    {
        $email = $emailRepository->findById($this->emailId);

        $mail = (new Mail())
            ->subject($email->subject)
            ->body($email->body)
            ->from($email->from_email, $email->from_name)
            ->to($email->to)
            ->cc($email->cc)
            ->bcc($email->bcc);

        $status = $sendMail->send($mail);

        $email->fill([
            'status' => $status ? Email::DELIVERED_STATUS : Email::BOUNCED_STATUS,
        ]);

        $emailRepository->save($email);
    }
}
