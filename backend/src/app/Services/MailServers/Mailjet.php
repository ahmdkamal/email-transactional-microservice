<?php

namespace App\Services\MailServers;

use App\Entities\Mail;
use App\Services\Interfaces\MailServerInterface;
use Illuminate\Support\Facades\Log;
use \Mailjet\Client as MailJetClient;
use Mailjet\Resources;

class Mailjet implements MailServerInterface
{
    /**
     * @var string
     */
    protected string $apiKey;

    /**
     * @var string
     */
    protected string $apiSecret;

    /**
     * Mailjet constructor.
     */
    public function __construct()
    {
        $this->apiKey = env('MailJET_KEY', '');
        $this->apiSecret = env('MailJET_SECRET', '');
    }

    /**
     * @param Mail $mail
     * @return bool
     * @throws \Throwable
     */
    public function send(Mail $mail): bool
    {
        try {
            Log::info('We are in Mailjet');
            $mailJetClient = new MailJetClient($this->apiKey, $this->apiSecret, true, ['version' => 'v3.1']);
            $body = $this->buildEmailObject($mail);
            $response = $mailJetClient->post(Resources::$Email, ['body' => $body]);
            throw_if(!$response->success(), new \Exception('Something went wrong!'));

            return true;
        } catch (\Exception $exception) {
            Log::info($exception->getMessage());
        }

        return false;
    }

    /**
     * @param Mail $mail
     * @return array[]
     */
    public function buildEmailObject(Mail $mail): array
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
