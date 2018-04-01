<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Recipe;
use App\Entity\RecipeItem;
use App\Entity\RecipeItemCollection;
use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Form\RecipeType;
use App\Form\RecipeItemCollectionType;
use App\Form\TagSelectpickerType;
use App\Entity\Tag;
use App\Repository\RecipeRepository;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Recipe controller.
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

        $tags = $this->getDoctrine()->getRepository(Tag::class)->findAllTagsOfCurrentUser($userId);
        $recipes = $this->getDoctrine()->getRepository(Recipe::class)->findAllRecipesOfCurrentUser($userId);

        return $this->render('recipe/index.html.twig', [
            'recipes' => $recipes,
            'tags' => $tags
        ]);
    }

    /**
     * Creates a new recipe entity.
     *
     * @Route("/new", name="recipe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request, FileUploader $fileUploader)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $recipe = new Recipe();
        
        $newRecipeForm = $this->createForm(RecipeType::class, $recipe);
        $newRecipeForm->handleRequest($request);

        if ($newRecipeForm->isSubmitted() && $newRecipeForm->isValid()) {
            $recipeImage = $recipe->getImage();
            $recipeImageName = $fileUploader->upload($recipeImage);
            $recipe->setImage($recipeImageName);
            $tags = $recipe->getTags();
            $recipe->setUserId($user);
            
            $em->persist($recipe);
            $em->flush();
            $this->addFlash('success', 'New Recipe added!');
            
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
     * @Method({"GET", "POST"})
     */
    public function showAction(Request $request, Recipe $recipe)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();

        $tags = $recipe->getTags();
        $recipeItems = $recipe->getRecipeItems();
        $recipeItem = new RecipeItem();

        $deleteForm = $this->createDeleteForm($recipe);

        /* NEW FORM */
        $recipeItemCollection = new RecipeItemCollection();

        $item = new RecipeItem();
        $recipeItemCollection->getRecipeItemCollection()->add($item);

        $form = $this->createForm(RecipeItemCollectionType::class, $recipeItemCollection);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $item->setRecipeId($recipe);
            $em = $this->getDoctrine()->getManager();
            $em->persist($item);
            $em->flush();

            return $this->redirectToRoute('recipe_show', array('id' => $recipe->getId()));
        }



        return $this->render('recipe/show.html.twig', [
            'recipe' => $recipe,
            'recipeItems' => $recipeItems,
            'tags' => $tags,
            'delete_form' => $deleteForm->createView(),
            'form' => $form->createView(),
            'data' => $recipeItemCollection,
        ]);
    }

    /**
     * Displays a form to edit an existing recipe entity.
     * @Route("/{id}/edit", name="recipe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Recipe $recipe, FileUploader $fileUploader)
    {
        $deleteForm = $this->createDeleteForm($recipe);
        $editForm = $this->createForm(RecipeType::class, $recipe);

        $image = $recipe->getImage();
        $recipe->setImage($image);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            //$this->getDoctrine()->getManager()->flush();
            $recipeImage = $recipe->getImage();
            $recipeImageName = $fileUploader->upload($recipeImage);
            $em = $this->getDoctrine()->getManager();
            $recipe->setImage($recipeImageName);
            $em->persist($recipe);
            $em->flush();

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
        $em = $this->getDoctrine()->getManager();
        $recipeId = $recipe->getId();
        $recipeItems = $em->getRepository('App:RecipeItem')->findBy(
            array('recipeId' => $recipeId)
            );
        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            array('recipeId' => $recipeId)
            );
        $form = $this->createDeleteForm($recipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recipe);
            foreach ($recipeItems as $item) {
                $em->remove($item);
            }
            foreach ($mealplanItems as $item) {
                $em->remove($item);
            }
            $em->flush();
            $this->addFlash('success', 'Recipe deleted!');
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

    /**
     * Deletes a recipeItem entity.
     *
     * @Route("/item_delete/{id}", name="recipeItem_delete")
     * @Method({"POST"})
     */
    public function deleteItemAction(Request $request, RecipeItem $recipeItem)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($recipeItem);
        $em->flush();

        return $this->redirectToRoute('recipe_index');
    }


}
?>