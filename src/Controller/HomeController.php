<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\MealRepository;
use App\Repository\UserRepository;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    
}
