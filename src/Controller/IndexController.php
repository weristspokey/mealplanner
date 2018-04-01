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

        $registerForm = $this->createRegistrationForm($user);
        
        // replace this example code with whatever you need
        return $this->render('index.html.twig', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'register_form' => $registerForm->createView()
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
     * @param Request $request
     * @Route("/registration-form-submission", name="registration-form-submission")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function registrationFormSubmissionAction(Request $request)
    {
        $user = new User();
        $registerForm = $this->createRegistrationForm($user);

        $registerForm->HandleRequest($request);

        if(! $registerForm->isSubmitted() || ! $registerForm->isValid()) 
        {
            return $this->render('index.html.twig', [
            'register_form' => $registerForm->createView()
        ]);
        }
        
        $password = $this
            ->get('security.password_encoder')
            ->encodePassword(
                $user,
                $user->getPlainPassword()
            );

        $user->setPassword($password);
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

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

    /**
     * @param $user
     * @return \Symfony\Component\Form\Form
     */
    private function createRegistrationForm($user)
    {
        return $this->createForm(UserType::class, $user, [
            'action' => $this->generateUrl('registration-form-submission')
        ]);


    }
}
?>