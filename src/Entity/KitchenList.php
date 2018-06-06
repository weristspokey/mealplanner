<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\KitchenListItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


/**
 * KitchenList
 *
 * @ORM\Table(name="kitchenList")
 * @ORM\Entity(repositoryClass="App\Repository\KitchenListRepository")
 */
class KitchenList
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="kitchenLists")
     */
    private $user;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="KitchenListItem", mappedBy="kitchenListId")
     */
    private $kitchenListItems;

    public function __construct()
    {
        $this->kitchenListItems = new ArrayCollection();
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
     * @return KitchenList
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
     * @return KitchenList
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
     * Set kitchenListItems
     *
     * @param array $kitchenListItems
     *
     * @return KitchenList
     */
    public function setKitchenListItems($kitchenListItems)
    {
        $this->kitchenListItems = $kitchenListItems;

        return $this;
    }

    /**
     * Get kitchenListItems
     *
     * @return array
     */
    public function getKitchenListItems()
    {
        return $this->kitchenListItems;
    }

    /**
     * Add kitchenListItem
     *
     * @param \App\Entity\KitchenListItem $kitchenListItem
     *
     * @return KitchenListItem
     */
    public function addKitchenListItem(\App\Entity\KitchenListItem $kitchenListItem)
    {
        $this->kitchenListItems[] = $kitchenListItem;

        return $this;
    }

    /**
     * Remove kitchenListItem
     *
     * @param \App\Entity\GrocerylistItem $kitchenListItem
     */
    public function removeKitchenListItem(\App\Entity\KitchenListItem $kitchenListItem)
    {
        $this->kitchenListItems->removeElement($kitchenListItem);
    }
}
