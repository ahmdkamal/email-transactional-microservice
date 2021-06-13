<?php

namespace App\Http\Controllers;

use App\Http\Requests\SendMailRequest;
use App\Http\Resources\MailCollection;
use App\Services\Interfaces\SendMailServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SendMailController extends Controller
{
    /**
     * SendMailController constructor.
     * @param SendMailServiceInterface $mailService
     */
    public function __construct(protected SendMailServiceInterface $mailService)
    {

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
