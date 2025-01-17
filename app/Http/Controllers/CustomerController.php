<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    public function __construct(){
        $this->middleware('auth:api', ['except' => 'index']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();

        return response()->json([
            'data' => $customers
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
            'nama_customer' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'address_detail' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        unset($input['konfirmasi_password']);

        $customer = Customer::create($input);
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $validator = Validator::make($request->all(),[
            'nama_customer' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'address_detail' => 'required',
            'no_hp' => 'required',
            'email' => 'required|email',
            'password' => 'required|same:konfirmasi_password',
            'konfirmasi_password' => 'required|same:password'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        $input['password'] = bcrypt($request->password);
        unset($input['konfirmasi_password']);

        $customer = Customer::create($input);
        return response()->json([
            'data' => $customer
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return response()->json([
           'message' => 'Customer deleted successfully.'
        ]);
    }
}
