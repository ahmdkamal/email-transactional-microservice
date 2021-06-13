<?php

namespace Tests\Unit;

use App\Entities\Mail;
use App\Services\Interfaces\InterfaceSendMail;
use App\Services\MailServers\Mailjet;
use App\Services\MailServers\Sendgrid;
use Tests\TestCase;

class SendMailTest extends TestCase
{
    protected InterfaceSendMail $sendMail;

    public function setUp(): void
    {
        parent::setUp();
        $this->sendMail = $this->app->get(InterfaceSendMail::class);
    }

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
        $this->sendMail
            ->setMainServer($mainService);

        $this->assertTrue($this->sendMail->send(new Mail));
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

        $this->sendMail
            ->setMainServer($mainService)
            ->setFallbackServers([$fallbackService]);

        $this->assertTrue($this->sendMail->send(new Mail));
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

        $this->sendMail
            ->setMainServer($mainService)
            ->setFallbackServers([$fallbackService]);

        $this->assertFalse($this->sendMail->send(new Mail));
    }
}
