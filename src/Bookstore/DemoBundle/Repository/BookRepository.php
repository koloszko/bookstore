<?php

namespace Bookstore\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository {

    public function booksCount($criteria) {
        $qb = $this->prepareQueryBuilder($criteria)
                ->select('count(b.id)');
        return $qb->getQuery()->getSingleScalarResult();
    }

    public function findBooks(array $criteria, $limit = 10, $firstResult = 0) {
        $qb = $this->prepareQueryBuilder($criteria)
                ->setFirstResult($firstResult)
                ->setMaxResults($limit);
        return $qb->getQuery()->getResult();
    }

    private function prepareQueryBuilder(array $criteria) {
        $qb = $this->createQueryBuilder('b');
        if (isset($criteria['priceFrom'])) {
            $qb->andWhere('b.price >= :priceFrom')
                    ->setParameter('priceFrom', $criteria['priceFrom']);
        }
        if (isset($criteria['priceTo'])) {
            $qb->andWhere('b.price <= :priceTo')
                    ->setParameter('priceTo', $criteria['priceTo']);
        }
        if (isset($criteria['categoryId'])) {
            $qb->join('b.categoriesWithPriority', 'cp', 'WITH', 'cp.category = :categoryId')
                    ->setParameter('categoryId', $criteria['categoryId']);
        }
        return $qb;
    }

}
