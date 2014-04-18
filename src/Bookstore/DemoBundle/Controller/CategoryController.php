<?php

namespace Bookstore\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\Query;

class CategoryController extends Controller {

    /**
     * @Route("/categories/{parentId}", name="bookstore_demo_categories", options={"expose"=true} )
     */
    public function subcategoriesAction($parentId) {        
        $response = new JsonResponse();
        $response->setData($this->findSubcategories($parentId));
        return $response;
    }

    private function findSubcategories($parentId) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("BookstoreDemoBundle:Category")
                ->createQueryBuilder('c')
                ->where('c.parent = :parentId')
                ->setParameter('parentId', $parentId);
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

}
