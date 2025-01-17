<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('product.index');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'success' => true,
            'data' => $products
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
            'product_name' => 'required|string',
            'category' => 'required|in:buah,sayur',
            'price' => 'required|numeric',
            'stok' => 'required|integer',
            'foto1' => 'required|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        if($request->has('foto1')) {
            $gambar = $request->file('foto1');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto1'] = $nama_gambar;
        }
        if($request->has('foto2')) {
            $gambar = $request->file('foto2');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto2'] = $nama_gambar;
        }
        if($request->has('foto3')) {
            $gambar = $request->file('foto3');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto3'] = $nama_gambar;
        }

        $product = Product::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json([
            'success' => true,
            'data' => $product
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'product_name' => 'required|string',
            'category' => 'required|in:buah,sayur',
            'price' => 'required|numeric',
            'stok' => 'required|integer',
            'foto1' => 'nullable|image|max:2048',
            'foto2' => 'nullable|image|max:2048',
            'foto3' => 'nullable|image|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(
                $validator->errors(), 422
            );
        }

        $input = $request->all();

        if ($request->hasFile('foto1')) {
            $gambar = $request->file('foto1');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto1'] = $nama_gambar;
        }

        if ($request->hasFile('foto2')) {
            $gambar = $request->file('foto2');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto2'] = $nama_gambar;
        }

        if ($request->hasFile('foto3')) {
            $gambar = $request->file('foto3');
            $nama_gambar = time() . rand(1, 9) . '.' . $gambar->getClientOriginalExtension();
            $gambar->move('uploads', $nama_gambar);
            $input['foto3'] = $nama_gambar;
        }

        $product->update($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $product
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        File::delete('uploads/'. $product->gambar);
        $product->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
