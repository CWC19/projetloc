<?php

namespace App\Controller;

use App\Entity\Avis;
use App\Entity\Reservation;
use App\Form\AvisType;
use App\Repository\AvisRepository;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avis')]
class AvisController extends AbstractController
{
    #[Route('/', name: 'app_avis_index', methods: ['GET'])]
    public function index(AvisRepository $avisRepository, EntityManagerInterface $entityManager): Response
    {
        $avis = $entityManager->getRepository(Avis::class)->findAll();
        foreach ($avis as $avi) {
            $aut = $avi->getAuteur();
            $idaut = $aut->getId();
            $nom = $aut->getNom();
            $prenom = $aut->getPrenom();
            
        }
        return $this->render('avis/index.html.twig', [
            'avis' => $avis,
            'idaut' => $idaut,
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }

    #[Route('/mesavis', name: 'app_mes_avis', methods: ['GET'])]
    public function mesavis(AvisRepository $avisRepository): Response
    {
        return $this->render('avis/mesavis.html.twig', [
            'avis' => $avisRepository->findBy(
                     ["auteur" => $this->getUser()]
                ),
        ]);
    }

    #[Route('/new', name: 'app_avis_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, ReservationRepository $reservationRepository): Response
    {
        $res = $reservationRepository->findBy(["client" => $this->getUser()]);
        if (!$res) {
            throw $this->createNotFoundException('Vous n\'êtes pas autorisé à laisser un avis car vous n\'avez jamais effectué de réservation.');
        }

        $avi = new Avis();
        $avi->setAuteur($this->getUser());
        $avi->setDateP(new \DateTime('now'));
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avi);
            $entityManager->flush();

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/new.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avis_show', methods: ['GET'])]
    public function show(Avis $avi): Response
    {
            $aut = $avi->getAuteur();
            $idaut = $aut->getId();
            $nom = $aut->getNom();
            $prenom = $aut->getPrenom();
        return $this->render('avis/show.html.twig', [
            'avi' => $avi,
            'idaut' => $idaut,
            'nom' => $nom,
            'prenom' => $prenom,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avis_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvisType::class, $avi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avis/edit.html.twig', [
            'avi' => $avi,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avis_delete', methods: ['POST'])]
    public function delete(Request $request, Avis $avi, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avi->getId(), $request->request->get('_token'))) {
            $entityManager->remove($avi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_avis_index', [], Response::HTTP_SEE_OTHER);
    }
}
