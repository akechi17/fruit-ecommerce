<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class ReviewController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('review.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reviews = Review::all();

        return response()->json([
            'success' => true,
            'data' => $reviews
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
            'id_customer' => 'required',
            'id_produk' => 'required',
            'review' => 'required',
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        if($request->has('gambar')) {
            $gambar = $request->file('gambar');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['gambar'] = $nama_gambar;
        }

        $review = Review::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $review
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Review $review)
    {
        return response()->json([
            'success' => true,
            'data' => $review
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Review $review)
    {
        $validator = Validator::make($request->all(),[
            'id_customer' => 'required',
            'id_produk' => 'required',
            'review' => 'required',
            'rating' => 'required'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $review->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $review
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
