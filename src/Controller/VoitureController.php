<?php

namespace App\Controller;

use App\Entity\Type;
use App\Entity\Voiture;
use App\Form\VoitureType;
use App\Repository\TypeRepository;
use App\Repository\VoitureRepository;
use ContainerZ881acN\getVoitureTypeService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\Voiture as EntityVoiture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/voiture')]
class VoitureController extends AbstractController
{
    #[Route('/', name: 'app_voiture_index', methods: ['GET'])]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $voitures = $entityManager->getRepository(Voiture::class)->findAll();
        // Accéder aux informations de Type pour chaque voiture
        foreach ($voitures as $voiture) {
            $type = $voiture->getType();

            // Accéder aux propriétés de Type comme ceci :
            $marque = $type->getMarque();
            $model = $type->getModel();
            $puissance = $type->getPuissance();
            $carburant = $type->getCarburant();
            $bv = $type->getBoitevitesse();
            $categorie = $type->getCategorie();
        }
        return $this->render('voiture/index.html.twig', [
            'voitures' => $voitures,
            // 'type' => $type,
          'marque' => $marque,
         'model' => $model,
            'puissance' => $puissance,
            'carburant' => $carburant,
            'bv' => $bv,
            'categorie' => $categorie,
        ]);
    }

    #[Route('/new', name: 'app_voiture_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN',  message: 'You are not allowed to access the admin dashboard.')]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $voiture = new Voiture();
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photo1 = $form->get('photo1')->getData(); //recup le contenu du fichier
            if($photo1){
                $originalFilename = pathinfo($photo1->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo1->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $photo1->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto1($newFilename);
            }

            $photo2 = $form->get('photo2')->getData(); //recup le contenu du fichier
            if($photo2){
                $originalFilename = pathinfo($photo2->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo2->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $photo2->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto2($newFilename);
            }

            $photo3 = $form->get('photo3')->getData(); //recup le contenu du fichier
            if($photo3){
                $originalFilename = pathinfo($photo3->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo3->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $photo3->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto3($newFilename);
            }
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/new.html.twig', [
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_show', methods: ['GET'])]
    public function show(Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'ID du type de la voiture
        $typeId = $voiture->getType()->getId();
        // Récupérer l'entité Type par son ID
        $type = $entityManager->getRepository(Type::class)->find($typeId);
        $marque = $type->getMarque();
        $modele = $type->getModel();
        $puissance = $type->getPuissance();
        $carburant = $type->getCarburant();
        $bv = $type->getBoitevitesse();
        $categorie = $type->getCategorie();
        
        return $this->render('voiture/show.html.twig', [
            'voiture' => $voiture,
            'marque' => $marque,
            'modele' => $modele,
            'puissance' => $puissance,
            'carburant' => $carburant,
            'bv' => $bv,
            'categorie' => $categorie,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_voiture_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Voiture $voiture, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $i1 = $voiture->getPhoto1();
        $voiture->setPhoto1($i1);
        var_dump($i1);
        $form = $this->createForm(VoitureType::class, $voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $img1 = $form->get('photo1')->getData();
            if($img1){
                $originalFilename = pathinfo($img1->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img1->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $img1->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto1($newFilename);
            }
            
            $img2 = $form->get('photo2')->getData();
            if($img2){
                $originalFilename = pathinfo($img2->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img2->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $img2->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto2($newFilename);
            }
            
            $img3 = $form->get('photo3')->getData();
            if($img3){
                $originalFilename = pathinfo($img3->getClientOriginalName(), PATHINFO_FILENAME); //recup nom du fichier
                $safeFilename = $slugger->slug($originalFilename); //recup nom du fichier sans ext
                $newFilename = $safeFilename.'-'.uniqid().'.'.$img3->guessExtension();//nom du fichier, uniqid = nombre aleatoire(=random) et ext
                $img3->move(
                    $this->getParameter('voiture_directory'), //config services.yaml etudiant_directory=public/uploads
                    $newFilename
                );
                $voiture->setPhoto3($newFilename);
            }
            
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('voiture/edit.html.twig', [
            
            'voiture' => $voiture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_voiture_delete', methods: ['POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Request $request, Voiture $voiture, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$voiture->getId(), $request->request->get('_token'))) {
            $entityManager->remove($voiture);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_voiture_index', [], Response::HTTP_SEE_OTHER);
    }
}
