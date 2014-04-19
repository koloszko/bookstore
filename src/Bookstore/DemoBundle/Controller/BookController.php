<?php

namespace Bookstore\DemoBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Bookstore\DemoBundle\Controller\CRUDController;
use Bookstore\DemoBundle\Entity\Book;
use Bookstore\DemoBundle\Form\BookType;

class BookController extends CRUDController {    

    private $booksPerPage = 10;
    private $pagesStepsAvailable = 3;
    private $formType;
    protected $redirectUrl = 'bookstore_demo_book_list';

    /**
     * @Route("/books/add", name="bookstore_demo_book_add" )
     * @Template("BookstoreDemoBundle:Book:edit.html.twig")
     */
    public function addAction(Request $request) {
        $book = new Book();
        $this->formType = self::ADD;
        return $this->handleFormProcessing($request, $book);
    }

    /**
     * @Route("/books/edit/{id}", name="bookstore_demo_book_edit" )
     * @Template
     */
    public function editAction(Request $request, $id) {
        $book = $this->getRepository("BookstoreDemoBundle:Book")->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Nie znaleziono książki');
        }
        $this->formType = self::EDIT;
        return $this->handleFormProcessing($request, $book);
    }

    protected function buildForm($book) {
        if ($this->formType === self::ADD) {
            $actionUrl = $this->generateUrl('bookstore_demo_book_add');
        } else {
            $actionUrl = $this->generateUrl('bookstore_demo_book_edit', array('id' => $book->getId()));
        }

        $form = $this->createForm(new BookType(), $book, array('action' => $actionUrl));
        $form->add('submit', 'submit', array('label' => 'Zapisz'));
        return $form;
    }

    /**
     * @Route("/books/{page}", defaults={"page" = 1}, name="bookstore_demo_book_list" , options={"expose"=true})
     * @Method({"GET"})
     * @Template
     */
    public function listAction(Request $request, $page) {
        if ($page == 0) {
            $page = 1;
        }

        $searchForm = $this->buildSearchForm();
        $searchForm->handleRequest($request);
        $criteria = array();
        if ($searchForm->isValid()) {
            $criteria = $searchForm->getData();
        }

        $mainCategories = $this->getRepository("BookstoreDemoBundle:Category")->findByParent(NULL);

        $bookRepository = $this->getRepository("BookstoreDemoBundle:Book");
        $bookList = $bookRepository->findBooks($criteria, $this->booksPerPage, ($page - 1) * $this->booksPerPage);
        $booksCount = $bookRepository->booksCount($criteria);

        $pagesAmount = round($booksCount / $this->booksPerPage);
        if ($page > $pagesAmount) {
            $page = $pagesAmount;
        }

        $renderArray = array(
            'books' => $bookList,
            'categories' => $mainCategories,
            'searchForm' => $searchForm->createView(),
            'showPaginator' => $booksCount > $this->booksPerPage,
            'page' => $page,
            'criteria' => $criteria,
            'pagesStepsAvailable' => $this->pagesStepsAvailable,
            'perPage' => $this->booksPerPage,
            'pagesAmount' => $pagesAmount
        );
        if ($request->isXmlHttpRequest()) {
            return $this->render(
                            'BookstoreDemoBundle:Book:table_with_filter.html.twig', $renderArray
            );
        }
        return $renderArray;
    }

    private function getRepository($entityName) {
        return $this->getDoctrine()->getManager()->getRepository($entityName);
    }

    private function buildSearchForm() {
        return $this->get('form.factory')->createNamedBuilder(null, 'form', array(), array(
                            'csrf_protection' => false,
                        ))
                        ->setAction($this->generateUrl('bookstore_demo_book_list'))
                        ->setMethod('GET')
                        ->add('priceFrom', 'text', array('label' => "Cena od", 'required' => false))
                        ->add('priceTo', 'text', array('label' => "Cena do", 'required' => false))
                        ->add('categoryId', 'hidden', array('required' => false))
                        ->add('filter', 'submit', array('label' => "Filtruj"))
                        ->getForm();
    }

}
