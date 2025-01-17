<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class PaymentController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }
    
    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('payment.index');
    }

    public function index()
    {
        $payments = Payment::all();

        return response()->json([
            'data' => $payments
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
            'nama_category' => 'required',
            'deskripsi' => 'required',
            'gambar' => 'required|image|mimes:jpg,png,jpeg,webp'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();

        $payment = Payment::create($input);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $payment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        return response()->json([
            'success' => true,
            'data' => $payment
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validator = Validator::make($request->all(),[
            'tanggal' => 'required'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $payment->update([
            'status' => request('status')
        ]);
        return response()->json([
            'success' => true,
            'message' => 'success',
            'data' => $payment
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        File::delete('uploads/'. $payment->gambar);
        $payment->delete();

        return response()->json([
            'success' => true,
            'message' => 'success'
        ]);
    }
}
