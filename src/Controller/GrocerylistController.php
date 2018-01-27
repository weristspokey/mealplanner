<?php

namespace App\Controller;

use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Form\GrocerylistType;
use App\Form\GrocerylistItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use App\Entity\Food;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

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

        return $this->render('grocerylist/index.html.twig', array(
            'grocerylists' => $grocerylists,
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
        $form = $this->createForm('App\Form\GrocerylistType', $grocerylist);
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
}
