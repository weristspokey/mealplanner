<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Food;
use App\Entity\Grocerylist;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * GrocerylistItem
 *
 * @ORM\Table(name="grocerylist_item")
 * @ORM\Entity(repositoryClass="App\Repository\GrocerylistItemRepository")
 */
class GrocerylistItem
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
     * @ORM\ManyToOne(targetEntity="Grocerylist", inversedBy="grocerylistItems")
     * @ORM\JoinColumn(name="grocerylist_id", referencedColumnName="id")
     */
    private $grocerylistId;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="grocerylistItems")
     * @ORM\JoinColumn(name="food_id", referencedColumnName="id")
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
     * Set grocerylistId
     *
     * @param integer $grocerylistId
     *
     * @return GrocerylistItem
     */
    public function setGrocerylistId($grocerylistId)
    {
        $this->grocerylistId = $grocerylistId;

        return $this;
    }

    /**
     * Get grocerylistId
     *
     * @return int
     */
    public function getGrocerylistId()
    {
        return $this->grocerylistId;
    }

    /**
     * Set foodId
     *
     * @param integer $foodId
     *
     * @return GrocerylistItem
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
