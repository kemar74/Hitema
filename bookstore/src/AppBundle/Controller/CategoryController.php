<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Category;
use AppBundle\Form\CategoryType;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    /**
     * @Route("/bookstore", name="listCategory")
     */
    public function listAction()
    {
		$em = $this->getDoctrine();

		$categories = $em->getRepository(Category::class)->findAll();
        return $this->render('AppBundle:Category:list.html.twig', array(
            'categories' => $categories
        ));
    }

    /**
     * @Route("/bookstore/category/creation", name="formCategory", defaults={ "id" = null })
     * @Route("/bookstore/category/update/{id}", name="updateCategory")
     */
    public function creationAction(Request $request, $id)
    {
		$em = $this->getDoctrine()->getManager();

		$category = ($id ? $em->getRepository(Category::class)->find($id) : new Category());

		$form = $this->createForm(CategoryType::class, $category);

		
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


			$em->persist($data);
			$em->flush();

			// message de confirmation
			$message = $id ? "La catégorie a été modifiée" : "La catégorie a été créée";

			// addFlash(clé insérée en session, valeur de la clé)
			$this->addFlash('notice', $message);
			// redirection
			return $this->redirectToRoute('listCategory');
		}
		
        return $this->render('AppBundle:Category:creation.html.twig', array(
            'form' => $form->createView()
        ));
    }

}
