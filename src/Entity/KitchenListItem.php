<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
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
