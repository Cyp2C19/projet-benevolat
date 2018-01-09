<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 19/12/2017
 * Time: 13:34
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class RegistrationBenevoleController extends Controller
{
    public function registerAction()
    {
        return $this->container
            ->get('pugx_multi_user.registration_manager')
            ->register('AppBundle\Entity\Benevole');
    }
}