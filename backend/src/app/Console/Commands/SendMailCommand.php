<?php

namespace App\Console\Commands;

use App\Http\Requests\SendMailRequest;
use App\Services\Interfaces\SendMailServiceInterface;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail {subject} {body} {from_email} {to?*} {--from_name=} {--cc=*} {--bcc=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail {from_email} {subject} {body} {to?*} {--from_name=} {--cc=*} {--bcc=*}';

    /**
     * SendMailCommand constructor.
     * @param SendMailServiceInterface $mailService
     */
    public function __construct(protected SendMailServiceInterface $mailService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $options = $this->options();
        $arguments = $this->arguments();

        $data = [
            'subject' => $arguments['subject'],
            'body' => $arguments['body'],
            'from_email' => $arguments['from_email'],
            'from_name' => $options['from_name'],
            'to' => collect($arguments['to'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
            'cc' => collect($options['cc'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
            'bcc' => collect($options['bcc'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
        ];

        $request = new SendMailRequest($data);

        $validator = Validator::make($request->all(), $request->rules());

        throw_if($validator->fails(), new ValidationException($validator));

        $this->mailService->send($request);

        return 1;
    }
}
