<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\Recipe;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * MealplanItem
 * @ORM\Entity
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="mealplanItems")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=true)
     */
    private $name;

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
     * Set user
     *
     * @param integer $user
     *
     * @return Mealplan
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return int
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Grocerylist
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
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
