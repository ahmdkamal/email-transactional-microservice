<?php

namespace Tests\Feature;

use App\Jobs\SendMailJob;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class SendMailTest extends TestCase
{
    use RefreshDatabase;

    public function testHttpGetMailSuccess()
    {
        $response = $this->get('/api/v1/mails');

        $response->assertJsonStructure([
            'message',
            'data'
        ])->assertStatus(200);
    }

    public function testHttpGetMailFailure()
    {
        $response = $this->post('/api/v1/mails', [
            "body" => "Hello World",
            "subject" => "Hello World",
            "from_name" => "Ahmad Kamal",
            "to" => [
                [
                    "name" => "Kamal",
                    "email" => "ahmad.abukamal5@gmail.com"
                ]
            ],
            "cc" => [],
            "bcc" => []
        ]);

        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(422);
    }

    public function testHttpSentMailIsSucceeded()
    {
        // Send Request
        $response = $this->post('/api/v1/mails', [
            "body" => "Hello World",
            "subject" => "Hello World",
            "from_name" => "Ahmad Kamal",
            "from_email" => "aka.3awd@gmail.com",
            "to" => [
                [
                    "name" => "Kamal",
                    "email" => "ahmad.abukamal5@gmail.com"
                ]
            ],
            "cc" => [],
            "bcc" => []
        ]);

        // Assert Structure
        $response->assertJsonStructure([
            'message',
            'data'
        ])->assertStatus(201);
    }

    public function testHttpSentMailIsPushedInQueue()
    {
        Queue::fake();

        // Send Request
        $response = $this->post('/api/v1/mails', [
            "body" => "Hello World",
            "subject" => "Hello World",
            "from_name" => "Ahmad Kamal",
            "from_email" => "aka.3awd@gmail.com",
            "to" => [
                [
                    "name" => "Kamal",
                    "email" => "ahmad.abukamal5@gmail.com"
                ]
            ],
            "cc" => [],
            "bcc" => []
        ]);

        // Asset Job is pushed or not
        Queue::assertPushed(SendMailJob::class);
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

    public function testHttpGetMailSuccessWithPaginationAfterInserting()
    {
        $get = $this->get('/api/v1/mails?per_page=1');
        $this->assertTrue($get->json('data') === []);

        // Send Request
        $post = $this->post('/api/v1/mails', [
            "body" => "Hello World",
            "subject" => "Hello World",
            "from_name" => "Ahmad Kamal",
            "from_email" => "aka.3awd@gmail.com",
            "to" => [
                [
                    "name" => "Kamal",
                    "email" => "ahmad.abukamal5@gmail.com"
                ]
            ],
            "cc" => [],
            "bcc" => []
        ]);


        // Send Request
        $post = $this->post('/api/v1/mails', [
            "body" => "Hello World",
            "subject" => "Hello World",
            "from_name" => "Ahmad Kamal",
            "from_email" => "aka.3awd@gmail.com",
            "to" => [
                [
                    "name" => "Kamal",
                    "email" => "ahmad.abukamal5@gmail.com"
                ]
            ],
            "cc" => [],
            "bcc" => []
        ]);

        $get = $this->get('/api/v1/mails?per_page=1');

        $this->assertTrue(count($get->json('data')) === 1);
        $this->assertTrue($get->json('meta.total') === 2);
    }

}
