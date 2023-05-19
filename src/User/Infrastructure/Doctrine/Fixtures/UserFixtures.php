<?php

namespace App\User\Infrastructure\Doctrine\Fixtures;

use App\User\Domain\User;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Ramsey\Uuid\Uuid;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        foreach (range(1, 100000) as $item) {
            $timestamp = mt_rand(1, time());
            $manager->persist(new User(
                id: Uuid::uuid4(),
                username: 'username' . $this->getRandomString(7),
                email: 'email' . $item . '@example.com',
                validts: (new DateTimeImmutable())->modify('+3 days')->setTime(0,0,0),
                confirmed: rand(0, 1) === 1,
            ));
            if ($item % 10000 === 0) {
                $manager->flush();
            }
        }
        $manager->flush();
    }

    function getRandomString(int $n): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }
}
