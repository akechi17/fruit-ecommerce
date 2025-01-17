<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\About;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(){
        $products = Product::where('stok', '>', 0)->skip(0)->take(8)->get();
        $discounts = Discount::all();
        return view('home.index', compact('products', 'discounts'));
    }
    
    public function products($category){
        $products = Product::where('category', $category)->where('stok', '>', 0)->get();
        $discounts = Discount::all();
        return view('home.products', compact('products', 'discounts'));
    }

    public function add_to_cart(Request $request){
        $input = $request->all();
        Cart::create($input);
    }

    public function delete_from_cart (Cart $cart){
        $cart->delete();
        return redirect('/cart');
    }

    public function product($id_product){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $product = Product::find($id_product);
        $discount = Discount::where('id_barang', $id_product)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
        $latest_products = Product::where('stok', '>', 0)->orderByDesc('created_at')->offset(0)->limit(10)->get();
        return view('home.product', compact('product','discount' ,'latest_products'));
    }
    public function cart(){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $carts = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        $discounts = Discount::all();
        $cart_total = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->sum('total');
        return view('home.cart', compact('carts','discounts', 'cart_total'));
    }
    public function checkout_orders(Request $request){
        $id = DB::table('orders')->insertGetId([
            'id_customer' => $request->id_customer, 
            'invoice' => date('ymds'),
            'grand_total' => $request->grand_total,
            'status' => 'Baru',
            'created_at' => date('Y-m-d H:i:s')
        ]);
        for ($i=0; $i < count($request->id_produk); $i++){
            DB::table('order_details')->insert([
                'id_order' => $id,
                'id_produk' => $request->id_produk[$i],
                'jumlah' => $request->jumlah[$i],
                'total' => $request->total[$i],
                'created_at' => date('Y-m-d H:i:s')
            ]);    
        }
    }
    public function checkout(){
        $about = About::first();
        $carts = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        $orders = Order::where('id_customer', Auth::guard('webcustomer')->user()->id)->first();
        return view('home.checkout', compact('about', 'carts', 'orders'));
    }

    public function payments(Request $request){
        Payment::create([
            'id_order' => $request->id_order,
            'id_customer' => Auth::guard('webcustomer')->user()->id,
            'jumlah' => $request->jumlah,
            'address_detail' => $request->address_detail,
            'status' => 'MENUNGGU',
            'no_rekening' => $request->no_rekening,
            'atas_nama' => $request->atas_nama,
        ]);
        $cartItems = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        foreach ($cartItems as $cartItem) {
            $product = Product::where('id', $cartItem->product->id)->first();;
            if ($product) {
                $product->update([
                    'stok' => $product->stok - $cartItem->jumlah
                ]);
            }
            $cartItem->update([
                'is_checkout' => 1
            ]);
        }
        
        return redirect('/orders');
    }

    public function orders(){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }
        
        $orders = Order::where('id_customer', Auth::guard('webcustomer')->user()->id)->get();
        $payments = Payment::where('id_customer', Auth::guard('webcustomer')->user()->id)->get();
        return view('home.orders', compact('orders', 'payments'));
    }

    public function pesanan_selesai(Order $order){
        $order->status = 'Selesai';
        $order->save();

        return redirect('/orders');
    }

    public function about(){
        $about = About::first();
        return view('home.about', compact('about'));
    }

    public function contact(){
        $about = About::first();
        return view('home.contact', compact('about'));
    }

    public function faq(){
        return view('home.faq');
    }

}
