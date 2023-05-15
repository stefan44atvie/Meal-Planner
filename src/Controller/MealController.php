<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Entity\IngredientMeal;
use App\Entity\Meal;
use App\Form\MealType;
use App\Repository\IngredientMealRepository;
use App\Repository\IngredientRepository;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class MealController extends AbstractController
{
    #[Route('/meal', name: 'app_meal_index', methods: ['GET'])]
    public function index(MealRepository $mealRepository): Response
    {
        $activeuser = $this->getUser();
        $count = count($mealRepository->findBy(['approved' => 0]));
        return $this->render('meal/index.html.twig', [
            'meals' => $mealRepository->findBy(['approved' => 1]),
            'user' => $activeuser,
            'count' => $count,
        ]);
    }

    #[Route('/newmeal', name: 'app_meal_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MealRepository $mealRepository, FileUploader $fileUploader, IngredientRepository $ingredientRepository, IngredientMealRepository $ingredientMealRepository): Response
    {
        $meal = new Meal();
        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meal->setFkUser($this->getUser());
            $meal->setApproved(0);
            $image = $form->get('picture')->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $meal->setPicture($imageName);
            }
            $mealRepository->save($meal, true);

            return $this->redirectToRoute('app_meal_index', [], Response::HTTP_SEE_OTHER);
        }
        

        return $this->render('meal/new.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/meal{id}', name: 'app_meal_show', methods: ['GET'])]
    public function show(Meal $meal, MealRepository $mealRepository, $id): Response
    {
        $my = $mealRepository->find(['id' => $id]);
        $final = $my->getIngredients();
        $final = explode(',', $final);
        // $ingredients = [];
        // foreach($final as $fin) {
        //     $ingredients[] = $fin;
        // }
        return $this->render('meal/show.html.twig', [
            'meal' => $meal,
            'ingredient' => $final,
        ]);
    }

    #[Route('/meal{id}/edit', name: 'app_meal_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meal $meal, MealRepository $mealRepository, FileUploader $fileUploader, IngredientMealRepository $ingredientMealRepository, IngredientRepository $ingredientRepository, $id): Response
    {


        $form = $this->createForm(MealType::class, $meal);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $currentpic = $meal->getPicture();
            $image = $form->get('picture')->getData();
            if ($image) {
                unlink($this->getParameter("image_directory") . $currentpic);
                $imageName = $fileUploader->upload($image);
                $meal->setPicture($imageName);
            }

            $mealRepository->save($meal, true);

            return $this->redirectToRoute('app_meal_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meal/edit.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/meal{id}/delete', name: 'app_meal_delete')]
    public function delete(ManagerRegistry $doctrine, $id)
    {
        $em = $doctrine->getManager();
        $meal = $doctrine->getRepository(Meal::class)->find($id);
        $image = $meal->getPicture();
        if (file_exists($this->getParameter("image_directory") . $image)) {
            unlink($this->getParameter("image_directory") . $image);
        }

        $em->remove($meal);
        $em->flush();

        return $this->redirectToRoute('app_meal_index');
    }

    #[Route('/meal/approve', name: 'app_meal_approve')]
    public function approve(MealRepository $mealRepository): Response
    {
        $count = count($mealRepository->findBy(['approved' => 0]));
        // dd($mealRepository->findBy(['approved' => 0]));
        return $this->render('meal/approve.html.twig', [
            'meals' => $mealRepository->findBy(['approved' => 0]),
            'user' => $this->getUser(),
            'count' => $count,
        ]);
    }
    

    #[Route('/meal{id}/approve', name: 'app_meal_approve_one')]
    public function approveOne(Meal $meal, MealRepository $mealRepository): Response
    {
        $meal->setApproved(1);
        $mealRepository->save($meal, true);
        return $this->redirectToRoute('app_meal_approve');
    }

    #[Route('/meal/{search}', name: 'app_meal_search')]
    public function search(MealRepository $mealRepository, $search): Response
    {
        $activeuser = $this->getUser();
        $count = count($mealRepository->findBy(['approved' => 0]));
        return $this->render('meal/index.html.twig', [
            'meals' => $mealRepository->searchBy($search),
            'user' => $activeuser,
            'count' => $count,
        ]);
    }
}
