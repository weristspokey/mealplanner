<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Grocerylist;
use App\Entity\KitchenList;
use App\Entity\MealplanItem;
use App\Entity\Tag;

use App\Form\UserType;

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

            $token = new UsernamePasswordToken(
                $user,
                $password,
                'main',
                $user->getRoles()
            );

            $this->get('security.token_storage')->setToken($token);
            $this->get('session')->set('_security_main', serialize($token));
            
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
            ->findAllRecipesOfUser($id)->getQuery()->getResult();

        foreach ($recipes as $recipe) {
            foreach ($recipe->getRecipeItems() as $item) {
                $em->remove($item);
            }
                $em->remove($recipe);
            }

        $kitchenLists = $this->getDoctrine()
            ->getRepository(KitchenList::class)
            ->findAllKitchenListsOfUser($id)->getQuery()->getResult();
        foreach ($kitchenLists as $kitchenList) {
                foreach ($kitchenList->getKitchenListItems() as $item) {
                $em->remove($item);
            }
                $em->remove($kitchenList);
            }
        $grocerylists = $this->getDoctrine()
            ->getRepository(Grocerylist::class)
            ->findAllGrocerylistsOfUser($id)->getQuery()->getResult();
        foreach ($grocerylists as $grocerylist) {
            foreach ($grocerylist->getGrocerylistItems() as $item) {
                $em->remove($item);
            }
                $em->remove($grocerylist);
            }

        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            ['user' => $id]
            );
        foreach ($mealplanItems as $item) {
                $em->remove($item);
            }
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllTagsOfUser($id)->getQuery()->getResult();
        foreach ($tags as $tag) {
                $em->remove($tag);
            }

        $em->remove($id);
        $em->flush();
        $this->addFlash('success', 'User deleted!');
        return $this->redirectToRoute('admin');
    }
}
?>