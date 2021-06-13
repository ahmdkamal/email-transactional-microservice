<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'body' => $this->body,
            'subject' => $this->subject,
            'from_email' => $this->from_email,
            'from_name' => $this->from_name ?? '',
            'to' => $this->to ?? [],
            'cc' => $this->cc ?? [],
            'bcc' => $this->bcc ?? [],
            'status' => $this->status_as_string,
            'created_at' => $this->created_at->diffForHumans(),
        ];
    }
}
