<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Form\LoginType;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
   public function loginAction(Request $request, AuthenticationUtils $authenticationUtils)
    {
    $error = $authenticationUtils->getLastAuthenticationError();

    $lastUsername = $authenticationUtils->getLastUsername();

    return $this->render('login.html.twig', array(
        'last_username' => $lastUsername,
        'error'         => $error,
    ));
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

        // 2) handle the submit (will only happen on POST)
        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()) {

            // 3) Encode the password (you could also do this via Doctrine listener)
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            // 4) save the User!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // ... do any other work - like sending them an email, etc
            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'You are registered');
            return $this->redirectToRoute('index');
        }

        return $this->render(
            'register.html.twig',
            array('form' => $registerForm->createView())
        );
    }
}
?>