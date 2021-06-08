<?php

namespace App\Console\Commands;

use App\Services\Interfaces\InterfaceSendMailService;
use Illuminate\Console\Command;
use Illuminate\Http\Request;

class SendMailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:mail {subject} {body} {from_email} {tos?*} {--from_name=} {--ccs=*} {--bccs=*}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail {from_email} {subject} {body} {tos?*} {--from_name=} {--ccs=*} {--bccs=*}';

    /**
     * The Mail Service to send message
     * @var InterfaceSendMailService
     */
    protected InterfaceSendMailService $mailService;

    /**
     * Create a new command instance.
     *
     * @param InterfaceSendMailService $mailService
     */
    public function __construct(InterfaceSendMailService $mailService)
    {
        $this->mailService = $mailService;
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
            'to' => collect($arguments['tos'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
            'cc' => collect($options['ccs'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
            'bcc' => collect($options['bccs'])->map(function ($to) {
                return json_decode($to, true);
            })->values()->all(),
        ];

        $request = new Request($data);

        $this->mailService->send($request);
        return 1;
    }
}
