<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 13/11/2017
 * Time: 10:22
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Entity\Lieu;
use AppBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CreerEvenementController extends Controller
{
    public function indexAction(Request $request)
    {
        $evt = new Evenement();
        $club = $this->getUser();

        $form = $this->createForm(EvenementType::class, $evt, array(
            'sport' => $club->getSportParDefaut()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $lieuRepository = $this->getDoctrine()->getRepository(Lieu::class);
            $em = $this->getDoctrine()->getManager();
            // Date de création => Aujourd'hui
            $evt->setDateModification(new \DateTime());
            // Club connecté
            $evt->setClub($club);

            // Récupération champs adresse
            foreach ($form->get('lieu') as $lieuForm) {
                $lieuData[] = $lieuForm->getData();
            }
            $adresse = $lieuData[0];
            $ville = $lieuData[1];
            $cp = $lieuData[2];
            // Recherche dans la bdd si adresse existante
            $lieu = $lieuRepository->findOneBy(
                array('adresse' => $adresse,
                      'ville' => $ville,
                      'codePostal' => $cp)
            );
            // Adresse non trouvée --> création
            if(is_null($lieu)){
                $lieu = new Lieu();
                $lieu->setAdresse($adresse);
                $lieu->setVille($ville);
                $lieu->setCodePostal($cp);
                $em->persist($lieu);
                $em->flush();
            }

            // Création événement
            $evt->setLieu($lieu);
            $em->persist($evt);
            $em->flush();

            // TODO: Rediriger vers la page de gestion du club
            return $this->redirectToRoute('espace_club');
        }

        $content = $this->get('templating')->render('evenement.html.twig', array(
            'form' => $form->createView(),
            ));

        return new Response($content);
    }

    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $evtRepository = $this->getDoctrine()->getRepository(Evenement::class);
        $evt = $evtRepository->find($id);
        $form = $this->createForm(EvenementType::class, $evt, array(
            'sport' => $evt->getSport()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($evt);
            $em->flush();
            return $this->redirectToRoute('espace_club');
        }
        $content = $this->get('templating')->render('evenement.html.twig', array(
            'form' => $form->createView(),
        ));

        return new Response($content);
    }

}