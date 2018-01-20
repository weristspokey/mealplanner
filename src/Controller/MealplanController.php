<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Food;
use App\Entity\Recipe;

class MealplanController extends Controller
{
    /**
     * @Route("/mealplan", name="mealplan")
     */
    public function routeAction()
    {
        $days = array(
            'today' => date("D d.m.y", time()),
            'tomorrow' => date("D d.m.y", time() + 86400),
            'twoDaysFromNow' => date("D d.m.y", time() + (2*86400)),
            'threeDaysFromNow' => date("D d.m.y", time() + (3*86400)),
            'fourDaysFromNow' => date("D d.m.y", time() + (4*86400)),
            'fiveDaysFromNow' => date("D d.m.y", time() + (5*86400)),
            'sixDaysFromNow' => date("D d.m.y", time() + (6*86400)),
         );

        $food = $this->getDoctrine()->getRepository('App:Food')->findAll();

        $recipes =$this->getDoctrine()->getRepository('App:Recipe')->findAll();


        return $this->render('mealplan.html.twig', [
            'today' => $days['today'],
            'tomorrow' => $days['tomorrow'],
            'twoDaysFromNow' => $days['twoDaysFromNow'],
            'threeDaysFromNow' => $days['threeDaysFromNow'],
            'fourDaysFromNow' => $days['fourDaysFromNow'],
            'fiveDaysFromNow' => $days['fiveDaysFromNow'],
            'sixDaysFromNow' => $days['sixDaysFromNow'],
            'food' => $food,
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/create/{text}")
     */
    public function createAction($text)
    {
    $newFood = new Food();
    $newFood->setName($text);
    $newFood->setInStock(false);
    $newFood->setIsVegetarian(true);
    $newFood->setIsVegan(false);

    $em = $this->getDoctrine()->getManager();

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
    $em->persist($newFood);

    // actually executes the queries (i.e. the INSERT query)
    $em->flush();

    //return new Response('Saved new product with id '.$newFood->getId());
    return $this->redirectToRoute('mealplan');
    }

}

?>
