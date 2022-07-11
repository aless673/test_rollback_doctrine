<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class FunctionalRollbackTest extends KernelTestCase
{
    public function testSomething1(): void
    {
        static::getContainer()->get('doctrine.dbal.default_connection')->insert('user', [
            'last_name' => 'Peter',
            'first_name' => 'Alex',
        ]);

        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(1, $numberOfUsers);
    }

    public function testSomething2(): void
    {
        static::getContainer()->get('doctrine.dbal.default_connection')->insert('user', [
            'last_name' => 'Peter',
            'first_name' => 'Alex',
        ]);

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
        static::getContainer()->get('doctrine.dbal.default_connection')->insert('user', [
            'last_name' => 'Peter',
            'first_name' => 'Alex',
        ]);

        $numberOfUsers = (int) static::getContainer()->get('doctrine.dbal.default_connection')->fetchOne('SELECT COUNT(*) FROM user');
        self::assertSame(1, $numberOfUsers);
    }
}
