<?php

namespace App\Controller;

use App\Entity\Meal;
use App\Form\Meal1Type;
use App\Repository\MealRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user/meal')]
class MealUserController extends AbstractController
{
    #[Route('/', name: 'app_meal_user_index', methods: ['GET'])]
    public function index(MealRepository $mealRepository): Response
    {
        return $this->render('meal_user/index.html.twig', [
            'meals' => $mealRepository->findBy(["fk_user" => $this->getUser(), 'approved' => 1]),
        ]);
    }

    #[Route('/new', name: 'app_meal_user_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MealRepository $mealRepository, FileUploader $fileUploader): Response
    {
        $meal = new Meal();
        $form = $this->createForm(Meal1Type::class, $meal);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meal->setApproved(0);
            $meal->setFkUser($this->getUser());
            $image = $form->get('picture')->getData();
            if ($image) {
                $imageName = $fileUploader->upload($image);
                $meal->setPicture($imageName);
            }

            $mealRepository->save($meal, true);

            return $this->redirectToRoute('app_meal_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meal_user/new.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_meal_user_show', methods: ['GET'])]
    public function show(Meal $meal, MealRepository $mealRepository, $id): Response
    {
        $my = $mealRepository->find(['id' => $id]);
        $final = $my->getIngredients();
        $final = explode(',', $final);

        return $this->render('meal_user/show.html.twig', [
            'meal' => $meal,
            'ingredient' => $final,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_meal_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Meal $meal, MealRepository $mealRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(Meal1Type::class, $meal);
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

            return $this->redirectToRoute('app_meal_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('meal_user/edit.html.twig', [
            'meal' => $meal,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'app_meal_user_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $meal = $doctrine->getRepository(Meal::class)->find($id);
        $image = $meal->getPicture();
        if (file_exists($this->getParameter("image_directory") . $image)) {
            unlink($this->getParameter("image_directory") . $image);
        }

        $em->remove($meal);
        $em->flush();

        return $this->redirectToRoute('app_meal_user_index',);
    }

    // #[Route('/meal{id}/delete', name: 'app_meal_delete')]
    // public function delete(ManagerRegistry $doctrine, $id)
    // {
    //     $em = $doctrine->getManager();
    //     $meal = $doctrine->getRepository(Meal::class)->find($id);
    //     $image = $meal->getPicture();
    //     if (file_exists($this->getParameter("image_directory") . $image)) {
    //         unlink($this->getParameter("image_directory") . $image);
    //     }

    //     $em->remove($meal);
    //     $em->flush();

    //     return $this->redirectToRoute('app_meal_index');
    // }
}
