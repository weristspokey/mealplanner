<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;


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
}
