<?php

namespace App\Entity;

use App\Repository\MealRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\User;

#[ORM\Entity(repositoryClass: MealRepository::class)]
class Meal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[ORM\Column(length: 50)]
    private ?string $category = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column]
    private ?float $rating = null;

    #[ORM\Column(length: 1000)]
    private ?string $preparation = null;

    #[ORM\Column]
    private ?int $cooking_time = null;

    #[ORM\OneToMany(mappedBy: 'fk_monday', targetEntity: Week::class)]
    private Collection $weeks;

    #[ORM\OneToMany(mappedBy: 'fk_meal', targetEntity: IngredientMeal::class)]
    private Collection $ingredientMeals;

    #[ORM\ManyToOne(inversedBy: 'meals')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?User $fk_user = null;

    #[ORM\Column]
    private ?bool $approved = null;

    #[ORM\Column(length: 1000)]
    private ?string $Ingredients = null;

    public function __construct()
    {
        $this->weeks = new ArrayCollection();
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

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->category;
    }

    public function setCategory(string $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): self
    {
        $this->calories = $calories;

        return $this;
    }

    public function getRating(): ?float
    {
        return $this->rating;
    }

    public function setRating(float $rating): self
    {
        $this->rating = $rating;

        return $this;
    }

    public function getPreparation(): ?string
    {
        return $this->preparation;
    }

    public function setPreparation(string $preparation): self
    {
        $this->preparation = $preparation;

        return $this;
    }

    public function getCookingTime(): ?int
    {
        return $this->cooking_time;
    }

    public function setCookingTime(int $cooking_time): self
    {
        $this->cooking_time = $cooking_time;

        return $this;
    }

    /**
     * @return Collection<int, Week>
     */
    public function getWeeks(): Collection
    {
        return $this->weeks;
    }

    public function addWeek(Week $week): self
    {
        if (!$this->weeks->contains($week)) {
            $this->weeks->add($week);
            $week->setFkMonday($this);
        }

        return $this;
    }

    public function removeWeek(Week $week): self
    {
        if ($this->weeks->removeElement($week)) {
            // set the owning side to null (unless already changed)
            if ($week->getFkMonday() === $this) {
                $week->setFkMonday(null);
            }
        }

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
            $ingredientMeal->setFkMeal($this);
        }

        return $this;
    }

    public function removeIngredientMeal(IngredientMeal $ingredientMeal): self
    {
        if ($this->ingredientMeals->removeElement($ingredientMeal)) {
            // set the owning side to null (unless already changed)
            if ($ingredientMeal->getFkMeal() === $this) {
                $ingredientMeal->setFkMeal(null);
            }
        }

        return $this;
    }

    public function getFkUser(): ?User
    {
        return $this->fk_user;
    }

    public function setFkUser(?User $fk_user): self
    {
        $this->fk_user = $fk_user;

        return $this;
    }

    public function isApproved(): ?bool
    {
        return $this->approved;
    }

    public function setApproved(bool $approved): self
    {
        $this->approved = $approved;

        return $this;
    }

    public function getIngredients(): ?string
    {
        return $this->Ingredients;
    }

    public function setIngredients(string $Ingredients): self
    {
        $this->Ingredients = $Ingredients;

        return $this;
    }
}
