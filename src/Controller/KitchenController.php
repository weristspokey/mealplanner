<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class KitchenController extends Controller
{
    /**
     * @Route("/kitchen", name="kitchen")
     */
    public function routeAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            );

        return $this->render('kitchen.html.twig', [
            'kitchenLists' => $kitchenLists 
        ]);
    }
}

?>