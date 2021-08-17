<?php

namespace App\Repository;

use App\Entity\Actu;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Actu|null find($id, $lockMode = null, $lockVersion = null)
 * @method Actu|null findOneBy(array $criteria, array $orderBy = null)
 * @method Actu[]    findAll()
 * @method Actu[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActuRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Actu::class);
    }

    // /**
    //  * @return Actu[] Returns an array of Actu objects
    //  */
    
    public function sideActu()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.id', 'DESC')
            ->setMaxResults(4)
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?Actu
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
