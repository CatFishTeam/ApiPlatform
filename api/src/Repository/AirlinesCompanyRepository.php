<?php

namespace App\Repository;

use App\Entity\AirlinesCompany;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AirlinesCompany|null find($id, $lockMode = null, $lockVersion = null)
 * @method AirlinesCompany|null findOneBy(array $criteria, array $orderBy = null)
 * @method AirlinesCompany[]    findAll()
 * @method AirlinesCompany[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AirlinesCompanyRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AirlinesCompany::class);
    }

    // /**
    //  * @return AirlinesCompany[] Returns an array of AirlinesCompany objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?AirlinesCompany
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
