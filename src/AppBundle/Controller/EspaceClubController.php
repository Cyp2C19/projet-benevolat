<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 20/11/2017
 * Time: 16:46
 */

namespace AppBundle\Controller;
use AppBundle\Entity\Evenement;
use AppBundle\Form\TableauEvenementsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EspaceClubController extends Controller
{
    public function indexAction(Request $request)
    {
        $club = $this->getUser();
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(TableauEvenementsType::class, $club);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($club);
            $em->flush();
            return $this->redirectToRoute('espace_club');
        }

        $content = $this->get('templating')->render('espace-club.html.twig', array(
            'form' => $form->createView(), 'club' => $club));
        return new Response($content);
    }
}