<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Require authentication for all methods in this controller.
     */

    public function __construct(){
        $this->middleware('auth:api');
    }

    /**
     * Retrieve all suppliers.
     */

    public function getSuppliers(){
        $suppliers = Supplier::get();
        return response()->json($suppliers, 200);
    }

    /**
    * Retrieve a single supplier by it's id.
    * If supplier is not found, then it wil give a 404 response
    */

    public function getSupplierById(int $supplierid){
        $supplier = Supplier::find($supplier);

        if(!$supplierid){
            return response()->json([
                'message' => 'Supplier not found'
            ], 404);
        }

        return response()->json($supplier, 200);
    }

    /**
    * Insert a new supplier
    */

    public function insertSupplier(Request $request){
        $newSupplier = Supplier::create($request->all());

        return response()->json([
            'message' => 'New supplier added', 
            'newbook' => $newSupplier
        ], 201);
    }

    /**
    * Update an existing supplier by it's id.
    * If it's not found, then it will give a 404 response
    */

    public function updateSupplier(Request $request, int $supplierid){
        $supplier = Supplier::find($supplierid);

        if(!$supplier){
            return response()->json([
                'message' => 'Supplier not found'
            ], 404);
        }
        
        $supplier->update($request->all());

        return response()->json([
            'message' => 'Supplier updated', 
            'saldo' => $supplier
        ], 200);
    }

    /**
    * Delete an existing supplier it's id.
    * If it's not found, then it wil give a 404 response
    */

    public function deleteSupplier(int $supplierid){
        $supplier = Supplier::find($supplierid);
        
        if(!$supplier){
            return response()->json([
                'message' => 'Supplier not found'
            ], 404);
        }

        $supplier->delete();
        
        return response()->json([
            'message' => 'Supplier deleted'
        ], 200);
    }
}