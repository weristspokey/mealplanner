<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeItem;
use AppBundle\Entity\User;
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
        $recipeItems = $em->getRepository('AppBundle:RecipeItem')->findBy(
            array('recipeId' => $recipeId)
            );
        $foodItems = $em->getRepository('AppBundle:Food')->findAll();
        $ingredients = [];

        foreach ($recipeItems as $recipeItem) {
           $recipeItemId = $recipeItem->getFoodId();
           foreach ($foodItems as $foodItem) {
                $foodItemId = $foodItem->getId();
               if ($recipeItemId == $foodItemId) {
                   array_push($ingredients, $foodItem->getName());
               }
           }
        }

        dump($recipeItems);
        dump($recipeItems[0]->getFoodId());
        dump($ingredients);
        dump($recipe->getTags());

        return $this->render('recipeDetail.twig.html', [
            'recipe' => $recipe,
            'ingredients' => $ingredients
            ]);
    }

    /**
     * @Route("/recipes/create/{name}")
     */
    public function createRecipe($name)
    {
        $userId = $this->getUser()->getId();
        $user = $this->getUser();
        
        $tags = array('healthy', 'vegan', 'veggie');
        $ingredients = array('healthy', 'vegan', 'veggie');
        $recipeItem = new RecipeItem();
        $recipeItem->setFoodId(2);
        $recipe = new Recipe();

        $recipe->setName($name);
        $recipe->setDescription("Text blabla");
        //$tagsString = implode(",", $tags);
        $recipe->setTags($tags);
        $recipe->setUserId($user);
        $recipe->addRecipeItem($recipeItem);
        $em = $this->getDoctrine()->getManager();
        $em->persist($recipeItem);
        $em->persist($recipe);
        $em->flush();

         return new Response(
            'Created recipe: '.$recipe->getName().$recipeItem->getFoodId()
        );
    }

    /**
     * @Route("/recipes/add", name="add_recipe")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function addRecipe(Request $request)
    {
        $recipe = new Recipe();
        $user = $this->getUser();
        $recipeItem = new RecipeItem();
        $recipeItem->setFoodId(2);
        $recipeItem->setRecipeId($recipe);
        $recipeItemTwo = new RecipeItem();
        $recipeItemTwo->setFoodId(1);
        $recipeItemTwo->setRecipeId($recipe);

        $addRecipeForm = $this->createForm(RecipeType::class, $recipe, [
        ]);

        $addRecipeForm->HandleRequest($request);

        if($addRecipeForm->isSubmitted() && $addRecipeForm->isValid()) 
        {
            $recipeTags = $recipe->getTags();
            $recipeTags = explode(',',$recipeTags);

            //$recipeIngredients = $recipe->getRecipeItems();
            //$recipeIngredients = explode(',',$recipeIngredients);

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $recipeImage */
            $recipeImage = $recipe->getImage();
            $recipeImageName = md5(uniqid()).'.'.$recipeImage->guessExtension();
            $recipeImage->move(
                $this->getParameter('image_directory'),
                $recipeImageName
            );

            $recipe->setTags($recipeTags);
            $recipe->addRecipeItem($recipeItem);
            $recipe->addRecipeItem($recipeItemTwo);
            $recipe->setUserId($user);
            $recipe->setImage($recipeImageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipeItem);
            $em->persist($recipeItemTwo);
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipes');
        }
        

        return $this->render('addRecipe.twig.html', [
            'add_recipe_form' => $addRecipeForm->createView()
            ]);
    }

    /**
     * @Route("/recipes/view/{recipeId}/edit", name="edit_recipe")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function editRecipe($recipeId)
    {
        $recipe = new Recipe();
        $userId = $this->getUser()->getId();

        $addRecipeForm = $this->createForm(RecipeType::class, $recipe, [
        ]);

        $addRecipeForm->HandleRequest($request);

        if($addRecipeForm->isSubmitted() && $addRecipeForm->isValid()) 
        {
            $recipeTags = $recipe->getTags();
            $recipeTags = explode(',',$recipeTags);

            $recipeIngredients = $recipe->getRecipeItems();
            $recipeIngredients = explode(',',$recipeIngredients);

            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $recipeImage */
            $recipeImage = $recipe->getImage();
            $recipeImageName = md5(uniqid()).'.'.$recipeImage->guessExtension();
            $recipeImage->move(
                $this->getParameter('image_directory'),
                $recipeImageName
            );

            $recipe->setTags($recipeTags);
            $recipe->setRecipeItems($recipeIngredients);
            $recipe->setUserId($userId);
            $recipe->setInStock(false);
            $recipe->setImage($recipeImageName);
            $em = $this->getDoctrine()->getManager();
            $em->persist($recipe);
            $em->flush();

            return $this->redirectToRoute('recipes');
        }
        

        return $this->render('addRecipe.twig.html', [
            'add_recipe_form' => $addRecipeForm->createView()
            ]);
    }

    /**
     * @Route("recipes/view/{recipeId}/delete")
     */
    public function deleteAction($recipeId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipe = $em->getRepository('AppBundle:Recipe')->find($recipeId);

        $em->remove($recipe);
        $em->flush();
        return new Response('Deleted with id '.$recipeId);
    }

    /**
     * @Route("recipes/recipeitem/{recipeItemId}/delete")
     */
    public function deleteItemAction($recipeItemId)
    {
        $em = $this->getDoctrine()->getManager();
        $recipeItem = $em->getRepository('AppBundle:RecipeItem')->find($recipeItemId);

        $em->remove($recipeItem);
        $em->flush();
        return new Response('Deleted with id '.$recipeItemId);
    }

}

?>