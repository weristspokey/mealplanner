<?php
namespace App\Controller;
use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     * @throws \RuntimeException
     */
   public function loginAction()
    {
        //return $this->render('index.html.twig', [
        //]);
        //throw new \RuntimeException("Is never been called");
        return new Response("An Error occured. Maybe your username or password is wrong. Please try to login again.");
    }

    /**
     * @Route("/logout")
     * @throws \RuntimeException
     */
    public function logoutAction()
    {
        throw new \RuntimeException("Is never been called");
    }
}
?>