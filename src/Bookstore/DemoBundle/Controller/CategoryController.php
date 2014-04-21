<?php

namespace Bookstore\DemoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Bookstore\DemoBundle\Controller\CRUDController;
use Bookstore\DemoBundle\Entity\Category;
use Bookstore\DemoBundle\Form\CategoryType;
use Doctrine\ORM\Query;

class CategoryController extends CRUDController {

    protected $redirectUrl = 'bookstore_demo_book_list';

    /**
     * @Route("/categories/add", name="bookstore_demo_category_add" )
     * @Template("BookstoreDemoBundle:Category:edit.html.twig")
     */
    public function addAction(Request $request) {
        $category = new Category();
        $this->formType = self::ADD;
        return $this->handleFormProcessing($request, $category);
    }

    /**
     * @Route("/categories/edit/{id}", name="bookstore_demo_category_edit" )
     * @Template
     */
    public function editAction(Request $request, $id) {
        $category = $this->getRepository("BookstoreDemoBundle:Category")->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Nie znaleziono kategorii');
        }
        $this->formType = self::EDIT;
        return $this->handleFormProcessing($request, $category);
    }

    protected function buildForm($category) {
        if ($this->formType === self::ADD) {
            $actionUrl = $this->generateUrl('bookstore_demo_category_add');
        } else {
            $actionUrl = $this->generateUrl('bookstore_demo_category_edit', array('id' => $category->getId()));
        }

        $form = $this->createForm(new CategoryType(), $category, array('action' => $actionUrl));
        $form->add('submit', 'submit', array('label' => 'Zapisz'));
        return $form;
    }

    /**
     * @Route("/categories/{parentId}", defaults={"parentId" = 0}, name="bookstore_demo_categories", options={"expose"=true} )
     */
    public function subcategoriesAction($parentId) {
        $response = new JsonResponse();
        $response->setData($this->findSubcategories($parentId));
        return $response;
    }

    private function findSubcategories($parentId) {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->getRepository("BookstoreDemoBundle:Category")
                ->createQueryBuilder('c');
        if ($parentId > 0) {
            $qb->where('c.parent = :parentId')
                    ->setParameter('parentId', $parentId);
        } else {
            $qb->where('c.parent is null');
        }
        return $qb->getQuery()->getResult(Query::HYDRATE_ARRAY);
    }

}
