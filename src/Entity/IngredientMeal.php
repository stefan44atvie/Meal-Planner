<?php

namespace App\Entity;

use App\Repository\IngredientMealRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientMealRepository::class)]
class IngredientMeal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $amount = null;

    #[ORM\ManyToOne(inversedBy: 'IngredientMeals', cascade:["persist"])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Meal $fk_meal = null;

    #[ORM\ManyToOne(inversedBy: 'IngredientMeals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Ingredient $fk_ingredient = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?string
    {
        return $this->amount;
    }

    public function setAmount(string $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getFkMeal(): ?Meal
    {
        return $this->fk_meal;
    }

    public function setFkMeal(?Meal $fk_meal): self
    {
        $this->fk_meal = $fk_meal;

        return $this;
    }

    public function getFkIngredient(): ?Ingredient
    {
        return $this->fk_ingredient;
    }

    public function setFkIngredient(?Ingredient $fk_ingredient): self
    {
        $this->fk_ingredient = $fk_ingredient;

        return $this;
    }
}
