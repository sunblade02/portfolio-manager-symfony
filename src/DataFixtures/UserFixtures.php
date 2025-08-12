<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('john.doe@example.com');
        $user->setPassword('$2b$12$jodXlOL.vRegGN.PQAghqOtgkj9/XmU8SqaPvrDOcDcgEduj7griS');
        $manager->persist($user);

        $user = new User();
        $user->setEmail('jane.smith@example.com');
        $user->setPassword('$2b$12$jodXlOL.vRegGN.PQAghqOtgkj9/XmU8SqaPvrDOcDcgEduj7griS');
        $manager->persist($user);

        $manager->flush();
    }
}
