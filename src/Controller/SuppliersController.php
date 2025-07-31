<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Suppliers;

class SuppliersController extends AbstractController
{
    /**
     * Retrieve all suppliers
     */

    #[Route('/api/suppliers', name: 'get_suppliers')]
    public function getSuppliers(EntityManagerInterface $entityManager): JsonResponse
    {
        $suppliers = $entityManager->getRepository(Suppliers::class)->findAll();
        return $this->json($suppliers, 200);
    }

    /**
     * Retrieve a specific supplier given by ID
     * If no supplier is found, return an error message
     */

     #[Route('/api/supplier/{id}', name: 'get_supplier_id')]
     public function getSupplierById(EntityManagerInterface $entityManager, int $id): JsonResponse
     {
         $supplier = $entityManager->getRepository(Suppliers::class)->find($id);
 
         if(!$supplier){
             return $this->json([
                 'message' => 'Supplier not found'
             ]);
         }
 
         return $this->json($supplier, 200);
     }

     /**
     * Insert a new supplier
     */

    #[Route('/api/suppliers/insert', name: 'insert_supplier', methods: ['POST'])]
    public function insertSupplier(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $supplier = new Suppliers();
        $supplier->setName($data['name']);
        $supplier->setAddress($data['address']);
        $supplier->setZipcode($data['zipcode']);
        $supplier->setCity($data['city']);
        $supplier->setEmail($data['email']);
        $supplier->setPhone($data['phone']);

        $entityManager->persist($supplier);
        $entityManager->flush();

        return $this->json([
            'message' => 'Supplier added',
            'supplier' => $supplier
        ], 201);
    }

    /**
     * Update a specific supplier given by ID
     * If no supplier is found, return an error message
     */

     #[Route('/api/supplier/{id}/update', name: 'update_supplier', methods: ['PUT'])]
     public function updateSupplier(Request $request, EntityManagerInterface $entityManager, int $id): JsonResponse
     {
        $supplier = $entityManager->getRepository(Suppliers::class)->find($id);

        if(!$supplier){
            return $this->json([
                'message' => 'Supplier not found'
            ]);
        }

        $data = json_decode($request->getContent(), true);

        $supplier->setName($data['name']);
        $supplier->setAddress($data['address']);
        $supplier->setZipcode($data['zipcode']);
        $supplier->setCity($data['city']);
        $supplier->setEmail($data['email']);
        $supplier->setPhone($data['phone']);

        $entityManager->flush();

        return $this->json([
            'message' => 'Supplier updated',
            'supplier' => $supplier
        ], 201);
     }

     /**
     * Delete a specific supplier given by ID
     * If no supplier is found, return an error message
     */

    #[Route('/api/supplier/{id}/delete', name: 'delete_supplier', methods: ['DELETE'])]
    public function deleteSupplier(EntityManagerInterface $entityManager, int $id): JsonResponse
    {
        $supplier = $entityManager->getRepository(Suppliers::class)->find($id);

        if(!$supplier){
            return $this->json([
                'message' => 'supplier not found'
            ]);
        }

        $entityManager->remove($supplier);
        $entityManager->flush();

        return $this->json([
            'message' => 'supplier deleted'
        ], 201);
    }
}