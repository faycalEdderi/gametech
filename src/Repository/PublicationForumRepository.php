<?php

namespace App\Repository;

use App\Entity\PublicationForum;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method PublicationForum|null find($id, $lockMode = null, $lockVersion = null)
 * @method PublicationForum|null findOneBy(array $criteria, array $orderBy = null)
 * @method PublicationForum[]    findAll()
 * @method PublicationForum[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PublicationForumRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, PublicationForum::class);
    }

    // /**
    //  * @return PublicationForum[] Returns an array of PublicationForum objects
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
    public function findOneBySomeField($value): ?PublicationForum
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
