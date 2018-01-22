<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Food;
use App\Entity\KitchenList;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Table(name="kitchenListItem")
 * @ORM\Entity(repositoryClass="App\Repository\KitchenListItemRepository")
 */
class KitchenListItem
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
     * @ORM\ManyToOne(targetEntity="KitchenList", inversedBy="kitchenListItems")
     * @ORM\JoinColumn(name="kitchenList_id", referencedColumnName="id")
     */
    private $kitchenListId;

    /**
     * @ORM\ManyToOne(targetEntity="Food", inversedBy="kitchenListItems")
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
     * Set kitchenListId
     *
     * @param integer $kitchenListId
     *
     * @return KitchenListitem
     */
    public function setKitchenListId($kitchenListId)
    {
        $this->kitchenListId = $kitchenListId;

        return $this;
    }

    /**
     * Get kitchenListId
     *
     * @return int
     */
    public function getKitchenListId()
    {
        return $this->kitchenListId;
    }

    /**
     * Set foodId
     *
     * @param integer $foodId
     *
     * @return KitchenListItem
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
