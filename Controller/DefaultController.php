<?php

namespace LibraryBundle\Controller;

use LibraryBundle\Entity\Publisher;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use LibraryBundle\Entity\Authors;
use LibraryBundle\Entity\Publishers;
use LibraryBundle\Entity\Books;

use Symfony\Component\Finder\Finder;

use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('LibraryBundle:Default:index.html.twig');
    }

    /**
     * @Route("/authors/list", name="Get Authors")
     * @Method("GET")
     */
    public function getAuthorsAction()
    {
      try {
        $em = $this->getDoctrine()->getManager();
        $authors = $em->getRepository('LibraryBundle:Authors')->findAll();

        $data = [];
        foreach ($authors as $author){
          $data[] = (object)[
            'id'         => $author->getId(),
            'first_name' => $author->getFirstName(),
            'last_name'  => $author->getLastName(),
          ];
        }

        $final_data = (object)[
          'authors' => $data
        ];

        $response = new Response(json_encode($final_data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * @Route("/authors/{id}", name="Get Author")
     * @Method("GET")
     */
    public function getAuthorAction($id)
    {
      try {
        $em = $this->getDoctrine()->getManager();
        $author = $em->getRepository('LibraryBundle:Authors')->find($id);

        $data = (object)[
          'id'         => $author->getId(),
          'first_name' => $author->getFirstName(),
          'last_name'  => $author->getLastName(),
        ];

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * @Route("/publishers/list", name="Get Publishers")
     * @Method("GET")
     */
    public function getPublishersAction()
    {
      try {
        $em = $this->getDoctrine()->getManager();
        $publishers = $em->getRepository('LibraryBundle:Publishers')->findAll();

        $data = [];
        foreach ($publishers as $publisher){
          $data[] = (object)[
            'id'   => $publisher->getId(),
            'name' => $publisher->getName(),
          ];
        }

        $final_data = (object)[
          'publishers' => $data
        ];

        $response = new Response(json_encode($final_data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

    /**
     * @Route("/publishers/{id}", name="Get Publisher")
     * @Method("GET")
     */
    public function getPublisherAction($id)
    {
      try {
        $em = $this->getDoctrine()->getManager();
        $publisher = $em->getRepository('LibraryBundle:Publishers')->find($id);

        $data = (object)[
          'id'   => $publisher->getId(),
          'name' => $publisher->getName(),
        ];

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
      } catch (\Exception $e) {
        return $e->getMessage();
      }
    }

  /**
   * @Route("/books/highlighted/{offset}/{limit}", name="Get Books")
   * @Method("GET")
   */
  public function getBooksAction($offset=0, $limit=50)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $total = count($em->getRepository('LibraryBundle:Books')->findAll());
      $books = $em->getRepository('LibraryBundle:Books')->findBy([],[],$limit, $offset);

      $data = [];
      foreach ($books as $book){
        $data[] = (object)[
          'id'          => $book->getId(),
          'title'       => $book->getTitle(),
          'description' => $book->getDescription(),
          'cover_url'   => $book->getCoverUrl(),
          'isbn'        => $book->getIsbn(),
          'publisher'   => [
            'id'   => $book->getPublisher()->getId(),
            'name' => $book->getPublisher()->getName(),
          ],
          'author'      => [
            'id'         => $book->getAuthor()->getId(),
            'first_name' => $book->getAuthor()->getFirstName(),
            'last_name'  => $book->getAuthor()->getLastName(),
          ],
        ];
      }

      $final_data = (object)[
        'books'  => $data,
        'offset' => (integer) $offset,
        'limit'  => (integer) $limit,
        'total'  => (integer) $total,
      ];

      $response = new Response(json_encode($final_data));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  /**
   * @Route("/books/{id}", name="Get Book")
   * @Method("GET")
   */
  public function getBookAction($id)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $book = $em->getRepository('LibraryBundle:Books')->find($id);

      $data = (object)[
        'id'          => $book->getId(),
        'title'       => $book->getTitle(),
        'description' => $book->getDescription(),
        'cover_url'   => $book->getCoverUrl(),
        'isbn'        => $book->getIsbn(),
        'publisher'   => [
          'id'   => $book->getPublisher()->getId(),
          'name' => $book->getPublisher()->getName(),
        ],
        'author'      => [
          'id'         => $book->getAuthor()->getId(),
          'first_name' => $book->getAuthor()->getFirstName(),
          'last_name'  => $book->getAuthor()->getLastName(),
        ],
      ];

      $response = new Response(json_encode($data));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }

  /**
   * @Route("/books/search/{title}/{offset}/{limit}", name="Search Books")
   * @Method("GET")
   */
  public function searchAction($title, $offset=0, $limit=50)
  {
    try {
      $em = $this->getDoctrine()->getManager();
      $books = $em->getRepository('LibraryBundle:Books')->findBy(['title' => $title],[],$limit, $offset);
      $total = count($books);

      $data = [];
      foreach ($books as $book){
        $data[] = (object)[
          'id'          => $book->getId(),
          'title'       => $book->getTitle(),
          'description' => $book->getDescription(),
          'cover_url'   => $book->getCoverUrl(),
          'isbn'        => $book->getIsbn(),
          'publisher'   => [
            'id'   => $book->getPublisher()->getId(),
            'name' => $book->getPublisher()->getName(),
          ],
          'author'      => [
            'id'         => $book->getAuthor()->getId(),
            'first_name' => $book->getAuthor()->getFirstName(),
            'last_name'  => $book->getAuthor()->getLastName(),
          ],
        ];
      }

      $final_data = (object)[
        'books'  => $data,
        'offset' => $offset,
        'limit'  => $limit,
        'total'  => $total,
      ];

      $response = new Response(json_encode($final_data));
      $response->headers->set('Content-Type', 'application/json');

      return $response;
    } catch (\Exception $e) {
      return $e->getMessage();
    }
  }
}
