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
use App\Entity\Luggage;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class LuggageFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $users = $manager->getRepository(User::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $luggage = new Luggage();
            $luggage->setNumber($faker->numberBetween(1, 5));
            $luggage->setWeight($faker->randomFloat(1, 1, 20));
            $user = array_pop($users);
            $luggage->setPassenger($user);
            $manager->persist($luggage);
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
        return 10;
    }
}
