<?php

namespace Bookstore\DemoBundle\Repository;

use Doctrine\ORM\EntityRepository;

class BookRepository extends EntityRepository {

    public function booksCount() {
        $qb = $this->createQueryBuilder('b')->
                select('count(b.id)');

        return $qb->getQuery()->getSingleScalarResult();
    }

}
