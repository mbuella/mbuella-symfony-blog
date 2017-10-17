<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Nelmio\Alice\Persister\Doctrine;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
		$objects = \Nelmio\Alice\Fixtures::load(__DIR__.'/fixtures.yml', $manager);

		// persist to database
		$persister = new Doctrine($manager);
		$persister->persist($objects);
    }
}