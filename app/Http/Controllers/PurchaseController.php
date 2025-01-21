<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list(Request $request){
        if ((Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/dashboard');
        }
        
        $suppliers = Supplier::all();
        return view('purchase.index', compact('suppliers'));
    }

    public function index()
    {
        $purchases = Purchase::with('supplier')->get();

        return response()->json([
            'success' => true,
            'data' => $purchases
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'product' => 'required|string',
            'supplier_id' => 'required|string',
            'kuantitas' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $purchase = Purchase::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $purchase
        ]);
    }

    public function show(Purchase $purchase)
    {
        return response()->json([
            'success' => true,
            'data' => $purchase
        ]);
    }

    public function update(Request $request, Purchase $purchase)
    {
        $validator = Validator::make($request->all(),[
            'product' => 'required|string',
            'supplier_id' => 'required|string',
            'kuantitas' => 'required|integer',
            'total_harga' => 'required|integer',
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $purchase->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $purchase
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase $purchase)
    {
        $purchase->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}