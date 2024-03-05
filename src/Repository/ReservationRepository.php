<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeRes($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.client = :c')
//            ->setParameter('c', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    // public function findAllMyReservation(int $idc): array
    // {
    //     $entityManager = $this->getEntityManager();

    //     $query = $entityManager->createQuery(
    //         'SELECT client_id, voiture_id, prix_tt, date_deb, date_fin 
    //         FROM App\Entity\Reservation r
    //         WHERE r.client_id = :idc'
    //     )->setParameter('idc', $idc);

    //     // returns an array of Product objects
    //     return $query->getResult();
    // }

//     public function findByClientId(int $clientId): array
// {
//     $entityManager = $this->getDoctrine()->getManager();

//     $query = $entityManager->createQueryBuilder()
//         ->select('r.client_id', 'r.voiture_id', 'r.prix_tt', 'r.date_deb', 'r.date_fin')
//         ->from('App\Entity\Reservation', 'r')
//         ->where('r.client_id = :clientId')
//         ->setParameter('clientId', $clientId)
//         ->getQuery();

//     return $query->getResult();
// }
}
