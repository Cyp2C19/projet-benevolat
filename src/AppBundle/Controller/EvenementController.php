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

class EvenementController extends Controller
{
    public function creerAction(Request $request)
    {
        $evt = new Evenement();
        $club = $this->getUser();

        $form = $this->createForm(EvenementType::class, $evt, array(
            'sport' => $club->getSportParDefaut()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Date de modification => Aujourd'hui
            $evt->setDateModification(new \DateTime());
            // Club connecté
            $evt->setClub($club);
            // Test si adresse existante et récupération lieu
            $lieu = $this->testAdresse($form->get('lieu'));

            // Création de l'événement
            $evt->setLieu($lieu);
            $em->persist($evt);
            $em->flush();

            // Redirection vers l'espace club
            return $this->redirectToRoute('espace_club');
        }

        $content = $this->get('templating')->render('evenement.html.twig', array(
            'form' => $form->createView(),
            ));

        return new Response($content);
    }

    public function editAction($id, Request $request)
    {
        $evtRepository = $this->getDoctrine()->getRepository(Evenement::class);
        $evt = $evtRepository->find($id);
        $form = $this->createForm(EvenementType::class, $evt, array(
            'sport' => $evt->getSport()));
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            // Date de modification => Aujourd'hui
            $evt->setDateModification(new \DateTime());
            // Test si adresse existante et récupération lieu
            $lieu = $this->testAdresse($form->get('lieu'));

            // Création de l'événement
            $evt->setLieu($lieu);
            $em->persist($evt);
            $em->flush();

            // Redirection vers l'espace club
            return $this->redirectToRoute('espace_club');
        }

        $content = $this->get('templating')->render('evenement.html.twig', array(
            'form' => $form->createView(),
        ));

        return new Response($content);
    }

    private function testAdresse($formAdresse){

        $lieuRepository = $this->getDoctrine()->getRepository(Lieu::class);

        // Récupération champs adresse
        foreach ($formAdresse as $lieuForm) {
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
        // Adresse non trouvée --> création dans la bdd
        if(is_null($lieu)){
            $em = $this->getDoctrine()->getManager();
            $lieu = new Lieu();
            $lieu->setAdresse($adresse);
            $lieu->setVille($ville);
            $lieu->setCodePostal($cp);
            $em->persist($lieu);
            $em->flush();
        }

        return $lieu;
    }

}