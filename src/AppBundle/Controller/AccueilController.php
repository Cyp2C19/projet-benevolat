<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccueilController extends Controller
{
    public function indexAction(Request $request)
    {
        $page = $request->query->get('page');
        if($page == 0){
            $page = 1;
        }
        $limit = 12;
        $em = $this->getDoctrine()->getManager();
        $evenements = $em->getRepository('AppBundle:Evenement')->getAllEvenements($page, $limit);
        $maxPages = ceil(count($evenements) / $limit);
        $thisPage = $page;

        $content = $this->get('templating')->render('accueil.html.twig', array('events' => $evenements,
            'maxPages' => $maxPages, 'thisPage' => $thisPage));
        return new Response($content);
    }
}
