<?php

namespace App\Tests;

use Symfony\Component\Panther\Client as PantherClient;
use Symfony\Component\Panther\PantherTestCase;

class WebRollbackTest extends PantherTestCase
{
    private PantherClient $client;

    public function setUp(): void
    {
        $this->client = self::createPantherClient(
            [],
            [],
            [
                'capabilities' => [
                    'goog:loggingPrefs' => [
                        'browser' => 'ALL', // calls to console.* methods
                        'performance' => 'ALL', // performance data
                    ],
                ],
            ]
        );
    }
    public function testSomething1(): void
    {
        $this->client->request('GET', '/create-user');

        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(1, $numberOfUsers);
    }

    public function testSomething2(): void
    {
        $this->client->request('GET', '/create-user');

        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(1, $numberOfUsers);
    }

    public function testSomething3(): void
    {
        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(0, $numberOfUsers);
    }

    public function testSomething4(): void
    {
        $this->client->request('GET', '/create-user');

        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(1, $numberOfUsers);
    }
}
