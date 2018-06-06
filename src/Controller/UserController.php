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
use App\Repository\TagRepository;
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
             ['user' => $userId]
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
            'recipes' => $recipes,
            'userId' => $userId
        ]);
    }

    /**
     * @Route("/profile/deleteUser", name="profile_delete")
     */
   public function deleteUserAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $user->getId();

        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAllRecipesOfUser($userId)->getQuery()->getResult();

        foreach ($recipes as $recipe) {
            foreach ($recipe->getRecipeItems() as $item) {
                $em->remove($item);
            }
                $em->remove($recipe);
            }

        $kitchenLists = $this->getDoctrine()
            ->getRepository(KitchenList::class)
            ->findAllKitchenListsOfUser($userId)->getQuery()->getResult();

        foreach ($kitchenLists as $kitchenList) {
                foreach ($kitchenList->getKitchenListItems() as $item) {
                $em->remove($item);
            }
                $em->remove($kitchenList);
            }

        $grocerylists = $this->getDoctrine()
            ->getRepository(Grocerylist::class)
            ->findAllGrocerylistsOfUser($userId)->getQuery()->getResult();

        foreach ($grocerylists as $grocerylist) {
            foreach ($grocerylist->getGrocerylistItems() as $item) {
                $em->remove($item);
            }
                $em->remove($grocerylist);
            }

        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllTagsOfUser($userId)->getQuery()->getResult();
        foreach ($tags as $tag) {
                $em->remove($tag);
            }

        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            ['user' => $userId]
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