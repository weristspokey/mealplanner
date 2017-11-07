<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class GrocerylistController extends Controller
{
    /**
     * @Route("/grocerylist", name="grocerylist")
     */
    public function routeAction(Request $request)
    {
        return $this->render('grocerylist.twig.html', [
        ]);
    }
}
?>