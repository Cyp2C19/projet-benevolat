<?php

namespace AppBundle\Controller;

use AppBundle\Entity\SearchEvenement;
use AppBundle\Form\RechercheEvenementsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends Controller
{
    public function indexAction(Request $request)
    {
        // Nombre d'événements max sur la page
        $limit = 12;
        // Répository Evenement
        $em = $this->getDoctrine()->getManager();
        $evenementsRepository = $em->getRepository('AppBundle:Evenement');
        // On récupère le numéro de page si il est transmis en paramètre
        $page = $request->query->get('page');
        if($page == 0){
            $page = 1;
        }
        // Création du formulaire de recherche
        $form = $this->createForm(RechercheEvenementsType::class);
        $form->handleRequest($request);
        // Récupération des événements en fonction de la page et des critères
        $evenements = $evenementsRepository->getAllEvenements($page, $limit, $form);
        $maxPages = ceil(count($evenements) / $limit);
        $thisPage = $page;

        $content = $this->get('templating')->render('accueil.html.twig', array('events' => $evenements,
            'maxPages' => $maxPages, 'thisPage' => $thisPage, 'form' => $form->createView()));
        return new Response($content);
    }
}
