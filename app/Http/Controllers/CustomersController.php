<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    /**
     * Require authentication for all methods in this controller.
     */

    public function __construct(){
        $this->middleware('auth:api');
    }

    /**
     * Retrieve all customers.
     */

    public function getCustomers(){
        $suppliers = Customer::get();
        return response()->json($suppliers, 200);
    }

    /**
    * Retrieve a single customer by it's id.
    * If customer is not found, then it wil give a 404 response
    */

    public function getCustomerById(int $customerid){
        $customer = Customer::find($customerid);

        if(!$customer){
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        return response()->json($customer, 200);
    }

    /**
    * Insert a new customer
    */

    public function insertCustomer(Request $request){
        $newCustomer = Customer::create($request->all());

        return response()->json([
            'message' => 'New customer added', 
            'newbook' => $newCustomer
        ], 201);
    }

    /**
    * Update an existing customer by it's id.
    * If it's not found, then it will give a 404 response
    */

    public function updateCustomer(Request $request, int $customerid){
        $customer = Customer::find($customerid);

        if(!$customer){
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }
        
        $customer->update($request->all());

        return response()->json([
            'message' => 'Customer updated', 
            'saldo' => $customer
        ], 200);
    }

    /**
    * Delete an existing customer it's id.
    * If it's not found, then it wil give a 404 response
    */

    public function deleteCustomer(int $customerid){
        $customer = Customer::find($customerid);
        
        if(!$customer){
            return response()->json([
                'message' => 'Customer not found'
            ], 404);
        }

        $customer->delete();
        
        return response()->json([
            'message' => 'Customer deleted'
        ], 200);
    }
}