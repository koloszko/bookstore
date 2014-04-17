<?php

namespace Bookstore\DemoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class BookController extends Controller {

    private $booksPerPage = 10;
    private $pagesStepsAvailable = 3;
    
    /**
     * @Route("/books/{page}", defaults={"page" = 1}, name="bookstore_demo_book_list" )
     * @Template
     */
    public function listAction($page) {          
        $repository = $this->getDoctrine()->getManager()->getRepository("BookstoreDemoBundle:Book");
        $booksCount = $repository->booksCount();
                      
        if ($page == 0) {
            $page = 1;
        }
        $pagesAmount = round($booksCount/$this->booksPerPage);
        if ($page > $pagesAmount) {
            $page = $pagesAmount;
        }
        
        $bookList = $repository->findBy(array(), null, $this->booksPerPage, ($page -  1) * $this->booksPerPage);
        return array(
            'books' => $bookList,
            'showPaginator' => $repository->booksCount() > $this->booksPerPage,
            'page' => $page,
            'pagesStepsAvailable' => $this->pagesStepsAvailable,
            'perPage' => $this->booksPerPage,
            'pagesAmount' => $pagesAmount
        );
    }
        
}
