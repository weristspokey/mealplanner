<?php

namespace App\Controller;

use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Entity\KitchenList;
use App\Entity\KitchenListItem;
use App\Form\KitchenListItemType;
use App\Form\GrocerylistType;
use App\Form\GrocerylistItemType;
use App\Repository\KitchenListRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Doctrine\ORM\EntityRepository;

/**
 * Grocerylist controller.
 *
 * @Route("grocerylist")
 */
class GrocerylistController extends Controller
{
    /**
     * Lists all grocerylist entities.
     *
     * @Route("/", name="grocerylist")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $grocerylists = $em->getRepository('App:Grocerylist')->findBy(
            array('userId' => $userId)
            );
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            );

        /* Add GrocerylistItem */
        $grocerylistItem = new GrocerylistItem();
        $views = [];
        foreach ($grocerylists as $grocerylist) 
        {
            $form_name = "form_".$grocerylist->getId();

            $form = $this->get('form.factory')->createNamedBuilder( 
              $form_name, 
              GrocerylistItemType::class, 
              $grocerylistItem
           )->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                $grocerylistItem->setGrocerylistId($grocerylist);
                $em->persist($grocerylistItem);
                $em->flush();
            }

            $views[$grocerylist->getId()] = $form->createView();
        } 

        /* Move GrocerylistItem to Kitchen */
        $kitchenListItem = new KitchenListItem();
        $moveItemForm = $this->createFormBuilder($kitchenListItem)
            ->add('kitchenListId', EntityType::class, [
                'class' => KitchenList::class,
                'choice_label'  => 'name',
                'label' => false,
                'attr' => [
                    'class' => 'selectpicker'
                    ],
                'query_builder' => function (KitchenListRepository $repo) {
                    $userId = $this->getUser()->getId();
                    return $repo->showListsOfCurrentUser($userId);
                    }
                ])
            ->add('foodId', EntityType::class, [
                'class'         => Food::class,
                'choice_label'  => 'name',
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker d-none',
                    'name' => 'food-id'
                    ]
                ]
            )
            ->add('submit', SubmitType::class)
            ->getForm();

            $moveItemForm->handleRequest($request);

        if ($moveItemForm->isSubmitted() && $moveItemForm->isValid()) 
            {
                $gItemId = (int)$_POST['itemId'];
                $gItem = $em->getRepository('App:GrocerylistItem')->findBy(
                    array('id' => $gItemId)
                );

    
                $em->persist($kitchenListItem);

                $em->remove($gItem[0]);
                $em->flush();
                
                return $this->redirectToRoute('grocerylist');

            }

        /* New Grocerylist */

        $grocerylist = new Grocerylist();

        $form = $this->createForm(GrocerylistType::class, $grocerylist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grocerylist->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($grocerylist);
            $em->flush();

            return $this->redirectToRoute('grocerylist');
        }

        return $this->render('grocerylist/index.html.twig', array(
            'grocerylists' => $grocerylists,
            'kitchenLists' => $kitchenLists,
            'moveItemForm' => $moveItemForm->createView(),
            'forms' => $views,
            'form' => $form->createView()

        ));
    }

    /**
     * Creates a new grocerylist entity.
     *
     * @Route("/new", name="grocerylist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $grocerylist = new Grocerylist();
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm(GrocerylistType::class, $grocerylist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grocerylist->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($grocerylist);
            $em->flush();

            return $this->redirectToRoute('grocerylist');
        }

        return $this->render('grocerylist/new.html.twig', array(
            'grocerylist' => $grocerylist,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a grocerylist entity.
     *
     * @Route("/{id}", name="grocerylist_show")
     * @Method("GET")
     */
    public function showAction(Grocerylist $grocerylist)
    {
        $deleteForm = $this->createDeleteForm($grocerylist);

        return $this->render('grocerylist/show.html.twig', array(
            'grocerylist' => $grocerylist,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing grocerylist entity.
     *
     * @Route("/{id}/edit", name="grocerylist_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Grocerylist $grocerylist)
    {
        $deleteForm = $this->createDeleteForm($grocerylist);
        $editForm = $this->createForm('App\Form\GrocerylistType', $grocerylist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grocerylist');
        }

        return $this->render('grocerylist/edit.html.twig', array(
            'grocerylist' => $grocerylist,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }




    /**
     * Deletes a grocerylist entity.
     *
     * @Route("/grocerylist_delete/{id}", name="grocerylist_delete")
     */
    public function deleteAction(Request $request, Grocerylist $grocerylist)
    {
        $em = $this->getDoctrine()->getManager();
        $grocerylistId = $grocerylist->getId();
        $grocerylistItems = $em->getRepository('App:GrocerylistItem')->findBy(
            array('grocerylistId' => $grocerylistId)
            );
        foreach ($grocerylistItems as $item) {
            $em->remove($item);
        }
        $em->remove($grocerylist);
        $em->flush();

        return $this->redirectToRoute('grocerylist');
    }

    /**
     * Creates a form to delete a grocerylist entity.
     *
     * @param Grocerylist $grocerylist The grocerylist entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Grocerylist $grocerylist)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('grocerylist_delete', array('id' => $grocerylist->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    /**
     * Deletes a grocerylistItem entity.
     *
     * @Route("/item_delete/{id}", name="grocerylistItem_delete")
     */
    public function deleteItemAction(Request $request, GrocerylistItem $grocerylistItem)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($grocerylistItem);
        $em->flush();

        return $this->redirectToRoute('grocerylist');
    }
}
