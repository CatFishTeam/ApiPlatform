<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 24/10/18
 * Time: 16:18
 */

namespace App\DataFixtures;


use App\Entity\AirlinesCompany;
use App\Entity\Location;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class AirlineCompanyFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $locations = $manager->getRepository(Location::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $airlineCie = new AirlinesCompany();
            $airlineCie->setName($faker->company);
            $location = $locations[array_rand($locations, 1)];
            $airlineCie->setHeadquarterLocation($location);
            $manager->persist($airlineCie);
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
        return 4;
    }
}
