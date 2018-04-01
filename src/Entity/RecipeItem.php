<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Recipe;
use App\Entity\Food;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
/**
 * RecipeItem
 *
 * @ORM\Table(name="recipe_item")
 * @ORM\Entity(repositoryClass="App\Repository\RecipeItemRepository")
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     */
    private $value;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string")
     */
    private $unit;

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
     * Set value
     *
     * @param integer $value
     *
     * @return RecipeItem
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return integer
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set unit
     *
     * @param string $unit
     *
     * @return RecipeItem
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;

        return $this;
    }

    /**
     * Get unit
     *
     * @return string
     */
    public function getUnit()
    {
        return $this->unit;
    }
}
