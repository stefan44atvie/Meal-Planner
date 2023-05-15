<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\MealRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, MealRepository $mealRepository): Response
    {
        $activeuser = $this->getUser();
        $count = count($mealRepository->findBy(['approved' => 0]));
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->searchWithout($activeuser),
            'actuser' => $activeuser,
            'count' => $count,
        ]);
    }


    // #[Route('/user{id}', name: 'app_user_show', methods: ['GET'])]
    // public function yourProfile(User $user, $id): Response
    // {
    //     if ($id != $this->getUser()->getId()) {
    //         return $this->redirectToRoute('app_home');
    //     }
    //     return $this->render('user/show.html.twig', [
    //         'user' => $user,
    //     ]);
    // }


    #[Route('/user/{search}', name: 'app_user_search')]
    public function search(UserRepository $userRepository, $search, MealRepository $mealRepository): Response
    {
        $activeuser = $this->getUser();
        $count = count($mealRepository->findBy(['approved' => 0]));
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->searchBy($search),
            'actuser' => $activeuser,
            'count' => $count,
        ]);
    }

    #[Route('/user{id}', name: 'app_user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/user{id}/edit', name: 'app_user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $currentpic = $user->getImage();
            $image = $form->get('image')->getData();
            if ($image) {
                unlink($this->getParameter("image_directory") . $currentpic);
                $imageName = $fileUploader->upload($image);
                $user->setImage($imageName);
            }
            $userRepository->save($user, true);

            return $this->redirectToRoute('app_user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/user{id}/delete', name: 'app_user_delete')]
    public function delete(ManagerRegistry $doctrine, $id): Response
    {
        $em = $doctrine->getManager();
        $user = $doctrine->getRepository(User::class)->find($id);
        $image = $user->getImage();
        if (file_exists($this->getParameter("image_directory") . $image)) {
            unlink($this->getParameter("image_directory") . $image);
        }

        $em->remove($user);
        $em->flush();


        return $this->redirectToRoute('app_user_index');
    }
}
