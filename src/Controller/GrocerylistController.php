<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Entity\KitchenList;
use App\Entity\KitchenListItem;

use App\Repository\KitchenListRepository;

use App\Form\GrocerylistType;
use App\Form\GrocerylistItemType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
        $grocerylists = $this->getDoctrine()
            ->getRepository(Grocerylist::class)
            ->findAllGrocerylistsOfUser($userId)->getQuery()->getResult();

        /* Add GrocerylistItem */
        $grocerylistItem = new GrocerylistItem();
        $addGrocerylistItemForms = [];
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
                unset($grocerylistItem);
                unset($form);
                $grocerylistItem = new GrocerylistItem();
                $form = $this->get('form.factory')->createNamedBuilder( 
                    $form_name, 
                    GrocerylistItemType::class, 
                    $grocerylistItem
                    )->getForm();
            }

            $addGrocerylistItemForms[$grocerylist->getId()] = $form->createView();
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
                    return $repo->findAllKitchenListsOfUser($userId);
                    }
                ])
            ->add('name', TextType::class, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'Add item',
                    'class' => 'd-none'
                ]]
            )
            ->add('submit', SubmitType::class)
            ->getForm();

            $moveItemForm->handleRequest($request);
        if ($moveItemForm->isSubmitted() && $moveItemForm->isValid()) 
            {
                $gItemId = (int)$_POST['itemId'];
                $gItem = $em->getRepository(GrocerylistItem::class)->findBy(
                    ['id' => $gItemId]
                );
                $em->persist($kitchenListItem);

                $em->remove($gItem[0]);
                $em->flush();
                
                return $this->redirectToRoute('grocerylist');

            }

        /* New Grocerylist */
        $grocerylist = new Grocerylist();

        $addGrocerylistForm = $this->createForm(GrocerylistType::class, $grocerylist);
        $addGrocerylistForm->handleRequest($request);

        if ($addGrocerylistForm->isSubmitted() && $addGrocerylistForm->isValid()) {
            $grocerylist->setUser($user);
            $em->persist($grocerylist);
            $em->flush();
            $this->addFlash('success', 'New Grocerylist added!');
            return $this->redirectToRoute('grocerylist');
        }

        return $this->render('grocerylist/index.html.twig', [
            'grocerylists' => $grocerylists,
            'moveItemForm' => $moveItemForm->createView(),
            'forms' => $addGrocerylistItemForms,
            'form' => $addGrocerylistForm->createView()

        ]);
    }

    /**
     * Creates a new grocerylist entity.
     *
     * @Route("/new", name="grocerylist_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $grocerylist = new Grocerylist();

        $addGrocerylistForm = $this->createForm(GrocerylistType::class, $grocerylist);
        $addGrocerylistForm->handleRequest($request);

        if ($addGrocerylistForm->isSubmitted() && $addGrocerylistForm->isValid()) {
            $grocerylist->setUser($user);
            $em->persist($grocerylist);
            $em->flush();

            $this->addFlash('success', 'New Grocerylist added!');
            return $this->redirectToRoute('grocerylist');
        }

        return $this->render('grocerylist/new.html.twig', [
            'grocerylist' => $grocerylist,
            'form' => $addGrocerylistForm->createView()
        ]);
    }

    /**
     * Deletes a grocerylist entity.
     *
     * @Route("/delete/{id}", name="grocerylist_delete")
     * @Method({"POST"})
     */
    public function deleteAction(Request $request, Grocerylist $grocerylist)
    {
        $em = $this->getDoctrine()->getManager();
        $grocerylistId = $grocerylist->getId();
        $grocerylistItems = $em->getRepository(GrocerylistItem::class)->findBy(
            ['grocerylistId' => $grocerylistId]
            );
        foreach ($grocerylistItems as $item) {
            $em->remove($item);
        }
        $em->remove($grocerylist);
        $em->flush();
        $this->addFlash('success', 'Grocerylist deleted!');
        return $this->redirectToRoute('grocerylist');
    }

    /**
     * Deletes a grocerylistItem entity.
     *
     * @Route("/delete_item/{id}", name="grocerylistItem_delete")
     * @Method({"POST"})
     */
    public function deleteItemAction(Request $request, GrocerylistItem $grocerylistItem)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($grocerylistItem);
        $em->flush();

        return $this->redirectToRoute('grocerylist');
    }
}
