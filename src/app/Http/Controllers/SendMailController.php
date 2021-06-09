<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Services\Interfaces\InterfaceSendMailService;
use Illuminate\Http\JsonResponse;

class SendMailController extends Controller
{
    protected InterfaceSendMailService $mailService;

    public function __construct(InterfaceSendMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param SendMailRequest $request
     * @return JsonResponse
     */
    public function send(SendMailRequest $request): JsonResponse
    {
        $this->mailService->send($request);
        return response()->json([
            'message' => 'Your messages has been queued successfully!',
            'data' => [],
        ], 200);
    }
}
