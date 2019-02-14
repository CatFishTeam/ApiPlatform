<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 24/10/18
 * Time: 16:18
 */

namespace App\DataFixtures;


use App\Entity\AirlinesCompany;
use App\Entity\Airport;
use App\Entity\Gate;
use App\Entity\Journey;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class JourneyFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < 10; $i++) {
            $journey = new Journey();
            $journey->setReference($faker->uuid);
            $journey->setStartingDate($faker->dateTime);
            $journey->setEndingDate($faker->dateTime);
            $manager->persist($journey);
        }
        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    public function getOrder()
    {
        return 11;
    }
}
