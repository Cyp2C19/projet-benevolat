<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 22/11/2017
 * Time: 14:12
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EspaceBenevoleController extends Controller
{
    public function indexAction(Request $request)
    {
        $content = $this->get('templating')->render('espace-benevole.html.twig');
        return new Response($content);
    }
}