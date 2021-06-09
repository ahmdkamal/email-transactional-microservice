<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface InterfaceSendMailService
{
    /**
     * @param Request $request
     */
    public function send(Request $request): void;
}
