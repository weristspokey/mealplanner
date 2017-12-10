<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Recipe;
use AppBundle\Entity\RecipeItem;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use AppBundle\Form\RecipeType;


/**
 * Recipe controller.
 *
 * @Route("recipe")
 */
class RecipeController extends Controller
{

    /**
     * Lists all recipe entities.
     *
     * @Route("/", name="recipe_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $userId = $this->getUser()->getId();
        $tags = $em->getRepository('AppBundle:Tag')->findBy(
            array('userId' => $userId)
            );

        $recipes = $em->getRepository('AppBundle:Recipe')->findBy(
            array('userId' => $userId)
            );

        $recipePaginator = $this->get('knp_paginator');
        $pagination = $recipePaginator->paginate(
            $recipes,
            $request->query->getInt('page', 1),
            8
            );

        return $this->render('recipe/index.html.twig', [
            'recipes' => $pagination,
            'tags' => $tags
        ]);
    }

/**
     * Creates a new recipe entity.
     *
     * @Route("/new", name="recipe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $recipe = new Recipe();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $em = $this->getDoctrine()->getManager();
        $tags = $em->getRepository('AppBundle:Tag')->findBy(
            array('userId' => $userId)
            );

        $recipeItem = new RecipeItem();
        $recipeItem->setFoodId(2);
        $recipeItem->setValue(2);
        $recipeItem->setUnit('ml');
        $recipeItem->setRecipeId($recipe);
        $recipeItemTwo = new RecipeItem();
        $recipeItemTwo->setFoodId(1);
        $recipeItemTwo->setValue(2);
        $recipeItemTwo->setUnit('ml');
        $recipeItemTwo->setRecipeId($recipe);

        $newRecipeForm = $this->createForm(RecipeType::class, $recipe);
        $newRecipeForm->handleRequest($request);

        if ($newRecipeForm->isSubmitted() && $newRecipeForm->isValid()) {

            $recipeImage = $recipe->getImage();
            $recipeImageName = md5(uniqid()).'.'.$recipeImage->guessExtension();
            $recipeImage->move(
                $this->getParameter('image_directory'),
                $recipeImageName
            );
            $recipe->setTags($tags);
            $recipe->addRecipeItem($recipeItem);
            $recipe->addRecipeItem($recipeItemTwo);
            $recipe->setImage($recipeImageName);
            $recipe->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            
            $em->persist($recipe);
            $em->persist($recipeItem);
            $em->persist($recipeItemTwo);
            $em->flush();

            return $this->redirectToRoute('recipe_index');
        }

        return $this->render('recipe/new.html.twig', array(
            'recipe' => $recipe,
            'new_recipe_form' => $newRecipeForm->createView(),
        ));
    }

    /**
     * Finds and displays a recipe entity.
     *
     * @Route("/{id}", name="recipe_show")
     * @Method("GET")
     */
    public function showAction(Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();

        $userId = $this->getUser()->getId();
        $tags = $em->getRepository('AppBundle:Tag')->findBy(
            array('userId' => $userId)
            );
        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
        ]);
    }

    /**
     * Displays a form to edit an existing recipe entity.
     *
     * @Route("/{id}/edit", name="recipe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recipe $recipe)
    {
        $deleteForm = $this->createDeleteForm($recipe);

        $editForm = $this->createForm(RecipeType::class, $recipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recipe_show', array('id' => $recipe->getId()));
        }

        return $this->render('recipe/edit.html.twig', array(
            'recipe' => $recipe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a recipe entity.
     *
     * @Route("/{id}", name="recipe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Recipe $recipe)
    {
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            $em->flush();
        }

        return $this->redirectToRoute('recipe_index');
    }

   /**
     * Creates a form to delete a recipe entity.
     *
     * @param Recipe $recipe The recipe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Recipe $recipe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recipe_delete', array('id' => $recipe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}

?>