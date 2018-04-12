<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Food;
use App\Entity\User;
use App\Entity\Recipe;
use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Entity\Mealplan;
use App\Entity\MealplanItem;
use App\Form\MealplanItemType;
use App\Form\MealplanType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Mealplan controller.
 *
 * @Route("mealplan")
 */
class MealplanController extends Controller
{
    /**
     * @Route("/", name="mealplan")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $userId = $this->getUser()->getId();
        $user = $this->getUser();
        // $days = array(
        //     'today' => date("D d.m.y", time()),
        //     'tomorrow' => date("D d.m.y", time() + 86400),
        //     'twoDaysFromNow' => date("D d.m.y", time() + (2*86400)),
        //     'threeDaysFromNow' => date("D d.m.y", time() + (3*86400)),
        //     'fourDaysFromNow' => date("D d.m.y", time() + (4*86400)),
        //     'fiveDaysFromNow' => date("D d.m.y", time() + (5*86400)),
        //     'sixDaysFromNow' => date("D d.m.y", time() + (6*86400)),
        //  );

        $food = $this->getDoctrine()->getRepository('App:Food')->findAll();

        $recipes = $this->getDoctrine()->getRepository('App:Recipe')->findBy(
                ['userId' => $userId]);
        $mealplanItems = $this->getDoctrine()->getRepository('App:MealplanItem')->findAll();
        // $mealplans = $this->getDoctrine()->getRepository('App:Mealplan')
        //     ->findBy(
        //         ['userId' => $userId],
        //         ['date' => 'ASC']
        // );    

        // $mealplanItem = new MealplanItem();
        // $views = [];
        
        // foreach ($mealplans as $mealplan) 
        // {
        //     $form_name = "form_".$mealplan->getId();
        //     dump($mealplan->getDate()->format('Y-m-d'));
        //     $form = $this->get('form.factory')->createNamedBuilder( 
        //       $form_name, 
        //       MealplanItemType::class, 
        //       $mealplanItem
        //    )->getForm();

        //     $form->handleRequest($request);

        //     if ($form->isSubmitted() && $form->isValid()) 
        //     {
        //         $mealplanItem->setMealplanId($mealplan);
        //         $em->persist($mealplanItem);
        //         $em->flush();
        //     }

        //     $views[$mealplan->getId()] = $form->createView();
        // }



        // // Add new mealplan
        // $newMealplan = new Mealplan();
        // $addMealplanForm = $this->createForm(MealplanType::class, $newMealplan);
        // $addMealplanForm->handleRequest($request);

        // if ($addMealplanForm->isSubmitted() && $addMealplanForm->isValid()) 
        //     {
        //         $newMealplan->setUserId($user);
        //         //$newDate = $newMealplan->getDate()->format('Y-m-d');
        //         //$newMealplan->setDate($newDate);
        //         $em = $this->getDoctrine()->getManager();
        //         $em->persist($newMealplan);
        //         $em->flush();

        //         // $mealplans = $this->getDoctrine()->getRepository('App:Mealplan')
        //         //     ->findBy(
        //         //             ['userId' => $userId],
        //         //             ['date' => 'ASC']
        //         //     );    
        //         $this->addFlash('success', 'New Mealplan added!');

        //         return $this->redirectToRoute('mealplan');
        //     }

        // Add new item
        $newMealplanItem = new MealplanItem();
        $addMealplanItemForm = $this->createForm(MealplanItemType::class, $newMealplanItem);
        $addMealplanItemForm->handleRequest($request);

        if ($addMealplanItemForm->isSubmitted() && $addMealplanItemForm->isValid()) 
            {
                $newMealplanItem->setUserId($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($newMealplanItem);
                $em->flush();

                return $this->redirectToRoute('mealplan');
            }

        return $this->render('mealplan.html.twig', [
            // 'today' => $days['today'],
            // 'tomorrow' => $days['tomorrow'],
            // 'twoDaysFromNow' => $days['twoDaysFromNow'],
            // 'threeDaysFromNow' => $days['threeDaysFromNow'],
            // 'fourDaysFromNow' => $days['fourDaysFromNow'],
            // 'fiveDaysFromNow' => $days['fiveDaysFromNow'],
            // 'sixDaysFromNow' => $days['sixDaysFromNow'],
            'food' => $food,
            'recipes' => $recipes,
            //'add_mealplan_form' => $addMealplanForm->createView(),
            //'mealplans' => $mealplans,
            'newMealplanItemForm' => $addMealplanItemForm->createView(),
            'mealplanItems' => $mealplanItems
            //'forms' => $views,
        ]);
    }


    /**
     * @Route("/create")
     */
    public function createAction()
    {
    $mealplan = new Mealplan();
    $userId = $this->getUser();
    $mealplan->setUserId($userId);
    $date = new \DateTime();
    $date->modify('+2 day');
    $mealplan->setDate($date);

    $em = $this->getDoctrine()->getManager();

    // tells Doctrine you want to (eventually) save the Product (no queries yet)
    $em->persist($mealplan);

    // actually executes the queries (i.e. the INSERT query)
    $em->flush();

    //return new Response('Saved new product with id '.$newFood->getId());
    return $this->redirectToRoute('mealplan');
    }

    /**
     * Deletes a mealplanItem entity.
     *
     * @Route("/item_delete/{id}", name="mealplanItem_delete")
     * @Method({"POST"})
     */
    public function deleteItemAction(Request $request, MealplanItem $mealplanItem)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($mealplanItem);
        $em->flush();

        return $this->redirectToRoute('mealplan');
    }

    /**
     * Adds a mealplanItem entity.
     *
     * @Route("/item_add", name="mealplanItem_add")
     */
    public function addItemAction(Request $request, Mealplan $mealplan)
    {
        $mealplanItem = new MealplanItem();
        $em = $this->getDoctrine()->getManager();

        $em->remove($mealplanItem);
        $em->flush();

        return $this->redirectToRoute('mealplan');
    }

    /**
     * Deletes a mealplan entity.
     *
     * @Route("/mealplan_delete/{id}", name="mealplan_delete")
     */
    public function deleteMealplanAction(Request $request, Mealplan $mealplan)
    {
        $em = $this->getDoctrine()->getManager();
        $mealplanId = $mealplan->getId();
        $mealplanItems = $em->getRepository('App:MealplanItem')->findBy(
            array('mealplanId' => $mealplanId)
            );
        foreach ($mealplanItems as $item) {
                $em->remove($item);
            }

        $em->remove($mealplan);
        $em->flush();
        $this->addFlash('success', 'Mealplan deleted!');
        return $this->redirectToRoute('mealplan');
    }

}

?>
