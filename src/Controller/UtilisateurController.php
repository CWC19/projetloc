<?php

namespace App\Controller;

// use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Form\Utilisateur1Type;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/utilisateur')]
class UtilisateurController extends AbstractController
{ 
    #[Route('/', name: 'app_utilisateur_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(UtilisateurRepository $utilisateurRepository): Response
    {
        return $this->render('utilisateur/index.html.twig', [
            'utilisateurs' => $utilisateurRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_utilisateur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $passEncoded): Response
    {
        $utilisateur = new Utilisateur();
        $form = $this->createForm(Utilisateur1Type::class, $utilisateur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $utilisateur->setRoles(['Client']);
            $utilisateur->setPassword($passEncoded->hashPassword($utilisateur, $form->get('password')->getData()));
            $entityManager->persist($utilisateur);
            $entityManager->flush();

            return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/new.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Utilisateur $utilisateur): Response
    {
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur,
        ]);
    }

    #[Route('/compte/{id}', name: 'app_utilisateur_compte', methods: ['GET'])]
    public function compte(Request $request, Utilisateur $utilisateur): Response
    {
        
        return $this->render('utilisateur/compte.html.twig', [
            'utilisateur' => $utilisateur,
            // 'reservation' => $reservation
        ]);
    }

    #[Route('/{id}/edit', name: 'app_utilisateur_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]

    public function edit(Request $request, Utilisateur $utilisateur,UserPasswordHasherInterface $passEncoded, EntityManagerInterface $entityManager): Response
    {
        if ($this->isGranted('ROLE_ADMIN')) {
            // Créer le formulaire en permettant la modification du rôle
            $form = $this->createForm(Utilisateur1Type::class, $utilisateur);
        } else {
            // Créer le formulaire en rendant le champ de sélection du rôle non modifiable
            $form = $this->createForm(Utilisateur1Type::class, $utilisateur, [
                'disabled_role_field' => true,
            ]);
        }
        // $form = $this->createForm(Utilisateur1Type::class, $utilisateur);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
                
                $utilisateur->setPassword($passEncoded->hashPassword($utilisateur, $form->get('password')->getData()));
                $entityManager->persist($utilisateur);
                $entityManager->flush();
            $entityManager->flush();

            return $this->redirectToRoute('app_accueil', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('utilisateur/edit.html.twig', [
            'utilisateur' => $utilisateur,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_utilisateur_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Utilisateur $utilisateur, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$utilisateur->getId(), $request->request->get('_token'))) {
            $entityManager->remove($utilisateur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_utilisateur_index', [], Response::HTTP_SEE_OTHER);
    }
}
