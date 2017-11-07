<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Recipe;

class RecipesController extends Controller
{
    /**
     * @Route("/recipes", name="recipes")
     */
    public function routeAction(Request $request)
    {
        $recipes =$this->getDoctrine()->getRepository('AppBundle:Recipe')->findAll();

        $recipePaginator = $this->get('knp_paginator');
        $pagination = $recipePaginator->paginate(
            $recipes,
            $request->query->getInt('page', 1),
            6
            );
        return $this->render('recipes.twig.html', [
            'recipes' => $pagination
        ]);
    }

    /**
     * @Route("/recipes/add/{name}")
     */
    public function addRecipe($name)
    {
        $tags = array('healthy', 'vegan', 'veggie');
        $ingredients = array('Milk', 'Eggs');
        $userId = 2;
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setInStock(false);
        $recipe->setDescription("Text blabla");
        $tagsString = implode(",", $tags);
        $recipe->setTags($tags);
        $recipe->setIngredients($ingredients);
        $recipe->setUserId($userId);
        //$recipe->setImage($image);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return $this->redirectToRoute('recipes');
    }
}

?>