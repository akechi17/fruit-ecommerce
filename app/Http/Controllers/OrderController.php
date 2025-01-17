<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;


class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth')->only(['list', 'confirmed_list', 'packed_list', 'sent_list', 'received_list', 'finished_list']);
        $this->middleware('auth:api')->only(['store', 'update', 'destroy', 'ubah_status', 'baru', 'confirmed', 'packed', 'sent', 'received', 'finished' ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::with('customer')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.index');
    }

    public function confirmed_list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.confirmed');
    }

    public function packed_list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.packed');
    }

    public function sent_list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.sent');
    }

    public function received_list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.received');
    }

    public function finished_list(){
        if (!(Auth::guard('web')->user()->role == 'admin')) {
            return redirect('/home');
        }
        return view('pesanan.finished');
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
            'id_customer' => 'required'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        $order = Order::create($input);

        for ($i = 0; $i < count($input['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }

        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        return response()->json([
            'data' => $order
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(),[
            'id_customer' => 'required'
        ]);

        if ($validator->fails()) {
           return response()->json(
            $validator->errors(),422
           );
        }

        $input = $request->all();
        $order->update($input);
        OrderDetail::where('id_order', $order['id'])->delete();
        for ($i = 0; $i < count($input['id_produk']); $i++) {
            OrderDetail::create([
                'id_order' => $order['id'],
                'id_produk' => $input['id_produk'][$i],
                'jumlah' => $input['jumlah'][$i],
                'size' => $input['size'][$i],
                'color' => $input['color'][$i],
                'total' => $input['total'][$i],
            ]);
        }
        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function ubah_status(Request $request, Order $order) {
        $order->update([
            'status' => $request->status
        ]);
        return response()->json([
            'message' => 'success',
            'data' => $order
        ]);
    }

    public function baru(){
        $orders = Order::with('customer')->where('status', 'Baru')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function confirmed(){
        $orders = Order::with('customer')->where('status', 'confirmed')->get();

        return response()->json([
            'data' => $orders
        ]);
    }
    
    public function packed(){
        $orders = Order::with('customer')->where('status', 'packed')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function sent(){
        $orders = Order::with('customer')->where('status', 'sent')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function received(){
        $orders = Order::with('customer')->where('status', 'received')->get();

        return response()->json([
            'data' => $orders
        ]);
    }

    public function finished(){
        $orders = Order::with('customer')->where('status', 'finished')->get();

        return response()->json([
            'data' => $orders
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return response()->json([
           'message' => 'Order deleted successfully.'
        ]);
    }
}
