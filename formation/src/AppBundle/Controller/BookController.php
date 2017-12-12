<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Book;
use AppBundle\Entity\category;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Form\BookType;
use AppBundle\Form\CategoryType;

class BookController extends Controller
{
	
    /**
     * @Route("/bookstore/books", name="listBook")
     */
    public function listAction()
    {
		$em = $this->getDoctrine();

		$bookRepository = $em->getRepository(Book::class);
		$books = $bookRepository->findAll();

        return $this->render('AppBundle:Book:list.html.twig', array(
            'books' => $books
        ));
	}
	
    /**
     * @Route("/bookstore/books/search", name="searchBook")
     */
    public function searchAction(Request $request)
    {
		$em = $this->getDoctrine();

		$bookRepository = $em->getRepository(Book::class);
		$books = $bookRepository->getByName((isset($post['recherche']) ? $post['recherche'] : ''));

        return $this->render('AppBundle:Book:list.html.twig', array(
            'books' => $books
        ));
    }

    /**
     * @Route("/bookstore/creation", name="formBook", defaults={ "slug" = null })
     * @Route("/bookstore/update/{slug}", name="updateBook")
     */
    public function creationAction(Request $request, $slug)
    {
		$em = $this->getDoctrine()->getManager();

		$book = ($slug ? $em->getRepository(Book::class)->findBySlug($slug)[0] : new Book());

		$form = $this->createForm(BookType::class, $book);

		
        // récupération de la saisie
        $form->handleRequest($request);
		
		// formulaire valide
		if($form->isSubmitted() && $form->isValid()){
			//  récupération d'un objet
			$data = $form->getData();

			/*
			* insertion dans la table
			* 2 branches :
			*      getManager() : UPDATE / DELETE / INSERT
			*          persist : file d'attente des requêtes SQL
			*          flush : execution des requêtes
			*      getRepository() : SELECT; accès à la classe Repository
			*/
			if($data->getSlug() == '')
			$data->setSlug(urlencode( join('_', [$data->getTitle(), $data->getAuthor(), $data->getDatePublication()->format('Y')])));
			if($data->getUrlImage() == '')
				$data->setUrlImage("http://static.openruby.com/assets/pages/d9/41/d9412a06dcc425bcc72a91c523749725_330.jpg");


			$em->persist($data);
			$em->flush();

			// message de confirmation
			$message = $slug ? "Le livre a été modifiée" : "Le livre a été créé";

			// addFlash(clé insérée en session, valeur de la clé)
			$this->addFlash('notice', $message);
			

				// redirection
			return $this->redirectToRoute('listBook');
		}
		
        return $this->render('AppBundle:Book:creation.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * @Route("/bookstore/book/{slug}", name="viewBook")
     */
    public function viewAction($slug)
    {
		$em = $this->getDoctrine();

		$bookRepository = $em->getRepository(Book::class);
		$book = $bookRepository->findBySlug($slug);
		if($book)
			$book = $book[0];
		else{
			$book = $bookRepository->find($slug);
		} 
		$months = ['', 'Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];

        return $this->render('AppBundle:Book:view.html.twig', array(
			'book' => $book,
			'months' => $months
        ));
    }

}
