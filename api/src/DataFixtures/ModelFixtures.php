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
use App\Entity\Brand;
use App\Entity\Gate;
use App\Entity\Luggage;
use App\Entity\Model;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class ModelFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $brands = $manager->getRepository(Brand::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $model = new Model();
            $model->setNumberOfSeat($faker->numberBetween(100, 500));
            $model->setReference($faker->uuid);
            $model->setWeight($faker->randomFloat(1, 1, 20));
            $model->setLength($faker->numberBetween(100, 400));
            $model->setWidth($faker->numberBetween(10, 100));
            $brand = $brands[array_rand($brands, 1)];
            $model->setBrand($brand);
            $manager->persist($model);
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
        return 6;
    }
}
