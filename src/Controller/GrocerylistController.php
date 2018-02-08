<?php

namespace App\Controller;

use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Entity\KitchenList;
use App\Entity\KitchenListItem;
use App\Form\KitchenListItemType;
use App\Form\GrocerylistType;
use App\Form\GrocerylistItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use App\Service\ItemMover;

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
        $userId = $this->getUser()->getId();
        $grocerylists = $em->getRepository('App:Grocerylist')->findBy(
            array('userId' => $userId)
            );
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            );

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


        $kitchenListItem = new KitchenListItem();
        $moveItemForm = $this->createFormBuilder($kitchenListItem)
            ->add('kitchenListId', EntityType::class, [
                'label' => false,
                'choice_label'  => 'name',
                'class' => KitchenList::class,
                'attr' => [
                    'class' => 'selectpicker'
                    ]
                ]
            )
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


        return $this->render('grocerylist/index.html.twig', array(
            'grocerylists' => $grocerylists,
            'kitchenLists' => $kitchenLists,
            'moveItemForm' => $moveItemForm->createView(),
            'forms' => $views

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
     * @Route("/{id}", name="grocerylist_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Grocerylist $grocerylist)
    {
        $em = $this->getDoctrine()->getManager();
        $grocerylistId = $grocerylist->getId();
        $grocerylistItems = $em->getRepository('App:GrocerylistItem')->findBy(
            array('grocerylistId' => $grocerylistId)
            );

        $form = $this->createDeleteForm($grocerylist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            foreach ($grocerylistItems as $item) {
                $em->remove($item);
            }
            $em->remove($grocerylist);
            $em->flush();
        }

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
        $grocerylistItemId = $grocerylistItem->getId();

        $em->remove($grocerylistItem);
        $em->flush();

        return $this->redirectToRoute('grocerylist');
    }

    /**
     * Moves a grocerylistItem entity.
     * @Route("/{grocerylistItem}/item_move", name="grocerylistItem_move")
     * @Method({"POST"})
     */
    public function moveItemAction(GrocerylistItem $grocerylistItem)
    {   
        dump($grocerylistItem);
        return $this->json([$grocerylistItem->getFoodId()->getName()]);
    }

    /**
     * Moves a grocerylistItem entity.
     * @Route("/item_move/{id}", name="grocerylistItem_moveeeee")
     * @Method({"GET", "POST"})
     */
    public function moveeeeItemAction(Request $request, GrocerylistItem $grocerylistItem)
    {   
        $em = $this->getDoctrine()->getManager();

        $kitchenListItem = new KitchenListItem();
        $moveItemForm = $this->createFormBuilder($kitchenListItem)
            ->add('kitchenListId', EntityType::class, [
                'label' => false,
                'choice_label'  => 'name',
                'class' => KitchenList::class])
            ->add('foodId', EntityType::class, [
                'class'         => Food::class,
                'choice_label'  => 'name',
                'label' => false,
                'required' => true,
                'attr' => [
                    'class' => 'selectpicker',
                    'data-live-search' => 'true'
                ],
               ]
            )
            ->add('save', SubmitType::class)
            ->getForm();
            //dump($grocerylistItem);
        if ($moveItemForm->isSubmitted()) 
            {
                dump($grocerylistItem);
                $gItemId = $grocerylistItem->getId();
                $gItem = $em->getRepository('App:GrocerylistItem')->findBy(
                    array('id' => $gItemId)
                );
                //$kitchenListItem->setFoodId($gItem->getFoodId());
                $em->persist($kitchenListItem);
                $em->remove($grocerylistItem);
                $em->flush();
                return $this->redirectToRoute('grocerylist');
            }

        //$kitchenListItem = new KitchenListItem();
        //$em = $this->getDoctrine()->getManager();
        //dump($grocerylistItem);
        //deleteItemAction($_POST['itemId']);
        // if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //     $itemId = $_POST['itemId'];
        //     dump($itemId);
        // }

        // $item = $em->getRepository('App:GrocerylistItem')->findBy(
        //     array('id' => $itemId)
        //     );
        // $grocerylistItemFoodId = $grocerylistItem->getFoodId();
        // $kitchenListItem = new KitchenListItem($grocerylistItemFoodId);
        // $kitchenListItem->setFoodId();

        return $this->render('grocerylist/move.html.twig', array(
            'moveItemForm' => $moveItemForm->createView()

        ));
    }
}
