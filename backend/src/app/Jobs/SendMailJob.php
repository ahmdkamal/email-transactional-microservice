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
     * @var SendMailInterface
     */
    protected SendMailInterface $sendMessage;

    /**
     * @var EmailRepositoryInterface
     */
    protected EmailRepositoryInterface $emailRepository;

    /**
     * @var int
     */
    protected int $emailId;

    /**
     * SendMailJob constructor.
     * @param SendMailInterface $sendMessage
     * @param EmailRepositoryInterface $emailRepository
     * @param int $emailId
     */
    public function __construct(
        SendMailInterface $sendMessage,
        EmailRepositoryInterface $emailRepository,
        int $emailId
    )
    {
        $this->sendMessage = $sendMessage;
        $this->emailRepository = $emailRepository;
        $this->emailId = $emailId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = $this->emailRepository->findById($this->emailId);

        $mail = (new Mail())
            ->subject($email->subject)
            ->body($email->body)
            ->from($email->from_email, $email->from_name)
            ->to($email->to)
            ->cc($email->cc)
            ->bcc($email->bcc);

        $status = $this->sendMessage->send($mail);

        $email->fill([
            'status' => $status ? Email::STATUSES['Delivered'] : Email::STATUSES['Bounced'],
        ]);

        $this->emailRepository->save($email);
    }
}
