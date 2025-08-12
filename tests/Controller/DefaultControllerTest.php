<?php

namespace App\Tests\Controller;

use App\Test\AbstractWebTestCase;

final class DefaultControllerTest extends AbstractWebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        self::assertResponseIsSuccessful();

        $this->assertSelectorTextContains('title', 'Home');
    }
}
