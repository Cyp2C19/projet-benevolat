<?php

namespace AppBundle\Controller;

use AppBundle\Form\RechercheEvenementsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AccueilController extends Controller
{
    public function indexAction(Request $request)
    {
        // Nombre d'événements max sur la page
        $limit = 16;
        // Répository Evenement
        $em = $this->getDoctrine()->getManager();
        $evenementsRepository = $em->getRepository('AppBundle:Evenement');
        // On récupère le numéro de page si il est transmis en paramètre
        $page = $request->query->get('page');
        if($page == 0){
            $page = 1;
        }
        // Création du formulaire de recherche
        $formRecherche = $this->createForm(RechercheEvenementsType::class, null, array(
            'criteres' => $this->get('session')->get('criteres')));
        $formRecherche->handleRequest($request);

        // Si formulaire soumis --> on met à jour le tableau des critères
        if ($formRecherche->isSubmitted()) {
            $this->tableauCriteres($formRecherche);
        }
        // Récupération des événements en fonction de la page et des critères
        $evenements = $evenementsRepository->getAllEvenements($page, $limit, $this->get('session')->get('criteres'));
        $maxPages = ceil(count($evenements) / $limit);
        $thisPage = $page;
        // Création de la vue et envoi des événements, du formulaire et des infos sur la pagination
        $content = $this->get('templating')->render('accueil.html.twig', array('events' => $evenements,
            'maxPages' => $maxPages, 'thisPage' => $thisPage, 'formRecherche' => $formRecherche->createView()));
        return new Response($content);
    }

    private function tableauCriteres($form){
        $tabCriteres = [];
        if(!is_null($form['sport']->getData())) {
            $tabCriteres['sport'] = $form['sport']->getData();
        }
        if(!is_null($form['ville']->getData())){
            $tabCriteres['ville'] = $form['ville']->getData();
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

    public function resetCriteresAction(){
        $this->get('session')->remove('criteres');
        return $this->redirectToRoute('accueil');
    }

    public function envoiMailAction(\Swift_Mailer $mailer, Request $request)
    {
        if($request->isXmlHttpRequest()){
            // Répository Evenement
            $em = $this->getDoctrine()->getManager();
            $evt = $em->getRepository('AppBundle:Evenement')->find($request->request->get('evt'));
            $user = $em->getRepository('AppBundle:Benevole')->find($request->request->get('user'));

            $userMail = $user->getEmail();
            $clubMail = '';
            if(!is_null($evt->getClub())){
                $clubMail = $evt->getClub()->getEmail();
            }

            $message = (new \Swift_Message('SportEvents86 - Demande de bénévolat'))
                ->setFrom('mailer.symfony.test@gmail.com')
                ->setTo([$userMail, $clubMail])
                ->setBody(
                    $this->renderView(
                        '::demande-email.html.twig',
                        array(
                            'user' => $user,
                            'evt' => $evt,
                            'motivation' => $request->request->get('texteMotivation'),
                            'demandes' => $request->request->get('demandes') )
                    ),
                    'text/html'
                )
                /*
                 * If you also want to include a plaintext version of the message
                ->addPart(
                    $this->renderView(
                        'emails/registration.txt.twig',
                        array('name' => $name)
                    ),
                    'text/plain'
                )
                */
            ;

            $mailer->send($message);
            // retour de l'url pour recharger la page
            $url = $this->generateUrl('accueil');
            $response = new Response(json_encode($url));
            $response->headers->set('Content-Type', 'application/json');
            return $response;

        }
    }
}
