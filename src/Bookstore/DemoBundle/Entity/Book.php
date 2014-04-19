<?php

namespace Bookstore\DemoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="Bookstore\DemoBundle\Repository\BookRepository")
 */
class Book
{
    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=200, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="author", type="string", length=100, nullable=false)
     */
    private $author;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2, nullable=false)
     */
    private $price;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    
    /**
     * @ORM\OneToMany(targetEntity="BookHasCategory", mappedBy="book")
     **/
    private $categoriesWithPriority;

    /**
     * Set title
     *
     * @param string $title
     * @return Book
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set author
     *
     * @param string $author
     * @return Book
     */
    public function setAuthor($author)
    {
        $this->author = $author;

        return $this;
    }

    /**
     * Get author
     *
     * @return string 
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * Set price
     *
     * @param string $price
     * @return Book
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string 
     */
    public function getPrice()
    {
        return $this->price;
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
     * Constructor
     */
    public function __construct()
    {
        $this->categoriesWithPriority = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add categoriesWithPriority
     *
     * @param \Bookstore\DemoBundle\Entity\BookHasCategory $categoriesWithPriority
     * @return Book
     */
    public function addCategoriesWithPriority(\Bookstore\DemoBundle\Entity\BookHasCategory $categoriesWithPriority)
    {
        $this->categoriesWithPriority[] = $categoriesWithPriority;

        return $this;
    }

    /**
     * Remove categoriesWithPriority
     *
     * @param \Bookstore\DemoBundle\Entity\BookHasCategory $categoriesWithPriority
     */
    public function removeCategoriesWithPriority(\Bookstore\DemoBundle\Entity\BookHasCategory $categoriesWithPriority)
    {
        $this->categoriesWithPriority->removeElement($categoriesWithPriority);
    }

    /**
     * Get categoriesWithPriority
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCategoriesWithPriority()
    {
        return $this->categoriesWithPriority;
    }
}
