<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\GrocerylistItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Grocerylist
 *
 * @ORM\Table(name="grocerylist")
 * @ORM\Entity(repositoryClass="App\Repository\GrocerylistRepository")
 */
class Grocerylist
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
     * @ORM\ManyToOne(targetEntity="User", inversedBy="grocerylists")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="GrocerylistItem", mappedBy="grocerylistId")
     */
    private $grocerylistItems;

    public function __construct()
    {
        $this->grocerylistItems = new ArrayCollection();
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
     * @param integer $user
     *
     * @return Grocerylist
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
     * Set grocerylistItems
     *
     * @param array $grocerylistItems
     *
     * @return Grocerylist
     */
    public function setGrocerylistItems($grocerylistItems)
    {
        $this->grocerylistItems = $grocerylistItems;

        return $this;
    }

    /**
     * Get grocerylistItems
     *
     * @return array
     */
    public function getGrocerylistItems()
    {
        return $this->grocerylistItems;
    }

    /**
     * Add grocerylistItem
     *
     * @param \App\Entity\GrocerylistItem $grocerylistItem
     *
     * @return Grocerylist
     */
    public function addGrocerylistItem(\App\Entity\GrocerylistItem $grocerylistItem)
    {
        $this->grocerylistItems[] = $grocerylistItem;

        return $this;
    }

    /**
     * Remove grocerylistItem
     *
     * @param \App\Entity\GrocerylistItem $grocerylistItem
     */
    public function removeGrocerylistItem(\App\Entity\GrocerylistItem $grocerylistItem)
    {
        $this->grocerylistItems->removeElement($grocerylistItem);
    }
}
