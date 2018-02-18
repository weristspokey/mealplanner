<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;

class RecipeItemCollection
{
    protected $recipeItemCollection;

    public function __construct()
    {
        $this->recipeItemCollection = new ArrayCollection();
    }

    public function getRecipeItemCollection()
    {
        return $this->recipeItemCollection;
    }
}
