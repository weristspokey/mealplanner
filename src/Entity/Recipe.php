<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\RecipeItem;
use App\Entity\MealplanItem;
use App\Entity\User;
/**
 * Recipe
 *
 * @ORM\Table(name="recipe")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeRepository")
 */
class Recipe
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="recipes")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var array
     *
     * @ORM\Column(name="tags", type="simple_array", nullable=true)
     */
    private $tags;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="RecipeItem", mappedBy="recipeId")
     */
    private $recipeItems;

    /**
     * @ORM\OneToMany(targetEntity="MealplanItem", mappedBy="recipeId")
     */
    private $mealplanItems;

     public function __construct()
    {
        $this->recipeItems = new ArrayCollection();
        $this->mealplanItems = new ArrayCollection();
    }

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
     * Set user
     *
     * @param User $user
     *
     * @return Recipe
     */
    public function setUser(User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return User
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
     * @return Recipe
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
     * Set tags
     *
     * @param array $tags
     *
     * @return Recipe
     */
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get tags
     *
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Recipe
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }


    /**
     * Set description
     *
     * @param string $description
     *
     * @return Recipe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Add recipeItem
     *
     * @param \App\Entity\RecipeItem $recipeItem
     *
     * @return Recipe
     */
    public function addRecipeItem(\App\Entity\RecipeItem $recipeItem)
    {
        $this->recipeItems[] = $recipeItem;

        return $this;
    }

    /**
     * Remove recipeItem
     *
     * @param \App\Entity\RecipeItem $recipeItem
     */
    public function removeRecipeItem(\App\Entity\RecipeItem $recipeItem)
    {
        $this->recipeItems->removeElement($recipeItem);
    }

    /**
     * Get recipeItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipeItems()
    {
        return $this->recipeItems;
    }

    /**
     * Add mealplanItem
     *
     * @param \App\Entity\MealplanItem $mealplanItem
     *
     * @return Mealplan
     */
    public function addMealplanItem(\App\Entity\MealplanItem $mealplanItem)
    {
        $this->mealplanItems[] = $mealplanItem;

        return $this;
    }

    /**
     * Remove mealplanItem
     *
     * @param \App\Entity\MealplanItem $mealplanItem
     */
    public function removeMealplanItem(\App\Entity\MealplanItem $mealplanItem)
    {
        $this->mealplanItems->removeElement($mealplanItem);
    }

    /**
     * Get mealplanItems
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMealplanItems()
    {
        return $this->mealplanItems;
    }
}
