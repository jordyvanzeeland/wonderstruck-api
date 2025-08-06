<?php

namespace App\Repository;

use App\Entity\Suppliers;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Supplier>
 */
class SuppliersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Suppliers::class);
        $this->entityManager = $this->getEntityManager();
    }

    public function save(Suppliers $supplier, bool $flush = true): void
    {
        $this->entityManager->persist($supplier);
        if ($flush) {
            $this->entityManager->flush();
        }
    }

    public function update(): void
    {
        $this->entityManager->flush();
    }

    public function remove(Suppliers $supplier, bool $flush = true): void
    {
        $this->entityManager->remove($supplier);
        if ($flush) {
            $this->entityManager->flush();
        }
    }
}