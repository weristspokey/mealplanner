<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Grocerylist;
use AppBundle\Entity\GrocerylistItem;
use AppBundle\Form\GrocerylistType;
use AppBundle\Form\GrocerylistItemType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

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
        $grocerylists = $em->getRepository('AppBundle:Grocerylist')->findBy(
            array('userId' => $userId)
            );

        $grocerylistItem = new GrocerylistItem();
        $add_grocerylistItem_form = $this->createForm('AppBundle\Form\GrocerylistItemType', $grocerylistItem);
        $add_grocerylistItem_form->handleRequest($request);

        if ($add_grocerylistItem_form->isSubmitted() && $add_grocerylistItem_form->isValid()) {
            
            $em = $this->getDoctrine()->getManager();
            $em->persist($grocerylistItem);
            $em->flush();
            dump($grocerylistItem);
            return $this->redirectToRoute('grocerylist');
        }


        return $this->render('grocerylist/index.html.twig', array(
            'grocerylists' => $grocerylists,
            'add_grocerylistItem_form' => $add_grocerylistItem_form->createView(),
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
        $form = $this->createForm('AppBundle\Form\GrocerylistType', $grocerylist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $grocerylist->setUserId($user);
            $em = $this->getDoctrine()->getManager();
            $em->persist($grocerylist);
            $em->flush();

            return $this->redirectToRoute('grocerylist', array('id' => $grocerylist->getId()));
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
        $editForm = $this->createForm('AppBundle\Form\GrocerylistType', $grocerylist);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('grocerylist', array('id' => $grocerylist->getId()));
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
        $form = $this->createDeleteForm($grocerylist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
