<?php
namespace App\Controller;
use App\Entity\User;
use App\Entity\Recipe;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\UserRepository;
use App\Repository\GrocerylistRepository;
use App\Repository\KitchenListRepository;
use App\Repository\MealplanItemRepository;
use App\Repository\RecipeRepository;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
   public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
    $error = $authenticationUtils->getLastAuthenticationError();

    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('login.html.twig', [
        'last_username' => $lastUsername,
        'error'         => $error
    ]);
    }

    /**
     * @Route("/logout")
     * @throws \RuntimeException
     */
    public function logoutAction()
    {
        throw new \RuntimeException("Is never been called");
    }

    /**
     * @Route("/register", name="register")
     */
    public function registerAction(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $registerForm = $this->createForm(UserType::class, $user);

        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'You are registered');
            return $this->redirectToRoute('index');
        }

        return $this->render('register.html.twig', [
            'form' => $registerForm->createView()
            ]);
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

        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAllRecipesOfUser($id);

        foreach ($recipes as $recipe) {
            foreach ($recipe->getRecipeItems() as $item) {
                $em->remove($item);
            }
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
        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            array('userId' => $id)
            );
        foreach ($mealplanItems as $item) {
                $em->remove($item);
            }

        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'User deleted!');
        return $this->redirectToRoute('admin');
    }
}
?>