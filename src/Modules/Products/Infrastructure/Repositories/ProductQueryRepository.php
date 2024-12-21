<?php
declare (strict_types=1);

namespace App\Modules\Products\Infrastructure\Repositories;

use App\Modules\Products\Domain\Repositories\ProductQueryRepositoryInterface;
use App\Modules\Products\Domain\Entities\Product;
use App\Shared\Enums\SortDirection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
class ProductQueryRepository extends ServiceEntityRepository implements ProductQueryRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function prepareSortedQuery(SortDirection $sortDirection, ?string $sortBy = null): Query
    {
        $query = $this->createQueryBuilder('p');

        if ($sortBy === null) {
            return $query->getQuery();
        }

        if (!in_array($sortBy, $this->getClassMetadata()->getFieldNames())) {
            throw new \InvalidArgumentException('Invalid field to sort by');
        }

        return $query
            ->orderBy('p.' . $sortBy, $sortDirection->value)
            ->getQuery();
    }
}
