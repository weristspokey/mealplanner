<?php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\RedirectResponse;

use App\Entity\Recipe;
use App\Entity\Grocerylist;
use App\Entity\GrocerylistItem;
use App\Entity\MealplanItem;

use App\Form\MealplanItemType;

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
        
        $recipes = $this->getDoctrine()
            ->getRepository(Recipe::class)
            ->findAllRecipesOfUser($userId)->getQuery()->getResult();

        $mealplanItems = $em->getRepository(MealplanItem::class)->findBy(
             ['user' => $userId]
             );

        // Add new item
        $newMealplanItem = new MealplanItem();
        $addMealplanItemForm = $this->createForm(MealplanItemType::class, $newMealplanItem);
        $addMealplanItemForm->handleRequest($request);

        if ($addMealplanItemForm->isSubmitted() && $addMealplanItemForm->isValid()) 
            {
                $newMealplanItem->setUser($user);
                $em->persist($newMealplanItem);
                $em->flush();

                return $this->redirectToRoute('mealplan');
            }

        return $this->render('mealplan.html.twig', [
            'recipes' => $recipes,
            'newMealplanItemForm' => $addMealplanItemForm->createView(),
            'mealplanItems' => $mealplanItems
        ]);
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
}

?>
