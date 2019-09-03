<?php

namespace App\Repository;

use App\Entity\Edge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Edge|null find($id, $lockMode = null, $lockVersion = null)
 * @method Edge|null findOneBy(array $criteria, array $orderBy = null)
 * @method Edge[]    findAll()
 * @method Edge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EdgeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Edge::class);
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function findByMultipleIds(array $ids = array())
    {
        $qb = $this->createQueryBuilder('edge');
        $qb->select('n');
        $qb->from('App:Edge', 'e');
        $qb->where($qb->expr()->in('e.id', $ids));

        return $qb->getQuery()->getResult();
    }

    /**
     * @param array $ids
     * @return mixed
     */
    public function deleteByMultipleIds(array $ids = array())
    {
        $qb = $this->createQueryBuilder('edge')
            ->delete('App:Edge', 'e')
            ->where('e.id in (:ids)')
            ->setParameter(':ids', $ids);
        return $qb->getQuery()->execute();
    }

    // /**
    //  * @return Edge[] Returns an array of Edge objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Edge
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
