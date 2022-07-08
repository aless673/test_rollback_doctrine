<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class TestitTest extends KernelTestCase
{
    public function testSomething(): void
    {
        static::getContainer()->get('doctrine.dbal.default_connection')->insert('user', [
            'last_name' => 'Peter',
            'first_name' => 'Alex',
        ]);
    }
}
