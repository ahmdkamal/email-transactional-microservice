<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendMailRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject' => 'required|string|min:3|max:255',
            'body' => 'required|max:384000',
            'from_email' => 'required|email',
            'from_name' => 'nullable|string|max:255',
            'to' => 'required|array|min:1',
            'to.*.email' => 'required|email',
            'to.*.name' => 'nullable|string|max:255',
            'cc' => 'array',
            'cc.*.email' => 'required|email',
            'cc.*.name' => 'nullable|string|max:255',
            'bcc' => 'array',
            'bcc.*.email' => 'required|email',
            'bcc.*.name' => 'nullable|string|max:255',
        ];
    }
}
