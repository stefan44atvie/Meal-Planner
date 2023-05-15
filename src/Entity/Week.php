<?php

namespace App\Entity;

use App\Repository\WeekRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WeekRepository::class)]
class Week
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'weeks', cascade: ['remove', 'persist'])]
    #[ORM\JoinColumn(onDelete: 'cascade')]
    private ?User $fk_user = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_monday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_tuesday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_wednesday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_thursday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_friday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_saturday = null;

    #[ORM\ManyToOne(inversedBy: 'weeks')]
    #[ORM\JoinColumn(onDelete: 'set null')]
    private ?Meal $fk_sunday = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFkMonday(): ?Meal
    {
        return $this->fk_monday;
    }

    public function setFkMonday(?Meal $fk_monday): self
    {
        $this->fk_monday = $fk_monday;

        return $this;
    }

    public function getFkTuesday(): ?Meal
    {
        return $this->fk_tuesday;
    }

    public function setFkTuesday(?Meal $fk_tuesday): self
    {
        $this->fk_tuesday = $fk_tuesday;

        return $this;
    }

    public function getFkWednesday(): ?Meal
    {
        return $this->fk_wednesday;
    }

    public function setFkWednesday(?Meal $fk_wednesday): self
    {
        $this->fk_wednesday = $fk_wednesday;

        return $this;
    }

    public function getFkThursday(): ?Meal
    {
        return $this->fk_thursday;
    }

    public function setFkThursday(?Meal $fk_thursday): self
    {
        $this->fk_thursday = $fk_thursday;

        return $this;
    }

    public function getFkFriday(): ?Meal
    {
        return $this->fk_friday;
    }

    public function setFkFriday(?Meal $fk_friday): self
    {
        $this->fk_friday = $fk_friday;

        return $this;
    }

    public function getFkSaturday(): ?Meal
    {
        return $this->fk_saturday;
    }

    public function setFkSaturday(?Meal $fk_saturday): self
    {
        $this->fk_saturday = $fk_saturday;

        return $this;
    }

    public function getFkSunday(): ?Meal
    {
        return $this->fk_sunday;
    }

    public function setFkSunday(?Meal $fk_sunday): self
    {
        $this->fk_sunday = $fk_sunday;

        return $this;
    }
}