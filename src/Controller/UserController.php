<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;


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

}
?>