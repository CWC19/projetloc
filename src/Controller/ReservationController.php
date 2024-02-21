<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Form\ReservationType;
use App\Form\Utilisateur1Type;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;


#[Route('/reservation')]
class ReservationController extends AbstractController
{
    #[Route('/', name: 'app_reservation_index', methods: ['GET'])]
    #[IsGranted('ROLE_ADMIN')]
    public function index(ReservationRepository $reservationRepository): Response
    {
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reservation = new Reservation();
        $id= $request->query->all(); 
        // var_dump($id);
        $idd= $request->query->get('idv'); 
        // var_dump($idd);
        $pv= $request->query->get('prixv'); 
        // var_dump($pv);
        $dd= strtotime($request->query->get('datedebut')); 
        // var_dump($dd);
        $df= strtotime($request->query->get('datef')); 
        // var_dump($df);
        $reservation->setClient($this->getUser());
        
        // $reservation->setVoiture($id);
        if (!empty($df) && !empty($dd)) {
            $nbj = ($df - $dd)/86400;
            // var_dump($nbj);
        }
        $prix = $nbj * $pv;
        $reservation->setPrixTT($prix);
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,

            
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reservation_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_delete', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_reservation_index', [], Response::HTTP_SEE_OTHER);
    }

    // #[Route('/res/{id}', name: 'app_reservation_compte', methods: ['GET'])]
    // public function compte(Reservation $reservation): Response
    // {
    //     return $this->render('reservation/res.html.twig', [
    //         'reservation' => $reservation,
    //     ]);
    // }

    // #[Route('/res/{id}', name: 'app_reservation_res', methods: ['GET'])]
    // public function res(Reservation $reservation, EntityManagerInterface $entityManager, Request $request): Response
    // {
    //     $id= $request->query->get('id'); var_dump($id);
    //     $res = $entityManager->getRepository(Reservation::class)->findAllMyReservation($id);
    //     var_dump($res);
    //     return $this->render('reservation/res.html.twig', [
    //         // 'reservation' => $reservation,
    //         'res' => $res,
    //     ]);
    // }

    // #[Route('/res/{id}', name: 'app_reservation_res', methods: ['GET'])]
    // public function res(Reservation $reservation, EntityManagerInterface $entityManager): Response
    // {
    //     return $this->render('reservation/res.html.twig', [
    //         'reservation' => $reservation,
            
    //     ]);
    // }
    
    // #[Route('/res/{id}', name: 'app_reservation_res')]
    // public function getClientReservations(int $id, ReservationRepository $reservationRepository): Response
    // {
        
    //     // Appel de la méthode pour récupérer les réservations du client
    //     $reservations = $reservationRepository->findByClientId($id);
    //     var_dump($reservations);
    //     // Vous pouvez faire d'autres traitements avec les résultats obtenus

    //     // Retourne une réponse, vous pouvez renvoyer des données dans un template Twig
    //     return $this->render('reservation/res.html.twig', [
    //         'reservations' => $reservations,
    //     ]);
    // }
}
