<?php

namespace App\Services\Interfaces;

use Illuminate\Http\Request;

interface InterfaceSendMailService
{
    public function send(Request $request): void;
}
