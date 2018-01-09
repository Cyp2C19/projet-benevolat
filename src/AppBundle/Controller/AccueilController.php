<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class AccueilController extends Controller
{
    // TODO : Gérer la pagination
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $qb = $em->createQueryBuilder();
        $qb->select('e')
            ->from(Evenement::class, 'e')
            ->having('DATE_DIFF(e.dateDebut, CURRENT_DATE()) >= 0')
            ->orderBy('DATE_DIFF(e.dateDebut, CURRENT_DATE())');
        $query = $qb->getQuery();
        $evenements = $query->getResult();
        $content = $this->get('templating')->render('accueil.html.twig', array('events' => $evenements));
        return new Response($content);
    }

    public function chargerEvenementAction(Request $request){

        if($request->isXmlHttpRequest())
        {
            $serializer = $this->get('serializer');
            $idEvt = $request->request->get('id');
            if ($idEvt != null) {
                $evtRepository = $this->getDoctrine()->getRepository(Evenement::class);
                $evt = $evtRepository->find($idEvt);
                $jsonEvt = $serializer->serialize($evt, 'json');
                $response = new JsonResponse(array('data' => $jsonEvt));
                return $response;
            }
        }
    }

    // TODO: Reenvoyer un tableau avec les événements mais aussi les demandes de bénévolat associées
    public function listeEvents($events){
        $l1 = array();
        $l2 = array();
        $l3 = array();

        for($i = 0, $taille = count($events); $i < $taille; $i += 3) {
            if(isset($events[$i])){
                $l1[] = $events[$i];
            }
            if(isset($events[$i + 1])){
                $l2[] = $events[$i + 1];
            }
            if(isset($events[$i + 2])){
                $l3[] = $events[$i + 2];
            }
        }

        $all = array($l1, $l2, $l3);

        return($all);

    }
}
