<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    /**
     * @return Product[] Returns an array of Product objects
     */
    public function findByMinimumValue(int $value): array
    {
        $query = $this->createQueryBuilder('p')
            ->andWhere('p.value >= :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->getQuery();

        /** @var Product[] $result */
        $result = $query->getResult();

        return $result;  // Ensure this returns Product[]
    }

    /**
     * @return array<int, array<string, mixed>> Returns an array of associative arrays (i.e. a raw data set)
     */
    public function findByMinimumValue2(int $value): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT * FROM product p
            WHERE p.value >= :value
            ORDER BY p.id ASC
            ';
        $stmt = $conn->prepare($sql);
        $resultSet = $stmt->executeQuery(['value' => $value]);

        // returns an array of arrays (i.e. a raw data set)
        return $resultSet->fetchAllAssociative();
    }
}
