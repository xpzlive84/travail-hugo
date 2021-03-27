<?php

namespace App\Repository;

use App\Entity\Prospect;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Prospect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prospect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prospect[]    findAll()
 * @method Prospect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProspectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prospect::class);
    }

    // /**
    //  * @return Prospect[] Returns an array of Prospect objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prospect
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param DateTime $dateDebut
     * @param DateTime $dateFin
     * @return Prospect[]
     */
    public function findByDate(DateTime $dateDebut,DateTime $dateFin):array{
        return $this->createQueryBuilder('p')
            ->andWhere('p.date >= :dateDebut')
            ->andWhere('p.date <= :dateFin')
            ->setParameter('dateDebut',$dateDebut)
            ->setParameter('dateFin',$dateFin)
            ->orderBy('p.date','DESC')
            ->getQuery()
            ->getResult();
    }
}