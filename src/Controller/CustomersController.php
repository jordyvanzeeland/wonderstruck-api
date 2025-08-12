<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Customers;
use App\Repository\CustomersRepository;

class CustomersController extends AbstractController
{

    #[Route('/api/customers', name: 'get_customers')]
    public function getCustomers(CustomersRepository $customersRepository): JsonResponse
    {
        try {
            $customers = $customersRepository->findAll();
            return $this->json($customers, 200);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to get customers', 'details' => $e->getMessage()], 500);
        }
    }

    #[Route('/api/customer/{id}', name: 'get_customer_id')]
     public function getCustomerById(CustomersRepository $customersRepository, int $id): JsonResponse
     {
        try{
            $customer = $customersRepository->find($id);
    
            if(!$customer){
                return $this->json([
                    'message' => 'Customer not found'
                ]);
            }
    
            return $this->json($customer, 200);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to get customer', 'details' => $e->getMessage()], 500);
        }
     }

    #[Route('/api/customers/insert', name: 'insert_customer', methods: ['POST'])]
    public function insertCustomer(Request $request, EntityManagerInterface $entityManager, CustomersRepository $customersRepository): JsonResponse
    {
        try {
            $data = json_decode($request->getContent(), true);

            $customer = (new Customers())
                        ->setUserId($data['userid'])
                        ->setName($data['name'])
                        ->setAddress($data['address'])
                        ->setZipcode($data['zipcode'])
                        ->setCity($data['city'])
                        ->setEmail($data['email'])
                        ->setPhone($data['phone']);
                        
            $entityManager->persist($customer);
            $entityManager->flush();

            return $this->json([
                'message' => 'Customer added',
                'customer' => $customer
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save customer', 'details' => $e->getMessage()], 500);
        }
    }

    #[Route('/api/customer/{id}/update', name: 'update_customer', methods: ['PUT'])]
     public function updateCustomer(Request $request, EntityManagerInterface $entityManager, CustomersRepository $customersRepository, int $id): JsonResponse
     {
        try{
            $customer = $customersRepository->find($id);

            if(!$customer){
                return $this->json([
                    'message' => 'Customer not found'
                ]);
            }

            $data = json_decode($request->getContent(), true);

            $customer->setUserId($data['userid']);
            $customer->setName($data['name']);
            $customer->setAddress($data['address']);
            $customer->setZipcode($data['zipcode']);
            $customer->setCity($data['city']);
            $customer->setEmail($data['email']);
            $customer->setPhone($data['phone']);

            $entityManager->flush();

            return $this->json([
                'message' => 'Customer updated',
                'supplier' => $customer
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save customer', 'details' => $e->getMessage()], 500);
        }  
     }

    #[Route('/api/customer/{id}/delete', name: 'delete_customer', methods: ['DELETE'])]
    public function deleteCustomer(EntityManagerInterface $entityManager, CustomersRepository $customersRepository, int $id): JsonResponse
    {
        try{
            $customer = $customersRepository->find($id);

            if(!$customer){
                return $this->json([
                    'message' => 'Customer not found'
                ]);
            }
    
            $entityManager->remove($customer);
            $entityManager->flush();
    
            return $this->json([
                'message' => 'Customer deleted'
            ], 201);
        } catch (\Exception $e) {
            return $this->json(['error' => 'Failed to save customer', 'details' => $e->getMessage()], 500);
        }
    }

}