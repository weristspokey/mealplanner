<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Repository\GrocerylistRepository;
use App\Repository\KitchenListRepository;
use App\Repository\MealplanItemRepository;
use App\Repository\RecipeRepository;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function indexAction(Request $request, 
                                GrocerylistRepository $grocerylists, 
                                KitchenListRepository $kitchenLists,
                                MealplanItemRepository $mealplanItems,
                                RecipeRepository $recipes)
    {
        return $this->render('index.html.twig', [
            'grocerylists' => $grocerylists,
            'kitchenLists' => $kitchenLists,
            'mealplanItems' => $mealplanItems,
            'recipes' => $recipes
        ]);
    }
}
?>