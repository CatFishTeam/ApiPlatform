<?php
/**
 * Created by IntelliJ IDEA.
 * User: robin
 * Date: 02/10/18
 * Time: 16:25
 */

namespace App\DataFixtures;

use App\Entity\Location;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures extends Fixture implements OrderedFixtureInterface
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $locations = $manager->getRepository(Location::class)->findAll();
        $user = new User();
        $user->setFirstname("root");
        $user->setLastname("admin");
        $user->setEmail("mael.mayon@free.fr");
        $encoded = $this->passwordEncoder->encodePassword($user, "root");
        $user->setPassword($encoded);
        $user->setBirthdate($faker->dateTime);
        $user->setPhone($faker->phoneNumber);
        $user->setRoles(["ROLE_ADMIN"]);
        $location = $locations[array_rand($locations, 1)];
        $user->setAddress($location);
        $manager->persist($user);

        for ($i = 0; $i < 10; $i++) {
            $user = new User();
            $user->setFirstname($faker->name);
            $user->setLastname($faker->lastName);
            $user->setEmail($faker->email);
            $encoded = $this->passwordEncoder->encodePassword($user, $faker->password);
            $user->setPassword($encoded);
            $user->setBirthdate($faker->dateTime);
            $user->setPhone($faker->phoneNumber);
            $user->setRoles(["ROLE_PASSENGER"]);
            $location = $locations[array_rand($locations, 1)];
            $user->setAddress($location);
            $manager->persist($user);
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
        return 9;
    }
}
