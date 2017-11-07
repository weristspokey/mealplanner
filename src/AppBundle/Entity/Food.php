<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Food
 *
 * @ORM\Table(name="food")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FoodRepository")
 */
class Food
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, unique=true)
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="in_stock", type="boolean")
     */
    private $inStock;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_vegetarian", type="boolean")
     */
    private $isVegetarian;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_vegan", type="boolean")
     */
    private $isVegan;


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
     * Set name
     *
     * @param string $name
     *
     * @return Food
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
     * Set inStock
     *
     * @param boolean $inStock
     *
     * @return Food
     */
    public function setInStock($inStock)
    {
        $this->inStock = $inStock;

        return $this;
    }

    /**
     * Get inStock
     *
     * @return bool
     */
    public function getInStock()
    {
        return $this->inStock;
    }

    /**
     * Set isVegetarian
     *
     * @param boolean $isVegetarian
     *
     * @return Food
     */
    public function setIsVegetarian($isVegetarian)
    {
        $this->isVegetarian = $isVegetarian;

        return $this;
    }

    /**
     * Get isVegetarian
     *
     * @return bool
     */
    public function getIsVegetarian()
    {
        return $this->isVegetarian;
    }

    /**
     * Set isVegan
     *
     * @param boolean $isVegan
     *
     * @return Food
     */
    public function setIsVegan($isVegan)
    {
        $this->isVegan = $isVegan;

        return $this;
    }

    /**
     * Get isVegan
     *
     * @return bool
     */
    public function getIsVegan()
    {
        return $this->isVegan;
    }
}

