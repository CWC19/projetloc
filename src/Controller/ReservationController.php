<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Entity\Utilisateur;
use App\Entity\Voiture;
use App\Form\ReservationType;
use App\Form\Utilisateur1Type;
use App\Repository\ReservationRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManager;
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
    public function index(ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
        $reservations = $entityManager->getRepository(Reservation::class)->findAll();
        $voitureIds = [];
        foreach ($reservations as $reservation) {
            $voitureIds[$reservation->getId()] = $reservation->getVoiture()->getId();     
        }
        return $this->render('reservation/index.html.twig', [
            'reservations' => $reservations,
            'voitureIds' => $voitureIds,
        ]);
    }

    #[Route('/mesres', name: 'app_mes_reservations', methods: ['GET'])]
    public function mesres(ReservationRepository $reservationRepository, EntityManagerInterface $entityManager): Response
    {
            $user = $this->getUser();
        
        if ($user) {
            $reservations = $reservationRepository->findBy(['client' => $user]);
        } else {
            // Gérer le cas où l'utilisateur n'est pas connecté
            // Par exemple, rediriger vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
            // Créer un tableau pour stocker les détails des réservations
        $reservationDetails = [];

        foreach ($reservations as $reservation) {
            $voiture = $reservation->getVoiture(); // Récupérer l'entité Voiture associée à la réservation
           // Vérifier si la voiture existe
           if ($voiture) {
            $id = $voiture->getId();
            $dateDeb = $reservation->getDateDeb();
            $dateFin = $reservation->getDateFin();
            $prix = $reservation->getPrixTT();
            $type = $voiture->getType(); // Récupérer l'entité Type associée à la voiture
            $marque = $type->getMarque();
            $modele = $type->getModel();

            // Ajouter les détails de la réservation à notre tableau
            $reservationDetails[] = [
                'marque' => $marque,
                'modele' => $modele,
                'id' => $id,
                'dateDeb' => $dateDeb,
                'dateFin' => $dateFin,
                'prixTT' => $prix,

                                // Ajoutez d'autres détails de réservation si nécessaire
            ];
        }
    }
        

        return $this->render('reservation/res.html.twig', [
            'reservationDetails' => $reservationDetails,
        ]);
    }

    #[Route('/new', name: 'app_reservation_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager, VoitureRepository $voitureRepository, ReservationRepository $reservationRepository): Response
    {
        
        // Récupérer les données de la requête
        $voitureId = $request->query->get('idv');
        $dateDebut = new \DateTime($request->query->get('datedebut'));
        $dateFin = new \DateTime($request->query->get('datef'));

        // Vérifier si la voiture est déjà réservée pour ces dates
        $existingReservation = $reservationRepository->findByCarAndDates($voitureId, $dateDebut, $dateFin);

        if ($existingReservation !== null) {
            // Gérer le cas où la voiture est déjà réservée
            // Retourner un message d'erreur ou rediriger l'utilisateur, par exemple
            // throw $this->createNotFoundException('La voiture n\'est pas disponible durant ces dates.');
            // return $this->redirectToRoute('app_voiture_index');
        //    return new Response('Le véhicule est déjà réservé pour ces dates.', Response::HTTP_BAD_REQUEST);
        $this->addFlash('error', 'La voiture est déjà réservée pour ces dates.');
            return $this->redirectToRoute('app_voiture_show', [
                'id' => $voitureId
            ]);    
    }

        $reservation = new Reservation();
        $id= $request->query->all(); 
        $pv= $request->query->get('prixv'); 
        $voitureId= $request->query->get('idv'); 
        $dd= strtotime($request->query->get('datedebut')); 
        $df= strtotime($request->query->get('datef')); 
        
        if (!empty($df) && !empty($dd)) {
            $nbj = ($df - $dd)/86400;
            // var_dump($nbj);
        }
        $dad = ($request->query->get('datedebut'));
        $daf = ($request->query->get('datef'));
        // var_dump($dad);
        $prix = $nbj * $pv;
        $reservation->setPrixTT($prix);
        $reservation->setClient($this->getUser());
        $reservation->setDateDeb($dateDebut);
        $reservation->setDateFin($dateFin);   

        // Récupérez l'objet Voiture correspondant à partir de l'identifiant
        $voiture = $voitureRepository->find($voitureId);
        // Associez la voiture à la réservation
        $reservation->setVoiture($voiture);


        
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reservation);
            $entityManager->flush();
            $reservationId = $reservation->getId();
            return $this->redirectToRoute('app_reservation_show', ['id'=>$reservationId] , Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservation/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form,
            'prix' => $prix,
            'dd' => $dad,
            'df'=>$daf

            
        ]);
    }

    #[Route('/{id}', name: 'app_reservation_show', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function show(Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'ID du type de la voiture
        $clientId = $reservation->getClient()->getId();
        // Récupérer l'entité Type par son ID
        $client = $entityManager->getRepository(Utilisateur::class)->find($clientId);
        $nom = $client->getNom();
        $prenom = $client->getPrenom();
        $email = $client->getEmail();
        $dof = $client->getDof();
        $permis = $client->getPermis();
        $sexe = $client->getSexe();
        return $this->render('reservation/show.html.twig', [
            'reservation' => $reservation,
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'dof' => $dof,
            'permis' => $permis,
            'sexe' => $sexe,
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

    
}
