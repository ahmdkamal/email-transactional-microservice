<?php

namespace App\Services\MailServers;

use App\Entities\Mail;
use App\Services\Interfaces\Mailer;
use \SendGrid\Mail\Mail as SendGridMail;

class Sendgrid extends Mailer
{
    protected string $apiKey;

    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function send(Mail $mail): bool
    {
        try {
            $email = $this->buildEMailObject($mail);
            $response = new \SendGrid($this->apiKey);
            $response = $response->send($email);

            throw_if(!in_array($response->statusCode(), [200, 202]), new \Exception('Something went wrong!'));

            return true;
        } catch (\Exception $exception) {

        }

        return parent::send($mail);
    }

    /**
     * @param Mail $mail
     * @return SendGridMail
     * @throws \SendGrid\Mail\TypeException
     */
    protected function buildEmailObject(Mail $mail): SendGridMail
    {
        $email = new SendGridMail();
        $email->setSubject($mail->subject);
        $email->setFrom($mail->from[0], $mail->from[1]);
        $email->addContent($mail->contentType, $mail->body);
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
        if (!is_null($mail->bcs) && $mail->bcs !== []) {
            $email->addBccs($mail->bcs);
        }

        return $email;
    }
}
