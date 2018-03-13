<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Food;
use App\Entity\Mealplan;
use App\Entity\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * MealplanItem
 *@ORM\Entity
 * @ORM\Table(name="mealplan_item")
 */
class MealplanItem
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
     * @ORM\Column(name="mealplanId", type="date")
     */
    private $mealplanId;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="mealplanItems")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
     */
    private $foodId;

    /**
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="mealplanItems")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id")
     */
    private $recipeId;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string")
     */
    private $category;

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
     * Set mealplanId
     *
     * @param integer $mealplanId
     *
     * @return MealplanItem
     */
    public function setMealplanId($mealplanId)
    {
        $this->mealplanId = $mealplanId;

        return $this;
    }

    /**
     * Get mealplanId
     *
     * @return int
     */
    public function getMealplanId()
    {
        return $this->mealplanId;
    }

    /**
     * Set foodId
     *
     * @param integer $foodId
     *
     * @return MealplanItem
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

    /**
     * Set recipeId
     *
     * @param integer $recipeId
     *
     * @return MealplanItem
     */
    public function setRecipeId($recipeId)
    {
        $this->recipeId = $recipeId;

        return $this;
    }

    /**
     * Get recipeId
     *
     * @return int
     */
    public function getRecipeId()
    {
        return $this->recipeId;
    }

    /**
     * Set category
     *
     * @param string $category
     *
     * @return MealplanItem
     */
    public function setCategory($category)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }
}
