<?php

namespace Tests\Feature;

use App\Jobs\SendMailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendMailCommandTest extends TestCase
{
    use RefreshDatabase;

    public function testCommandSentMailIsFailed()
    {
        $this->expectException(\Illuminate\Validation\ValidationException::class);
        $this->artisan('send:mail "Hello World Subject" "Hello World Body" "aka.3awd@gmail.com"');
    }

    public function testCommandSentMailIsSucceeded()
    {
        $this->artisan('send:mail "Hello World Subject" "Hello World Body"
        "aka.3awd@gmail.com" "{\"name\":\"Kamal\", \"email\": \"ahmad.kamal@sixtysixten.com\"}"
        "{\"name\":\"Kamal\", \"email\": \"ahmad.abukamal5@gmail.com\"}"
        ')->assertExitCode(1);
    }

    public function testCommandSentMailIsPushedToQueue()
    {
        Queue::fake();

        $this->artisan('send:mail "Hello World Subject" "Hello World Body"
        "aka.3awd@gmail.com" "{\"name\":\"Kamal\", \"email\": \"ahmad.kamal@sixtysixten.com\"}"
        "{\"name\":\"Kamal\", \"email\": \"ahmad.abukamal5@gmail.com\"}"
        ')->assertExitCode(1);

        Queue::assertPushed(SendMailJob::class);
    }
}
