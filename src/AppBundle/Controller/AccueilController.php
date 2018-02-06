<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evenement;
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
        $form = $this->createForm(RechercheEvenementsType::class, null, array(
            'criteres' => $this->get('session')->get('criteres')));
        $form->handleRequest($request);

        // Si formulaire soumis --> on met à jour le tableau des critères
        if ($form->isSubmitted()) {
            $this->tableauCriteres($form);
        }
        // Récupération des événements en fonction de la page et des critères
        $evenements = $evenementsRepository->getAllEvenements($page, $limit, $this->get('session')->get('criteres'));
        $maxPages = ceil(count($evenements) / $limit);
        $thisPage = $page;
        // Création de la vue et envoi des événements, du formulaire et des infos sur la pagination
        $content = $this->get('templating')->render('accueil.html.twig', array('events' => $evenements,
            'maxPages' => $maxPages, 'thisPage' => $thisPage, 'form' => $form->createView()));
        return new Response($content);
    }

    private function tableauCriteres($form){
        $tabCriteres = [];
        if(!is_null($form['sport']->getData())) {
            $tabCriteres['sport'] = $form['sport']->getData();
        }
        if(!is_null($form['lieu']->getData())){
            $tabCriteres['lieu'] = $form['lieu']->getData();
        }
        if(!is_null($form['dateDebut']->getData())) {
            $tabCriteres['date'] = $form['dateDebut']->getData();
        }
        if(!is_null($form['niveau']->getData())) {
            $tabCriteres['niveau'] = $form['niveau']->getData();
        }
        if(!is_null($form['categorieAge']->getData())) {
            $tabCriteres['categorie'] = $form['categorieAge']->getData();
        }
        if(!is_null($form['interieur']->getData())) {
            $tabCriteres['interieur'] = $form['interieur']->getData();
        }
        // Passage du tableau de critères dans la variable de session pour
        // ne pas perdre les critères durant la pagination.
        $this->get('session')->set('criteres', $tabCriteres);
    }

    public function resetCriteresAction(Request $request){
        $this->get('session')->remove('criteres');
        return $this->redirectToRoute('accueil');
    }
}
