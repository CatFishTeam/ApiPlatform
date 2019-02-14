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
use App\Entity\Model;
use App\Entity\Plane;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class PlaneFixtures extends Fixture implements OrderedFixtureInterface
{
    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $airline_companies = $manager->getRepository(AirlinesCompany::class)->findAll();
        $models = $manager->getRepository(Model::class)->findAll();

        for ($i = 0; $i < 10; $i++) {
            $plane = new Plane();
            $plane->setReference($faker->uuid);
            $airline_companiy = $airline_companies[array_rand($airline_companies, 1)];
            $plane->setAirlinesCompany($airline_companiy);
            $model = $models[array_rand($models, 1)];
            $plane->setModel($model);
            $manager->persist($plane);
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
        return 7;
    }
}
