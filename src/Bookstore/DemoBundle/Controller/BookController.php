<?php

namespace Bookstore\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Bookstore\DemoBundle\Entity\Book;
use Bookstore\DemoBundle\Form\BookType;

class BookController extends Controller {

    const EDIT = 1;
    const ADD = 0;

    private $booksPerPage = 10;
    private $pagesStepsAvailable = 3;
    private $actionType;

    /**
     * @Route("/books/add", name="bookstore_demo_book_add" )
     * @Template("BookstoreDemoBundle:Book:edit.html.twig")
     */
    public function addAction(Request $request) {
        $book = new Book();
        $this->actionType = self::ADD;
        return $this->handleFormProcessing($request, $book);
    }

    /**
     * @Route("/books/edit/{id}", name="bookstore_demo_book_edit" )
     * @Template
     */
    public function editAction(Request $request, $id) {
        $book = $this->getRepository()->find($id);
        if (!$book) {
            throw $this->createNotFoundException('Nie znaleziono książki');
        }
        $this->actionType = self::EDIT;
        return $this->handleFormProcessing($request, $book);
    }

    private function handleFormProcessing(Request $request, Book $book) {
        $form = $this->buildForm($book, $this->actionType === self::ADD ? true : false);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->redirect($this->generateUrl('bookstore_demo_book_list'));
        }

        return array(
            'entity' => $book,
            'form' => $form->createView()
        );
    }

    private function buildForm(Book $book, $addForm = false) {
        if ($addForm) {
            $actionUrl = $this->generateUrl('bookstore_demo_book_add');
        } else {
            $actionUrl = $this->generateUrl('bookstore_demo_book_edit', array('id' => $book->getId()));
        }

        $form = $this->createForm(new BookType(), $book, array('action' => $actionUrl));
        $form->add('submit', 'submit', array('label' => 'Zapisz'));
        return $form;
    }

    /**
     * @Route("/books/{page}", defaults={"page" = 1}, name="bookstore_demo_book_list" )
     * @Method({"GET"})
     * @Template
     */
    public function listAction($page) {
        $repository = $this->getRepository();
        $booksCount = $repository->booksCount();

        if ($page == 0) {
            $page = 1;
        }
        $pagesAmount = round($booksCount / $this->booksPerPage);
        if ($page > $pagesAmount) {
            $page = $pagesAmount;
        }

        $bookList = $repository->findBy(array(), null, $this->booksPerPage, ($page - 1) * $this->booksPerPage);
        return array(
            'books' => $bookList,
            'showPaginator' => $booksCount > $this->booksPerPage,
            'page' => $page,
            'pagesStepsAvailable' => $this->pagesStepsAvailable,
            'perPage' => $this->booksPerPage,
            'pagesAmount' => $pagesAmount
        );
    }

    private function getRepository() {
        return $this->getDoctrine()->getManager()->getRepository("BookstoreDemoBundle:Book");
    }

}
