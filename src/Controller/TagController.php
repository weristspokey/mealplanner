<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Entity\Tag;

use App\Form\TagType;
/**
 * Tag controller.
 *
 * @Route("tag")
 */
class TagController extends Controller
{
    /**
     * Creates a new tag entity.
     *
     * @Route("/new", name="tag_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $userId = $user->getId();
        $tags = $this->getDoctrine()
            ->getRepository(Tag::class)
            ->findAllTagsOfUser($userId)->getQuery()->getResult();

        $tag = new Tag();
        $newTagForm = $this->createForm(TagType::class, $tag);
        $newTagForm->handleRequest($request);

        if ($newTagForm->isSubmitted() && $newTagForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $tagName = str_replace(' ', '', $tag->getName());
            $tag->setName($tagName);
            $tag->setUser($user);
            $em->persist($tag);
            $em->flush();
            $this->addFlash('success', 'New Tag added!');
            return $this->redirectToRoute('tag_new', ['id' => $tag->getId()]);
        }

        return $this->render('tag/new.html.twig', [
            'tags' => $tags,
            'tag' => $tag,
            'new_tag_form' => $newTagForm->createView(),
        ]);
    }

    /**
     * Displays a form to edit an existing tag entity.
     *
     * @Route("/{id}/edit", name="tag_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Tag $tag)
    {   $userId = $this->getUser()->getId();
        $tagOwner = $tag->getUser()->getId();
        if($userId != $tagOwner) {
            return new Response("Wrong User.");
        }
        $deleteForm = $this->createDeleteForm($tag);
        $editForm = $this->createForm(TagType::class, $tag);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('tag_new');
        }

        return $this->render('tag/edit.html.twig', [
            'tag' => $tag,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ]);
    }

    /**
     * Deletes a tag entity.
     *
     * @Route("/{id}", name="tag_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Tag $tag)
    {
        $em = $this->getDoctrine()->getManager();
        $form = $this->createDeleteForm($tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->remove($tag);
            $em->flush();
            $this->addFlash('success', 'Tag deleted!');
        }

        return $this->redirectToRoute('tag_new');
    }

    /**
     * Creates a form to delete a tag entity.
     *
     * @param Tag $tag The tag entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Tag $tag)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('tag_delete', ['id' => $tag->getId()]))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
