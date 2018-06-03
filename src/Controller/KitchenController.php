<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\KitchenList;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use App\Repository\GrocerylistRepository;
use App\Repository\KitchenListRepository;
use App\Entity\Grocerylist;
use App\Entity\KitchenListItem;
use App\Entity\GrocerylistItem;
use App\Form\KitchenListType;
use App\Form\KitchenListItemType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

/**
 * Kitchen controller.
 *
 * @Route("kitchen")
 */
class KitchenController extends Controller
{
    /**
     * @Route("/", name="kitchen")
     * @Method({"GET", "POST"})
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $this->getUser()->getId();
        $kitchenLists = $em->getRepository('App:KitchenList')->findBy(
            array('userId' => $userId)
            ); 

        /* Add KitchenListItem */
        $kitchenListItem = new KitchenListItem();
        $views = [];
        foreach ($kitchenLists as $kitchenList) 
        {
            $form_name = "form_".$kitchenList->getId();

            $form = $this->get('form.factory')->createNamedBuilder( 
              $form_name, 
              KitchenListItemType::class, 
              $kitchenListItem
           )->getForm();

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) 
            {
                $kitchenListItem->setKitchenListId($kitchenList);
                $em->persist($kitchenListItem);
                $em->flush();
                unset($kitchenListItem);
                unset($form);
                $kitchenListItem = new kitchenListItem();
                $form = $this->get('form.factory')->createNamedBuilder( 
                    $form_name, 
                    kitchenListItemType::class, 
                    $kitchenListItem
                    )->getForm();
            }

            $views[$kitchenList->getId()] = $form->createView();
        } 

        /* Move KitchenListItem to Grocerylist */
        $grocerylistItem = new GrocerylistItem();
        $moveItemForm = $this->createFormBuilder($grocerylistItem)
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Add item',
                    'class' => 'd-none'
                ]
                ]
            )
            ->add('grocerylistId', EntityType::class, [
                'label' => false,
                'choice_label'  => 'name',
                'class' => Grocerylist::class,
                'attr' => [
                    'class' => 'selectpicker'
                    ],
                'query_builder' => function (GrocerylistRepository $repo) {
                    $userId = $this->getUser()->getId();
                    return $repo->findAllGrocerylistsOfUser($userId);
                    }
                ]
            )
            ->add('submit', SubmitType::class)
            ->getForm();

            $moveItemForm->handleRequest($request);

        if ($moveItemForm->isSubmitted() && $moveItemForm->isValid()) 
            {
                $kItemId = (int)$_POST['itemId'];
                $kItem = $em->getRepository('App:KitchenListItem')->findBy(
                    array('id' => $kItemId)
                );

    
                $em->persist($grocerylistItem);

                $em->remove($kItem[0]);
                $em->flush();
                
                return $this->redirectToRoute('kitchen');

            }

        $kitchenList = new KitchenList();

        $form = $this->createForm('App\Form\KitchenListType', $kitchenList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kitchenList->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($kitchenList);
            $em->flush();

            return $this->redirectToRoute('kitchen');
        }

        return $this->render('kitchen/index.html.twig', [
            'kitchenLists' => $kitchenLists,
            'moveItemForm' => $moveItemForm->createView(),
            'forms' => $views,
            'form' => $form->createView()
        ]);
    }


    /**
     * Creates a new kitchenList entity.
     *
     * @Route("/new", name="kitchenList_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $kitchenList = new KitchenList();
        $user = $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $form = $this->createForm('App\Form\KitchenListType', $kitchenList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $kitchenList->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($kitchenList);
            $em->flush();

            $this->addFlash('success', 'New KitchenList added!');
            return $this->redirectToRoute('kitchen');
        }

        return $this->render('kitchen/new.html.twig', array(
            'kitchenList' => $kitchenList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing kitchenList entity.
     *
     * @Route("/{id}/edit", name="kitchenList_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, KitchenList $kitchenList)
    {
        $deleteForm = $this->createDeleteForm($kitchenList);
        $editForm = $this->createForm('App\Form\KitchenListType', $kitchenList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('kitchen', array('id' => $kitchenList->getId()));
        }

        return $this->render('kitchen/edit.html.twig', array(
            'kitchenList' => $kitchenList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a kitchenList entity.
     *
     * @Route("/delete/{id}", name="kitchenList_delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request, KitchenList $kitchenList)
    {
        $em = $this->getDoctrine()->getManager();
        $kitchenListId = $kitchenList->getId();
        $kitchenListItems = $em->getRepository('App:KitchenListItem')->findBy(
            array('kitchenListId' => $kitchenListId)
            );

            foreach ($kitchenListItems as $item) {
                $em->remove($item);
            }
            $em->remove($kitchenList);
            $em->flush();
        $this->addFlash('success', 'KitchenList deleted!');
        return $this->redirectToRoute('kitchen');
    }

    /**
     * Creates a form to delete a kitchenList entity.
     *
     * @param KitchenList $kitchenList The kitchenList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(KitchenList $kitchenList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kitchenList_delete', array('id' => $kitchenList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

     /**
     * Deletes a kitchenListItem entity.
     *
     * @Route("/item_delete/{id}", name="kitchenListItem_delete")
     * @Method({"POST"})
     */
    public function deleteItemAction(Request $request, KitchenListItem $kitchenListItem)
    {
        $em = $this->getDoctrine()->getManager();
        $kitchenListItemId = $kitchenListItem->getId();

        $em->remove($kitchenListItem);
        $em->flush();

        return $this->redirectToRoute('kitchen');
    }
}

?>