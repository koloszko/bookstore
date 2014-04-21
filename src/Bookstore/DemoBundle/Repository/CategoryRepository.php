<?php

namespace Bookstore\DemoBundle\Repository;

use Doctrine\ORM\Query;

class CategoryRepository extends \Gedmo\Tree\Entity\Repository\NestedTreeRepository {

    public function findSubcategories($parentId) {
        $qb = $this->createQueryBuilder('c');
        if ($parentId > 0) {
            $qb->where('c.parent = :parentId')
                    ->setParameter('parentId', $parentId);
        } else {
            $qb->where('c.parent is null');
        }
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }
}
