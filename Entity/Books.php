<?php

namespace LibraryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Books
 *
 * @ORM\Table(name="books")
 * @ORM\Entity(repositoryClass="LibraryBundle\Repository\BooksRepository")
 */
class Books
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="cover_url", type="string", length=255)
     */
    private $coverUrl;

    /**
     * @var string
     *
     * @ORM\Column(name="isbn", type="string", length=255)
     */
    private $isbn;

    /**
     * @ORM\ManyToOne(targetEntity="Publishers", inversedBy="books")
     * @ORM\JoinColumn(name="publisher", referencedColumnName="id")
     */
    private $publisher;

    /**
     * @ORM\ManyToOne(targetEntity="Authors", inversedBy="books")
     * @ORM\JoinColumn(name="author", referencedColumnName="id")
     */
    private $author;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Books
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
     * Set description
     *
     * @param string $description
     *
     * @return Books
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set coverUrl
     *
     * @param string $coverUrl
     *
     * @return Books
     */
    public function setCoverUrl($coverUrl)
    {
        $this->coverUrl = $coverUrl;

        return $this;
    }

    /**
     * Get coverUrl
     *
     * @return string
     */
    public function getCoverUrl()
    {
        return $this->coverUrl;
    }

    /**
     * Set isbn
     *
     * @param string $isbn
     *
     * @return Books
     */
    public function setIsbn($isbn)
    {
        $this->isbn = $isbn;

        return $this;
    }

    /**
     * Get isbn
     *
     * @return string
     */
    public function getIsbn()
    {
        return $this->isbn;
    }

    /**
     * @return object
     */
    public function getPublisher() {
      return $this->publisher;
    }

    /**
     * @param mixed $publisher
     */
    public function setPublisher($publisher) {
      $this->publisher = $publisher;
    }

    /**
     * @return object
     */
    public function getAuthor() {
      return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author) {
      $this->author = $author;
    }
}
