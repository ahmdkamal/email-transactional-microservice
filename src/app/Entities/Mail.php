<?php

namespace App\Entities;

use Illuminate\Support\Arr;

class Mail
{
    public string $body = 'Hello World';

    public string $contentType = 'text/plain';

    public string $subject = 'Hello World';

    public array $from = [];

    public array $tos = [];

    public array $ccs = [];

    public array $bcs = [];

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
     * @param array|string $addresses
     * @return $this
     */
    public function to(array|string $addresses): Mail
    {
        $this->tos = array_merge($this->tos, $this->parseAddresses($addresses));

        return $this;
    }

    /**
     * Set Mail's cc
     * @param array|string $addresses
     * @return $this
     */
    public function cc(array|string $addresses): Mail
    {
        $this->ccs = array_merge($this->tos, $this->parseAddresses($addresses));

        return $this;
    }

    /**
     * Set Mail's bcc
     * @param array|string $addresses
     * @return $this
     */
    public function bcc(array|string $addresses): Mail
    {
        $this->bcs = array_merge($this->bcs, $this->parseAddresses($addresses));

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
}
