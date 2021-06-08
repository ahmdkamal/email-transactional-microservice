<?php

namespace App\Services;

use App\Entities\Mail;
use Illuminate\Http\Request;

class MailService
{
    // Send ( Request $request )

    public function send(Request $request)
    {
        // Prepare Mail Object ( $body, $subject, User $to, Users $from, Users $cc )

        $mail = (new Mail())
            ->subject($request->subject)
            ->body($request->body)
            ->from($request->from_email, $request->from_name)
            ->to($request->to)
            ->cc($request->cc)
            ->bcc($request->bcc);


    }
}
