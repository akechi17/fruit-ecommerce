<?php

namespace App\Http\Controllers;

use App\Models\DiscountCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DiscountCategoryController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/dashboard');
        }
        return view('discountcategory.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = DiscountCategory::get();

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
            'category' => 'required|string',
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

        $product = DiscountCategory::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(DiscountCategory $discount)
    {
        return response()->json([
            'success' => true,
            'data' => $discount
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DiscountCategory $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DiscountCategory $discount)
    {
        $validator = Validator::make($request->all(),[
            'category' => 'required|string',
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
    public function destroy(DiscountCategory $discount)
    {
        $discount->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
