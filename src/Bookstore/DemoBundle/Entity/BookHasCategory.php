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
     * @ORM\ManyToOne(targetEntity="Bookstore\DemoBundle\Entity\Book", inversedBy="categoriesWithPriority")
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



    /**
     * Set priority
     *
     * @param integer $priority
     * @return BookHasCategory
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;

        return $this;
    }

    /**
     * Get priority
     *
     * @return integer 
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set book
     *
     * @param \Bookstore\DemoBundle\Entity\Book $book
     * @return BookHasCategory
     */
    public function setBook(\Bookstore\DemoBundle\Entity\Book $book = null)
    {
        $this->book = $book;

        return $this;
    }

    /**
     * Get book
     *
     * @return \Bookstore\DemoBundle\Entity\Book 
     */
    public function getBook()
    {
        return $this->book;
    }

    /**
     * Set category
     *
     * @param \Bookstore\DemoBundle\Entity\Category $category
     * @return BookHasCategory
     */
    public function setCategory(\Bookstore\DemoBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Bookstore\DemoBundle\Entity\Category 
     */
    public function getCategory()
    {
        return $this->category;
    }
}
