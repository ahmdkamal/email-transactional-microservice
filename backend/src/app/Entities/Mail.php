<?php

namespace App\Entities;

use Illuminate\Support\Arr;

class Mail
{
    public string $body = 'Hello World';

    public string $contentType = 'text/plain';

    public string $subject = 'Hello World';

    public array $from = [];

    public array $to = [];

    public array $cc = [];

    public array $bcc = [];

    /**
     * Set Mail's Subject
     * @param string $subject
     * @return $this
     */
    public function subject(string $subject): Mail
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * Set Mail's Body
     * @param string $body
     * @return $this
     */
    public function body(string $body): Mail
    {
        $this->body = $body;
        $this->contentType = 'text/plain';

        return $this;
    }

    /**
     * Set Mail's Body
     * @param string $view
     * @param array $compactValues
     * @return $this
     */
    public function view(string $view, array $compactValues): Mail
    {
        $this->body = view($view, $compactValues)->render();
        $this->contentType = 'text/html';

        return $this;
    }

    /**
     * Set Mail's from
     * @param string $email
     * @param string|null $name
     * @return $this
     */
    public function from(string $email, string $name = null): Mail
    {
        $this->from = [$email, $name];

        return $this;
    }

    /**
     * Set Mail's to
     * @param array|null|string $addresses
     * @return $this
     */
    public function to(array|null|string $addresses): Mail
    {
        $this->to = array_merge($this->to, $this->parseAddresses($addresses));

        return $this;
    }

    /**
     * Set Mail's cc
     * @param array|null|string $addresses
     * @return $this
     */
    public function cc(array|null|string $addresses): Mail
    {
        $this->cc = array_merge($this->cc, $this->parseAddresses($addresses));

        return $this;
    }

    /**
     * Set Mail's bcc
     * @param array|null|string $addresses
     * @return $this
     */
    public function bcc(array|null|string $addresses): Mail
    {
        $this->bcc = array_merge($this->bcc, $this->parseAddresses($addresses));

        return $this;
    }

    /**
     * Return addresses as array even if string is sent
     * @param $addresses
     * @return array
     */
    protected function parseAddresses($addresses): array
    {
        return is_array($addresses) ? collect($addresses)->map(function (array $address) {
            return [$address['email'], Arr::has($address, 'name') && is_string($address['name']) ? $address['name'] : null];
        })->values()->all() : [];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'from_email' => $this->from[0],
            'from_name' => $this->from[1],
            'subject' => $this->subject,
            'body' => $this->body,
            'content_type' => $this->contentType,
            'tos' => $this->to,
            'ccs' => $this->cc,
            'bcc' => $this->bcc,
        ];
    }
}
