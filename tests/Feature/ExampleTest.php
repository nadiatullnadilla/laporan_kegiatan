<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_the_application_redirects_to_the_login_page()
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_the_session_cookie_expires_when_the_browser_closes()
    {
        $this->assertTrue(config('session.expire_on_close'));
    }
}
