<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\User1Type;
use App\Form\User2Type;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

#[Route('/user')]
class EditselfController extends AbstractController
{
    #[Route('/info/{id}', name: 'app_editself_index', methods: ['GET'])]
    public function index(UserRepository $userRepository, $id): Response
    {
        return $this->render('editself/index.html.twig', [
            'users' => $userRepository->findBy(['id' => $id]),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_editself_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserRepository $userRepository, FileUploader $fileUploader, $id): Response
    {
        $form = $this->createForm(User1Type::class, $user);
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

            return $this->redirectToRoute('app_editself_index', ['id' => $id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('editself/edit.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }

    #[Route('/self{id}/delete', name: 'app_editself_delete')]
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
        return $this->redirectToRoute('app_login', []);
    }

    #[Route('/change/password', name: 'app_editself_change_password', methods: ['GET', 'POST'])]
    public function chnagePassword(Request $request, UserRepository $userRepository, FileUploader $fileUploader, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(User2Type::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userRepository->save($user, true);
            return $this->redirectToRoute('app_editself_index', ['id' => $user->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->render('editself/changepass.html.twig', [
            'user' => $user,
            'form2' => $form,
        ]);
    }

}




