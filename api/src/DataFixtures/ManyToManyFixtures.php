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
use App\Entity\Flight;
use App\Entity\Gate;
use App\Entity\Journey;
use App\Entity\Luggage;
use App\Entity\Model;
use App\Entity\Plane;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ManyToManyFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $journeys = $manager->getRepository(Journey::class)->findAll();
        $users = $manager->getRepository(User::class)->findAll();
        $flights = $manager->getRepository(Flight::class)->findAll();
        $luggages = $manager->getRepository(Luggage::class)->findAll();

        for ($i = 0; $i < count($journeys); $i++) {
            $it_flights = rand(1, 2);
            for ($y = 0; $y < $it_flights; $y++) {
                $flight = $flights[array_rand($flights, 1)];
                $journey = $journeys[$i];
                $journey->addFlight($flight);
                $manager->persist($journey);
            }
        }
        for ($i = 0; $i < count($flights); $i++) {
            $it_passengers = rand(1, count($users) / 2);
            for ($y = 0; $y < $it_passengers; $y++) {
                $passenger = $users[array_rand($users, 1)];
                $luggage = $luggages[array_rand($luggages, 1)];
                $flight = $flights[$i];
                $flight->addPassenger($passenger);
                $flight->addLuggage($luggage);
                $manager->persist($flight);
        }
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
        return 12;
    }
}
