<?php

namespace App\Repository;

use App\Entity\VinylMix;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VinylMix>
 *
 * @method VinylMix|null find($id, $lockMode = null, $lockVersion = null)
 * @method VinylMix|null findOneBy(array $criteria, array $orderBy = null)
 * @method VinylMix[]    findAll()
 * @method VinylMix[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinylMixRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VinylMix::class);
    }

    public function save(VinylMix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VinylMix $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * @param string|null $genre
     * @param string|null $sortOrder ASC or DESC order (ascending default)
     * @return QueryBuilder Returns an array of VinylMix objects
     */
    public function createOrderedByVotesQueryBuilder(string $genre = null, string $sortOrder=null): QueryBuilder
    {
        $queryBuilder =  $this->addOrderByVotesQueryBuilder(($sortOrder) ? $sortOrder : 'ASC');

        if ($genre)
            $queryBuilder
                ->andWhere('mix.genre = :genre')
                ->setParameter('genre',$genre);

        return $queryBuilder;

    }


    /**
     * @param string $sortOrder Ascending or Descending order
     * @return QueryBuilder Returns a QueryBuilder object. Creates one if
     * one isn't supplied
     */
    private function addOrderByVotesQueryBuilder (string $sortOrder):QueryBuilder{

        $queryBuilder = $queryBuild ?? $this->createQueryBuilder('mix');

        return $queryBuilder->orderBy('mix.votes', strtoupper($sortOrder) );

    }
//    public function findOneBySomeField($value): ?VinylMix
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
