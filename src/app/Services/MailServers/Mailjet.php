<?php

namespace App\Services\MailServers;

use App\Entities\Mail;
use App\Services\Interfaces\Mailer;
use Illuminate\Support\Facades\Log;
use \Mailjet\Client as MailJetClient;
use Mailjet\Resources;

class Mailjet extends Mailer
{
    protected string $apiKey;

    protected string $apiSecret;

    public function __construct(string $apiKey, string $apiSecret)
    {
        $this->apiKey = $apiKey;
        $this->apiSecret = $apiSecret;
    }

    public function send(Mail $mail): bool
    {
        try {
            Log::info('We are in Mailjet');
            $mailJetClient = new MailJetClient($this->apiKey, $this->apiSecret, true, ['version' => 'v3.1']);
            $body = $this->buildEmailObject($mail);
            $response = $mailJetClient->post(Resources::$Email, ['body' => $body]);
            throw_if(!$response->success(), new \Exception('Something went wrong!'));
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }

        return parent::send($mail);
    }

    /**
     * @param Mail $mail
     * @return array[]
     */
    protected function buildEmailObject(Mail $mail): array
    {
        $body = [
            'From' => [
                'Email' => $mail->from[0],
            ],
            'To' => [],
            'Bcc' => [],
            'Cc' => [],
            'Subject' => $mail->subject,
        ];

        if (isset($mail->from[1])) {
            $body['From'] += ['Name' => $mail->from[1]];
        }

        $body['To'] = $this->buildReception($mail->tos);
        $body['Bcc'] = $this->buildReception($mail->bcs);
        $body['Cc'] = $this->buildReception($mail->ccs);

        if ($mail->contentType === 'text/plain') {
            $body['TextPart'] = $mail->body;
        }

        if ($mail->contentType === 'text/html') {
            $body['HTMLPart'] = $mail->body;
        }

        return ['Messages' => [$body]];
    }

    /**
     * Build To, Cc, Bcc
     * @param array $receptions
     * @return array
     */
    protected function buildReception(array $receptions): array
    {
        $data = [];

        foreach ($receptions as $reception) {
            $user = [];
            $user['Email'] = $reception[0];

            if (isset($to[1])) {
                $user['Name'] = $to[1];
            }

            $data[] = $user;
        }

        return $data;
    }
}
