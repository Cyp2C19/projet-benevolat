<?php
/**
 * Created by PhpStorm.
 * User: cyprien
 * Date: 19/12/2017
 * Time: 13:34
 */

namespace AppBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ProfileClubController extends Controller
{
    public function editAction()
    {
        return $this->container
            ->get('pugx_multi_user.profile_manager')
            ->edit('AppBundle\Entity\Club');
    }
}