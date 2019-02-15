<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 24/10/18
 * Time: 16:18
 */

namespace App\DataFixtures;


use App\Entity\Airport;
use App\Entity\Flight;
use App\Entity\Gate;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FlightFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $gates = $manager->getRepository(Gate::class)->findAll();
        $planes = $manager->getRepository(Plane::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $airports = $manager->getRepository(Airport::class)->findAll();
            $flight = new Flight();
            $flight->setReference($faker->uuid);
            $airport_dep = array_pop($airports);
            $airport_dest = $airports[array_rand($airports, 1)];
            $flight->setAirportDeparture($airport_dep);
            $flight->setAirportDestination($airport_dest);
            $flight->setDepartureDate($faker->dateTime);
            $flight->setArrivalDate($faker->dateTime);
            $gate = $gates[array_rand($gates, 1)];
            $plane = $planes[array_rand($planes, 1)];
            $flight->setGate($gate);
            $flight->setPlane($plane);
            $manager->persist($flight);
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
        return 8;
    }
}
