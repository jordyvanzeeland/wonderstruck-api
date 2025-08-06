<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Suppliers;
use App\Repository\SuppliersRepository;

class SuppliersController extends AbstractController
{
    /**
     * Retrieve all suppliers
     */

    #[Route('/api/suppliers', name: 'get_suppliers')]
    public function getSuppliers(SuppliersRepository $suppliersRepository): JsonResponse
    {
        try {
            $suppliers = $suppliersRepository->findAll();
            return $this->json($suppliers, 200);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to get suppliers', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Retrieve a specific supplier given by ID
     * If no supplier is found, return an error message
     */

     #[Route('/api/supplier/{id}', name: 'get_supplier_id')]
     public function getSupplierById(SuppliersRepository $suppliersRepository, int $id): JsonResponse
     {
        try{
            $supplier = $suppliersRepository->find($id);
    
            if(!$supplier){
                return $this->json([
                    'message' => 'Supplier not found'
                ]);
            }
    
            return $this->json($supplier, 200);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to get supplier', 'details' => $e->getMessage()], 500);
        }
     }

     /**
     * Insert a new supplier
     */

    #[Route('/api/suppliers/insert', name: 'insert_supplier', methods: ['POST'])]
    public function insertSupplier(Request $request, SuppliersRepository $suppliersRepository): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            if (!is_array($data)) {
                return $this->json(['error' => 'Invalid JSON payload'], 400);
            }

            $requiredFields = ['name', 'address', 'zipcode', 'city', 'email', 'phone'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return $this->json(['error' => "Missing or empty field: $field"], 400);
                }
            }

            $supplier = (new Suppliers())
                        ->setName($data['name'])
                        ->setAddress($data['address'])
                        ->setZipcode($data['zipcode'])
                        ->setCity($data['city'])
                        ->setEmail($data['email'])
                        ->setPhone($data['phone']);
                        
            $suppliersRepository->save($supplier);

            return $this->json([
                'message' => 'Supplier added',
                'supplier' => $supplier
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save supplier', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Update a specific supplier given by ID
     * If no supplier is found, return an error message
     */

     #[Route('/api/supplier/{id}/update', name: 'update_supplier', methods: ['PUT'])]
     public function updateSupplier(Request $request, SuppliersRepository $suppliersRepository, int $id): JsonResponse
     {
        try{
            $supplier = $suppliersRepository->find($id);

            if(!$supplier){
                return $this->json([
                    'message' => 'Supplier not found'
                ]);
            }

            $data = json_decode($request->getContent(), true);

            if (!is_array($data)) {
                return $this->json(['error' => 'Invalid JSON payload'], 400);
            }

            $requiredFields = ['name', 'address', 'zipcode', 'city', 'email', 'phone'];
            foreach ($requiredFields as $field) {
                if (empty($data[$field])) {
                    return $this->json(['error' => "Missing or empty field: $field"], 400);
                }
            }

            $supplier->setName($data['name']);
            $supplier->setAddress($data['address']);
            $supplier->setZipcode($data['zipcode']);
            $supplier->setCity($data['city']);
            $supplier->setEmail($data['email']);
            $supplier->setPhone($data['phone']);

            $suppliersRepository->update();

            return $this->json([
                'message' => 'Supplier updated',
                'supplier' => $supplier
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save supplier', 'details' => $e->getMessage()], 500);
        }
        
     }

     /**
     * Delete a specific supplier given by ID
     * If no supplier is found, return an error message
     */

    #[Route('/api/supplier/{id}/delete', name: 'delete_supplier', methods: ['DELETE'])]
    public function deleteSupplier(SuppliersRepository $suppliersRepository, int $id): JsonResponse
    {
        try{
            $supplier = $suppliersRepository->find($id);

            if(!$supplier){
                return $this->json([
                    'message' => 'supplier not found'
                ]);
            }
    
            $suppliersRepository->remove($supplier);
    
            return $this->json([
                'message' => 'supplier deleted'
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save supplier', 'details' => $e->getMessage()], 500);
        }
    }
}