<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Grocerylist;
use App\Entity\KitchenList;
use App\Entity\RecipeItem;
use App\Entity\Tag;
use App\Entity\MealplanItem;

use App\Form\UserType;

use App\Repository\RecipeRepository;
use App\Repository\GrocerylistRepository;
use App\Repository\KitchenListRepository;
use App\Repository\TagsRepository;
use App\Repository\MealplanItemRepository;

class UserController extends Controller
{
    /**
     * @Route("/profile", name="profile_index")
     */
   public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();

        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
             array('userId' => $userId)
             );
        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAllRecipesOfUser($userId)->getQuery()->getResult();

        $grocerylists = $this->getDoctrine()
            ->getRepository(Grocerylist::class)
            ->findAllGrocerylistsOfUser($userId)->getQuery()->getResult();

        $kitchenLists = $this->getDoctrine()
            ->getRepository(KitchenList::class)
            ->findAllKitchenListsOfUser($userId)->getQuery()->getResult();

        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllTagsOfUser($userId)->getQuery()->getResult();

        return $this->render('profile/index.html.twig', [
            'grocerylists' => $grocerylists,
            'kitchenLists' => $kitchenLists,
            'mealplanItems' => $mealplanItems,
            'tags' => $tags,
            'recipes' => $recipes
        ]);
    }

    /**
     * @Route("/profile/deleteUser", name="profile_delete")
     */
   public function deleteUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();

        $recipes = $em->getRepository('App:Recipe')->findBy(
            array('userId' => $userId)
            );
        foreach ($recipes as $recipe) {
            $recipeId = $recipe->getId();
            $recipeItems = $em->getRepository('App:RecipeItem')->findBy(
            array('recipeId' => $recipeId)
            );
            foreach ($recipeItems as $item) {
                $em->remove($item);
            }
            $em->remove($recipe);
        }
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            );
        foreach ($kitchenLists as $list) {
                $em->remove($list);
            }
        $grocerylists = $em->getRepository('App:Grocerylist')->findBy(
            array('userId' => $userId)
            );
        foreach ($grocerylists as $list) {
                $em->remove($list);
            }
        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            array('userId' => $userId)
            );
        foreach ($mealplanItems as $item) {
                $em->remove($item);
            }

        $em->remove($user);
        $em->flush();
        $this->get('security.token_storage')->setToken(null);
        $this->get('request_stack')->getCurrentRequest();

        $this->addFlash('success', 'Account deleted!');
        return $this->redirectToRoute('index');
    }

}
?>