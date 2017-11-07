<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \LogicException
     */
    public function routeAction(Request $request)
    {
        $user = new User();

        $registerForm = $this->createRegistrationForm($user);
        
        // replace this example code with whatever you need
        return $this->render('index.twig.html', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'register_form' => $registerForm->createView()
        ]);
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
            return $this->render('index.twig.html', [
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