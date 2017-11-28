<?php

namespace AppBundle\Controller;

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
        return $this->render('kitchen.twig.html', [
        ]);
    }
}

?>