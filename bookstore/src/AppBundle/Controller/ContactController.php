<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use AppBundle\Form\ContactType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{

    /**
     * @Route("/contact", name="contact")
     */
    public function indexAction(){
        /*
         * getRepository(entité ciblée) : SELECT
         * 4 méthodes de sélection
         *      find(id) : récupérer un enregistrement par la PK
         *      findAll() : récupérer tous les enregistrements
         *      findBy() : récupérer plusieurs enregistrements par une liste de critères (par la valeur d'une colonne de la table)
         *      findOneBy() : récupérer un enregistrement par une liste de critères
         * */
        $doctrine = $this->getDoctrine();
        $repository = $doctrine->getRepository(Contact::class);
        $results = $repository->findAll();

        //exit(dump($results));

        return $this->render('contact/index.html.twig', [
            'results' => $results
        ]);
    }

    /**
     * @Route("/contact/form", name="contact.form", defaults={ "id" = null })
     * @Route("/contact/form/update/{id}", name="contact.update")
     */
    public function formAction(Request $request, $id){
        // doctrine
        $doctrine = $this->getDoctrine();

        // instances nécessaires au formulaire
        // if($id !== null) {  } else { $entity = new Contact(); }
        $entity = $id ? $doctrine->getRepository(Contact::class)->find($id) : new Contact();
        $type = ContactType::class;

        // création du formulaire
        $form = $this->createForm($type, $entity);

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

            $manager = $doctrine->getManager();

            $manager->persist($data);
            $manager->flush();

            // message de confirmation
            $message = $id ? "Le contact a été modifié" : "Le contact a été ajouté";

            // addFlash(clé insérée en session, valeur de la clé)
            $this->addFlash('notice', $message);

            // redirection
            return $this->redirectToRoute('contact');
        }

        return $this->render('contact/form.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/contact/delete/{id}", name="contact.delete")
     */
    public function deleteAction($id){
        /*
         * sélection puis une suppression (remove va remplacer persist)
         * */
        $doctrine = $this->getDoctrine();
        $contact = $doctrine->getRepository(Contact::class)->find($id);
        $manager = $doctrine->getManager();

        $manager->remove($contact);
        $manager->flush();

        // message / redirection
        $this->addFlash('notice',
            "Le contact - {$contact->getFirstname()} {$contact->getLastname()} - a été supprimé");
        return $this->redirectToRoute('contact');

    }

}






