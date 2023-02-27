<?php

namespace App\Repository;

use App\Entity\Location;
use App\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Order>
 *
 * @method Order|null find($id, $lockMode = null, $lockVersion = null)
 * @method Order|null findOneBy(array $criteria, array $orderBy = null)
 * @method Order[]    findAll()
 * @method Order[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderRepository extends ServiceEntityRepository
{
    private $manager;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct($registry, Order::class);
    }

    public function save(Order $entity, bool $flush = false): void
    {
        $this->manager->persist($entity);

        if ($flush) {
            $this->manager->flush();
        }
    }

    public function remove(Order $entity, bool $flush = false): void
    {
        $this->manager->remove($entity);

        if ($flush) {
            $this->manager->flush();
        }
    }

    /**
     * @param Location $entity
     * @return Order[]|null
     */
    public function getUnassignedOrders(Location $entity): ?array
    {
        return $this->findBy(['location'=>$entity, 'status'=>Order::STATUS_FOR_SHIPPING]);
    }

    /**
     * @param int $courier_id
     * @return Order|null
     */
    public function getCourierAssignedOrder(int $courier_id): ?Order
    {
        return $this->findOneBy(['courier'=>$courier_id, 'status'=>Order::STATUS_STARTED]);
    }
//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('o.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
