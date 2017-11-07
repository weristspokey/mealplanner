<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RecipesController extends Controller
{
    /**
     * @Route("/recipes", name="recipes")
     */
    public function routeAction()
    {
        return $this->render('recipes.twig.html', [
        ]);
    }
}

?>