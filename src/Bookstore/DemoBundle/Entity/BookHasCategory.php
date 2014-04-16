<?php

namespace Bookstore\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="books_has_categories", indexes={@ORM\Index(name="id_books", columns={"id_books"}), @ORM\Index(name="id_categories", columns={"id_categories"})})
 * @ORM\Entity
 */
class BookHasCategory
{
    /**
     * @var integer
     *
     * @ORM\Column(name="priority", type="integer", nullable=false)
     */
    private $priority;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Bookstore\DemoBundle\Entity\Book")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_books", referencedColumnName="id")
     * })
     */
    private $book;

    /**
     *
     * @ORM\ManyToOne(targetEntity="Bookstore\DemoBundle\Entity\Category")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_categories", referencedColumnName="id")
     * })
     */
    private $category;


}
