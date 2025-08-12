<?php

namespace App\Tests\Controller;

use App\Test\AbstractWebTestCase;
use Symfony\Component\HttpFoundation\Response;

final class SecurityControllerTest extends AbstractWebTestCase
{
    // TC-001 - Authentication - Sign in : nominal scenario 
    public function testAuthenticationSignIn1(): void
    {
        $client = static::createClient();
        $this->loadFixtures();

        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $this->assertSelectorTextContains('title', 'Log in');

        $client->submitForm('Log in', [
            '_username' => 'john.doe@example.com',
            '_password' => 'password',
        ]);

        $this->assertResponseRedirects('/');
        $client->followRedirect();

        $this->assertResponseIsSuccessful();
    }

    // TC-002 - Authentication - Sign in : wrong password 
    public function testAuthenticationSignIn2(): void
    {
        $client = static::createClient();
        $this->loadFixtures();

        $client->request('GET', '/login');

        self::assertResponseIsSuccessful();

        $this->assertSelectorTextContains('title', 'Log in');

        $client->submitForm('Log in', [
            '_username' => 'john.doe@example.com',
            '_password' => 'passwordpassword',
        ]);

        $this->assertResponseRedirects('/login');
        $client->followRedirect();

        $this->assertSelectorTextContains('.notification.is-danger', 'Invalid credentials');
    }
}
