<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MealplanController extends Controller
{
    /**
     * @Route("/mealplan", name="mealplan")
     */
    public function routeAction()
    {
        return $this->render('mealplan.twig.html', [
        ]);
    }
}

?>
