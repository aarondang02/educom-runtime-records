<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Form\ChangePasswordType;
use App\Form\ChangeAccountInfoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;


#[Route('/account')]
class AccountController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }


    #[Route('/', name: 'app_account')]
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');
        return $this->render('account/index.html.twig', [
            "user" => $this->getUser(),
        ]);
    }

    #[Route('/change-password', name: 'app_change_password')]
    public function changePassword(Request $request)
    {
        /** @var User $user */
        $user = $this->getUser();
        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            // Check if the current password is correct
            if (!$this->passwordHasher->isPasswordValid($user, $data['currentPassword'])) {
                $this->addFlash('error', 'Current password is incorrect.');
                return $this->redirectToRoute('app_change_password');
            }

            // Update the password
            $newHashedPassword = $this->passwordHasher->hashPassword($user, $data['newPassword']);
            $user->setPassword($newHashedPassword);
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Password updated successfully.');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/change_password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/change-account-info', name: 'app_change_account_info')]
    public function changeAccountInfo(Request $request)
    {
        $user = $this->getUser();
        $form = $this->createForm(ChangeAccountInfoType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            $this->addFlash('success', 'Account info updated successfully.');

            return $this->redirectToRoute('app_account');
        }

        return $this->render('account/change_account_info.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
