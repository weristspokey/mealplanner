<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;
use App\Entity\MealplanItem;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

/**
 * Mealplan
 * @ORM\Entity
 * @ORM\Table(name="mealplan")
 */
class Mealplan
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
    private $userId;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="date")
     */
    private $date;

    /**
     * @ORM\OneToMany(targetEntity="MealplanItem", mappedBy="mealplanId")
     */
    private $mealplanItems;

    public function __construct()
    {
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
     * Set userId
     *
     * @param integer $userId
     *
     * @return Mealplan
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set date
     *
     * @param date $date
     * @return Mealplan
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return date
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set mealplanItems
     *
     * @param array $mealplanItems
     *
     * @return Mealplan
     */
    public function setMealplanItems($mealplanItems)
    {
        $this->mealplanItems = $mealplanItems;

        return $this;
    }

    /**
     * Get mealplanItems
     *
     * @return array
     */
    public function getMealplanItems()
    {
        return $this->mealplanItems;
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
}
