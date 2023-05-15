<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Week;
use App\Form\WeekType;
use App\Repository\MealRepository;
use App\Repository\WeekRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/week')]
class WeekController extends AbstractController
{
    #[Route('/{id}&{day}', name: 'week_index_set', methods: ['GET'])]
    public function indexset(WeekRepository $weekRepository, $id, MealRepository $mealRepository, $day): Response
    {
        if($week = $weekRepository->findOneBy(['fk_user' => $this->getUser()])) {
        } else {
            $week = new Week();
        }
        
        $meal = $mealRepository->find($id);
        if ($day == 1) {
            $week->setFkMonday($meal);
        } elseif($day == 2) {
            $week->setFkTuesday($meal);
        } elseif($day == 3) {
            $week->setFkWednesday($meal);
        } elseif($day == 4) {
            $week->setFkThursday($meal);
        } elseif($day == 5) {
            $week->setFkFriday($meal);
        } elseif($day == 6) {
            $week->setFkSaturday($meal);
        } elseif($day == 7) {
            $week->setFkSunday($meal);
        }
        $week->setFkUser($this->getUser());
        $weekRepository->save($week, true);

        return $this->redirectToRoute('app_meal_detail', ['id' => $id
        ]);
    }

    #[Route('/', name: 'week_index', methods: ['GET'])]
    public function index(WeekRepository $weekRepository): Response
    {
        $week = $weekRepository->findOneBy(['fk_user' => $this->getUser()]);
        $week->setFkUser($this->getUser());
        $weekRepository->save($week, true);
        $monday = $week->getFkMonday();
        $tuesday = $week->getFkTuesday();
        $wednesday = $week->getFkWednesday();
        $thursday = $week->getFkThursday();
        $friday = $week->getFkFriday();
        $saturday = $week->getFkSaturday();
        $sunday = $week->getFkSunday();

        return $this->render('week/index.html.twig', [
            'weeks' => $weekRepository->findBy(['fk_user' => $this->getUser()]),
            'monday' => $monday,
            'tuesday' => $tuesday,
            'wednesday' => $wednesday,
            'thursday' => $thursday,
            'friday' => $friday,
            'saturday' => $saturday,
            'sunday' => $sunday,
        ]);
    }
}