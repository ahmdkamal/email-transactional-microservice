<?php

namespace App\Services\MailServers;

use App\Entities\Mail;
use App\Services\Interfaces\MailServerInterface;
use Illuminate\Support\Facades\Log;
use \SendGrid\Mail\Mail as SendGridMail;

class Sendgrid implements MailServerInterface
{
    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * Sendgrid constructor.
     */
    public function __construct()
    {
        $this->apiKey = env('SENDGRID_API_KEY', '');
    }

    /**
     * @param Mail $mail
     * @return bool
     * @throws \Throwable
     */
    public function send(Mail $mail): bool
    {
        try {
            $email = $this->buildEMailObject($mail);
            $response = new \SendGrid($this->apiKey);
            $response = $response->send($email);

            throw_if(!in_array($response->statusCode(), [200, 202]), new \Exception('Something went wrong!'));

            return true;
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
            Log::info($exception->getLine());
        }

        return false;
    }

    /**
     * @param Mail $mail
     * @return SendGridMail
     * @throws \SendGrid\Mail\TypeException
     */
    public function buildEmailObject(Mail $mail): SendGridMail
    {
        $email = new SendGridMail();
        $email->setSubject($mail->subject);
        $email->setFrom($mail->from[0], $mail->from[1]);
        $email->addContent($mail->contentType, $mail->body);

        foreach ($mail->tos as $to) {
            $email->addTo($to[0], $to[1]);
        }

        if (!is_null($mail->ccs) && $mail->ccs !== []) {
            foreach ($mail->ccs as $cc) {
                $email->addCc($cc[0], $cc[1]);
            }
        }

        if (!is_null($mail->bcs) && $mail->bcs !== []) {
            foreach ($mail->bcs as $bc) {
                $email->addBcc($bc[0], $bc[1]);
            }
        }

        return $email;
    }
}
