<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Http\Resources\MailCollection;
use App\Services\Interfaces\InterfaceSendMailService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    /**
     * @var InterfaceSendMailService
     */
    protected InterfaceSendMailService $mailService;

    public function __construct(InterfaceSendMailService $mailService)
    {
        $this->mailService = $mailService;
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $data = $this->mailService->index($request);

        $data = array_merge([
            'message' => 'Success'
        ], (new MailCollection($data))->response()->getData(true));

        return response()->json($data,200);
    }

    /**
     * @param SendMailRequest $request
     * @return JsonResponse
     */
    public function store(SendMailRequest $request): JsonResponse
    {
        $this->mailService->send($request);
        return response()->json([
            'message' => 'Your messages has been queued successfully!',
            'data' => [],
        ], 201);
    }
}
