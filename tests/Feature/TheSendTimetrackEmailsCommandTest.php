<?php

namespace Tests\Feature;

use Tests\TestCase;

class TheSendTimetrackEmailsCommandTest extends TestCase
{
    public function test_send_timetrack_emails_command(): void
    {
        $this->artisan('inspire')->assertExitCode(0);
    }
}
