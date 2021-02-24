<?php

namespace App\Tests;

use App\DataFixtures\AppFixtures;
use Doctrine\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class AppFixtureTest extends TestCase
{
    public function testSomething(): void
    {
        $appFixtures = new AppFixtures();
        $objectManager = $this->createMock(ObjectManager::class);
        $appFixtures->load($objectManager);
        self::assertTrue(true);
    }
}
