<?php

namespace App\Entity;

use App\Repository\IngredientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IngredientRepository::class)]
class Ingredient
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Nutrition::class, inversedBy: 'ingredients')]
    private Collection $fk_nutrition;

    #[ORM\OneToMany(mappedBy: 'fk_ingredient', targetEntity: IngredientMeal::class)]
    private Collection $ingredientMeals;

    public function __construct()
    {
        $this->fk_nutrition = new ArrayCollection();
        $this->ingredientMeals = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Nutrition>
     */
    public function getFkNutrition(): Collection
    {
        return $this->fk_nutrition;
    }

    public function addFkNutrition(Nutrition $fkNutrition): self
    {
        if (!$this->fk_nutrition->contains($fkNutrition)) {
            $this->fk_nutrition->add($fkNutrition);
        }

        return $this;
    }

    public function removeFkNutrition(Nutrition $fkNutrition): self
    {
        $this->fk_nutrition->removeElement($fkNutrition);

        return $this;
    }

    /**
     * @return Collection<int, IngredientMeal>
     */
    public function getIngredientMeals(): Collection
    {
        return $this->ingredientMeals;
    }

    public function addIngredientMeal(IngredientMeal $ingredientMeal): self
    {
        if (!$this->ingredientMeals->contains($ingredientMeal)) {
            $this->ingredientMeals->add($ingredientMeal);
            $ingredientMeal->setFkIngredient($this);
        }

        return $this;
    }

    public function removeIngredientMeal(IngredientMeal $ingredientMeal): self
    {
        if ($this->ingredientMeals->removeElement($ingredientMeal)) {
            // set the owning side to null (unless already changed)
            if ($ingredientMeal->getFkIngredient() === $this) {
                $ingredientMeal->setFkIngredient(null);
            }
        }

        return $this;
    }
}
