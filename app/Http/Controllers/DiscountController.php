<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiscountController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        $products = Product::all();
        return view('discount.index', compact('products'));
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::with('product')->get();

        return response()->json([
            'success' => true,
            'data' => $discounts
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_barang' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'percentage' => 'required|integer',
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $product = Discount::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        return response()->json([
            'success' => true,
            'data' => $discount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Discount $discount)
    {
        $validator = Validator::make($request->all(),[
            'id_barang' => 'required|integer',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'percentage' => 'required|integer',
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $discount->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $discount
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
