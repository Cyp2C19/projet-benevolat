<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 13/11/2017
 * Time: 10:22
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Form\EvenementType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nzo\UrlEncryptorBundle\Annotations\ParamDecryptor;

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

            // Création de l'événement
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

    /**
     * @ParamDecryptor(params={"id"})
     */
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
}