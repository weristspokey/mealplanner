<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * RecipeItem
 *
 * @ORM\Table(name="recipe_item")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\RecipeItemRepository")
 */
class RecipeItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="recipeItems")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipeId;

    /**
     * @var int
     *
     * @ORM\Column(name="foodId", type="integer")
     */
    private $foodId;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set recipeId
     *
     * @param Recipe $recipeId
     *
     * @return RecipeItem
     */
    public function setRecipeId(Recipe $recipeId)
    {
        $this->recipeId = $recipeId;

        return $this;
    }

    /**
     * Get recipeId
     *
     * @return Recipe
     */
    public function getRecipeId()
    {
        return $this->recipeId;
    }

    /**
     * Set foodId
     *
     * @param integer $foodId
     *
     * @return RecipeItem
     */
    public function setFoodId($foodId)
    {
        $this->foodId = $foodId;

        return $this;
    }

    /**
     * Get foodId
     *
     * @return int
     */
    public function getFoodId()
    {
        return $this->foodId;
    }
}
