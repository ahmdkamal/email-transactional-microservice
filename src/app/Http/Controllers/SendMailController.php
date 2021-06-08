<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Services\Interfaces\InterfaceSendMailService;

class SendMailController extends Controller
{
    protected InterfaceSendMailService $mailService;

    public function __construct(InterfaceSendMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    public function send(SendMailRequest $request)
    {
        $this->mailService->send($request);
        return response()->json([
            'message' => 'Your messages has been queued successfully!',
            'data' => [],
        ], 200);
    }
}
