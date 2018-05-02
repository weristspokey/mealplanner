<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\User;
use App\Entity\Food;
use App\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function indexAction(Request $request)
    {
        $user = new User();
        $em = $this->getDoctrine()->getManager();

        $grocerylists = $em->getRepository('App:Grocerylist')->findAll();
        $kitchenLists = $em->getRepository('App:KitchenList')->findAll();
        $mealplanItems = $em->getRepository('App:MealplanItem')->findAll();
        $recipes = $em->getRepository('App:Recipe')->findAll();

        //$registerForm = $this->createRegistrationForm($user);
        
        // replace this example code with whatever you need
        return $this->render('index.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            //'register_form' => $registerForm->createView(),
            'grocerylists' => $grocerylists,
            'kitchenLists' => $kitchenLists,
            'mealplanItems' => $mealplanItems,
            'recipes' => $recipes
        ]);
    }
    /**
     * @Route("/addFood/{name}")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function addFoodAction(Request $request, $name)
    {
        $food = new Food();
        $food->setName($name);
        $food->setIsVegetarian(false);
        $food->setIsVegan(false);
        $em = $this->getDoctrine()->getManager();
        $em->persist($food);
        $em->flush();

        return $this->redirectToRoute('index');
    }

    /**
     * @Route("/admin", name="admin")
     */
   public function adminAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository('App:User')->findAll();
        return $this->render('admin.html.twig', array(
            'users' => $users
        ));
    }

    /**
     * @Route("/admin/deleteUser/{id}", name="delete_user")
     */
    public function deleteUserAction(Request $request, User $id)
    {   
        $em = $this->getDoctrine()->getManager();
        $recipes = $em->getRepository('App:Recipe')->findBy(
            array('userId' => $id)
            );
        foreach ($recipes as $recipe) {
                $em->remove($recipe);
            }
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $id)
            );
        foreach ($kitchenLists as $list) {
                $em->remove($list);
            }
        // $kitchenListItems = $em->getRepository('App:KitchenListItem')->findBy(
        //     array('userId' => $id)
        //     );
        // foreach ($kitchenListItems as $item) {
        //         $em->remove($item);
        //     }
        $grocerylists = $em->getRepository('App:Grocerylist')->findBy(
            array('userId' => $id)
            );
        foreach ($grocerylists as $list) {
                $em->remove($list);
            }
        // $grocerylistItems = $em->getRepository('App:GrocerylistItem')->findBy(
        //     array('userId' => $id)
        //     );
        // foreach ($grocerylistItems as $item) {
        //         $em->remove($item);
        //     }
        // $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
        //     array('userId' => $id)
        //     );
        // foreach ($mealplanItems as $item) {
        //         $em->remove($item);
        //     }

        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'User deleted!');
        return $this->redirectToRoute('admin');
    }
}
?>