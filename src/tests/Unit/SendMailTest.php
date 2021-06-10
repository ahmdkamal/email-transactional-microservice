<?php

namespace Tests\Unit;

use App\Entities\Mail;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;
use App\Services\SendMail;
use Tests\TestCase;

class SendMailTest extends TestCase
{
    public function testMainServiceWillReturnTrue()
    {
        // Main
        $mainService = $this
            ->getMockBuilder(Sendgrid::class)
            ->getMock();

        $mainService
            ->method('send')
            ->willReturn(true);

        // Send Mail
        $sendMail = new SendMail($mainService, []);

        $this->assertTrue($sendMail->send(new Mail));
    }

    public function testMainServiceWillReturnFalseAndFallbackWillReturnTrue()
    {
        // Main
        $mainService = $this
            ->getMockBuilder(Sendgrid::class)
            ->getMock();

        $mainService
            ->method('send')
            ->willReturn(false);

        // Fallback
        $fallbackService = $this
            ->getMockBuilder(Mailjet::class)
            ->getMock();

        $fallbackService
            ->method('send')
            ->willReturn(true);

        // Send Mail
        $sendMail = new SendMail($mainService, [
            $fallbackService
        ]);

        $this->assertTrue($sendMail->send(new Mail));
    }

    public function testNoServiceWillReturnTrue()
    {
        // Main
        $mainService = $this
            ->getMockBuilder(Sendgrid::class)
            ->getMock();

        $mainService
            ->method('send')
            ->willReturn(false);

        // Fallback
        $fallbackService = $this
            ->getMockBuilder(Mailjet::class)
            ->getMock();

        $fallbackService
            ->method('send')
            ->willReturn(false);

        // Send Mail
        $sendMail = new SendMail($mainService, [
            $fallbackService
        ]);

        $this->assertFalse($sendMail->send(new Mail));
    }
}
