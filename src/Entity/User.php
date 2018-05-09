<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use App\Entity\Recipe;
use App\Entity\Tag;
use App\Entity\Grocerylist;
use App\Entity\KitchenList;
use App\Entity\MealplanItem;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @UniqueEntity(fields="email", message="Email already taken")
 * @UniqueEntity(fields="username", message="Username already taken")
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, \Serializable
{
     public function __construct()
    {
        $this->recipes = new ArrayCollection();
        $this->tags = new ArrayCollection();
        $this->grocerylists = new ArrayCollection();
        $this->kitchenLists = new ArrayCollection();
        $this->mealplanItems = new ArrayCollection();
    }

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
     * @ORM\Column(name="username", type="string", length=16, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, unique=true)
     */
    private $email;

    private $plainPassword;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity="Recipe", mappedBy="id")
     */
    private $recipes;

    /**
     * @ORM\OneToMany(targetEntity="Grocerylist", mappedBy="id")
     */
    private $grocerylists;

    /**
     * @ORM\OneToMany(targetEntity="KitchenList", mappedBy="id")
     */
    private $kitchenLists;

    /**
     * @ORM\OneToMany(targetEntity="Tag", mappedBy="id")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity="MealplanItem", mappedBy="id")
     */
    private $mealplanItems;

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
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set plainPassword
     *
     * @param mixed $plainPassword
     *
     * @return User
     */
    public function setPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * Get plainPassword
     *
     * @return mixed
     */
    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    
    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    public function serialize()
    {
        return serialize([
            $this->id,
            $this->username,
            $this->password,
        ]);
    }

    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
        ) = unserialize($serialized);
    }

    public function getRoles()
    {
        return [
            'ROLE_USER',
        ];
    }

    public function getSalt()
    {
        return null;
    }
    
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }


    /**
     * Add recipe
     *
     * @param \App\Entity\Recipe $recipe
     *
     * @return User
     */
    public function addRecipe(\App\Entity\Recipe $recipe)
    {
        $this->recipes[] = $recipe;

        return $this;
    }

    /**
     * Remove recipe
     *
     * @param \App\Entity\Recipe $recipe
     */
    public function removeRecipe(\App\Entity\Recipe $recipe)
    {
        $this->recipes->removeElement($recipe);
    }

    /**
     * Get recipes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getRecipes()
    {
        return $this->recipes;
    }

    /**
     * Add tag
     *
     * @param \App\Entity\Tag $tag
     *
     * @return User
     */
    public function addTag(\App\Entity\Tag $tag)
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Remove tag
     *
     * @param \App\Entity\Tag $tag
     */
    public function removeTag(\App\Entity\Tag $tag)
    {
        $this->tags->removeElement($tag);
    }

    /**
     * Get tags
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Add grocerylist
     *
     * @param \App\Entity\Grocerylist $grocerylist
     *
     * @return User
     */
    public function addGrocerylist(\App\Entity\Grocerylist $grocerylist)
    {
        $this->grocerylists[] = $grocerylist;

        return $this;
    }

    /**
     * Remove grocerylist
     *
     * @param \App\Entity\Grocerylist $grocerylist
     */
    public function removeGrocerylist(\App\Entity\Grocerylist $grocerylist)
    {
        $this->grocerylists->removeElement($grocerylist);
    }

    /**
     * Get grocerylists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getGrocerylists()
    {
        return $this->grocerylists;
    }

    /**
     * Add kitchenlist
     *
     * @param \App\Entity\KitchenList $kitchenList
     *
     * @return User
     */
    public function addKitchenList(\App\Entity\KitchenList $kitchenList)
    {
        $this->kitchenLists[] = $kitchenList;

        return $this;
    }

    /**
     * Remove kitchenList
     *
     * @param \App\Entity\KitchenList $kitchenList
     */
    public function removeKitchenList(\App\Entity\KitchenList $kitchenList)
    {
        $this->kitchenLists->removeElement($kitchenList);
    }

    /**
     * Get kitchenLists
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getKitchenLists()
    {
        return $this->kitchenLists;
    }

    /**
     * Get mealplans
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getMealplanItems()
    {
        return $this->mealplanItems;
    }

    /**
     * Add mealplan
     *
     * @param \App\Entity\MealplanItem $mealplanItem
     *
     * @return User
     */
    public function addMealplanItem(\App\Entity\MealplanItem $mealplanItem)
    {
        $this->mealplanItems[] = $mealplanItems;

        return $this;
    }

    /**
     * Remove mealplan
     *
     * @param \App\Entity\MealplanItem $mealplanItem
     */
    public function removeMealplanItem(\App\Entity\MealplanItem $mealplanItem)
    {
        $this->mealplanItems->removeElement($mealplanItem);
    }

}
