<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

class UserController extends Controller
{
    /**
     * @Route("/profile", name="profile_index")
     */
   public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();

        $grocerylists = $em->getRepository('App:Grocerylist')->findBy(
            array('userId' => $userId)
            );
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            );
        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
             array('userId' => $userId)
             );
        $tags = $em->getRepository('App:Tag')->findBy(
            array('userId' => $userId)
            );
        $recipes = $em->getRepository('App:Recipe')->findBy(
            array('userId' => $userId)
            );
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