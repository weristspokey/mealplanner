<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Recipe;
use AppBundle\Form\RecipeType;

class RecipesController extends Controller
{
    /**
     * @Route("/recipes", name="recipes")
     */
    public function routeAction(Request $request)
    {
        $userId = $this->getUser()->getId();
        $recipes = $this->getDoctrine()->getRepository('AppBundle:Recipe')->findBy(
            array('userId' => $userId)
            );

        $recipePaginator = $this->get('knp_paginator');
        $pagination = $recipePaginator->paginate(
            $recipes,
            $request->query->getInt('page', 1),
            8
            );

        return $this->render('recipes.twig.html', [
            'recipes' => $pagination

        ]);
    }

    /**
     * @Route("/recipes/view/{recipeId}")
     */
    public function recipeViewAction($recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('AppBundle:Recipe')->find($recipeId);

        $recipeTags = $recipe->getTags();
        $recipeTags = implode(",", $recipeTags);

        $recipeIngredients = $recipe->getIngredients();
        $recipeIngredients = implode(",", $recipeIngredients);

        return $this->render('recipeDetail.twig.html', [
            'recipe' => $recipe,
            'recipe_tags' => $recipeTags,
            'recipe_ingredients' => $recipeIngredients
            ]);
    }

    /**
     * @Route("/recipes/create/{name}")
     */
    public function createRecipe($name)
    {
        $tags = array('healthy', 'vegan', 'veggie');
        $ingredients = array('Milk', 'Eggs');
        $image = "curry.jpg";
        $userId = 2;
        $recipe = new Recipe();
        $recipe->setName($name);
        $recipe->setInStock(false);
        $recipe->setDescription("Text blabla");
        $tagsString = implode(",", $tags);
        $recipe->setTags($tags);
        $recipe->setIngredients($ingredients);
        $recipe->setUserId($userId);
        $recipe->setImage($image);

        $em = $this->getDoctrine()->getManager();
        $em->persist($recipe);
        $em->flush();

        return $this->redirectToRoute('recipes');
    }

    /**
     * @Route("/recipes/add", name="add-recipe")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function addRecipe(Request $request)
    {
        $recipe = new Recipe();
        $userId = $this->getUser()->getId();

        $addRecipeForm = $this->createForm(RecipeType::class, $recipe, [
        ]);

        $addRecipeForm->HandleRequest($request);

        if($addRecipeForm->isSubmitted() && $addRecipeForm->isValid()) 
        {
            /**$recipeName = $_POST['name'];
            $recipeDescription = $_POST['description'];
            $recipeTags = $_POST['tags'];
            $recipeIngredients = $_POST['ingredients'];
            $recipeImage = $_POST['image'];

            //$user->setPassword($password);
            $recipeTags = $_POST['tags'];
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            $this->addFlash('success', 'You are registered');
            return $this->redirectToRoute('index');**/

            $recipeTags = $recipe->getTags();
            $recipeTags = explode(',',$recipeTags);

            $recipeIngredients = $recipe->getIngredients();
            $recipeIngredients = explode(',',$recipeIngredients);

            $recipe->setTags($recipeTags);
            $recipe->setIngredients($recipeIngredients);
            $recipe->setUserId($userId);
            $recipe->setInStock(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();
        }
        

        return $this->render('addRecipe.twig.html', [
            'add_recipe_form' => $addRecipeForm->createView()
            ]);
    }


}

?>