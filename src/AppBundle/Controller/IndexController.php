<?php

namespace AppBundle\Controller;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
        $registerForm = $this->createForm(UserType::class, $user, [
        ]);

        $registerForm->HandleRequest($request);

        if($registerForm->isSubmitted() && $registerForm->isValid()) 
        {
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

            $this->addFlash('success', 'You are registered');
            return $this->redirectToRoute('index');
        }

        // replace this example code with whatever you need
        return $this->render('index.twig.html', [
            //'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
            'register_form' => $registerForm->createView()
        ]);
    }

}
?>