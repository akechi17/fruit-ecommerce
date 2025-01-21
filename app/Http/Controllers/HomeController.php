<?php

namespace App\Http\Controllers;
use App\Models\Cart;
use App\Models\About;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Wishlist;
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
    
    public function products($category)
    {
        $products = Product::where('category', $category)
                        ->where('stok', '>', 0)
                        ->paginate(1); // Display 9 products per page
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
    public function add_to_wishlist(Request $request){
        $input = $request->all();
        Wishlist::create($input);
    }

    public function delete_from_wishlist (Wishlist $wishlist){
        $wishlist->delete();
        return redirect('/wishlist');
    }

    public function product($id_product){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $product = Product::find($id_product);
        $discount = Discount::where('id_barang', $id_product)->where('start_date', '<=', now())->where('end_date', '>=', now())->first();
        $latest_products = Product::where('stok', '>', 0)->orderByDesc('created_at')->offset(0)->limit(3)->get();
        return view('home.product', compact('product','discount' ,'latest_products'));
    }
    public function cart(){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ed0be3e808b51ae444bf13be133a03da"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        }

        $provinsi = json_decode($response);
        $carts = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        $cart_total = Cart::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->sum('total');
        $discounts = Discount::all();
        return view('home.cart', compact('carts', 'provinsi', 'cart_total', 'discounts'));
    }
    public function submitreview(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|between:1,5',
            'review' => 'required|string|max:255',
        ]);

        Review::create([
            'id_customer' => Auth::guard('webcustomer')->user()->id,
            'id_produk' => $request->product_id,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return redirect()->back()->with('success', 'Review submitted successfully.');
    }
    public function wishlist(){
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_member');
        }

        $wishlists = Wishlist::where('id_customer', Auth::guard('webcustomer')->user()->id)->where('is_checkout', 0)->get();
        return view('home.wishlist', compact('wishlists'));
    }
    public function get_city($id){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/city?province=" . $id,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "key: ed0be3e808b51ae444bf13be133a03da"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        }
        return $response;
    }
    public function get_ongkir($destination, $weight){
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=22&destination=".$destination."&weight=".$weight."&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: ed0be3e808b51ae444bf13be133a03da"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        }
        return $response;
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

    public function orders() {
        if (!Auth::guard('webcustomer')->user()) {
            return redirect('/login_customer');
        }

        $memberId = Auth::guard('webcustomer')->user()->id;

        // Retrieve all orders and payments for the member
        $orders = Order::where('id_customer', $memberId)->get();
        $payments = Payment::where('id_customer', $memberId)->get();

        // Initialize an array to hold order details
        $orderdetails = [];

        // Iterate over each order to retrieve its details
        foreach ($orders as $order) {
            $orderdetails[$order->id] = OrderDetail::where('id_order', $order->id)->get();
        }

        return view('home.orders', compact('orders', 'orderdetails', 'payments'));
    }
    public function getSnapToken($paymentId) {
        $payment = Payment::find($paymentId);
        if (!$payment) {
            return response()->json(['error' => 'Payment not found'], 404);
        }

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = false;
        \Midtrans\Config::$isSanitized = true;
        \Midtrans\Config::$is3ds = true;

        $customer = Auth::guard('webcustomer')->user();

        $params = array(
            'transaction_details' => array(
                'order_id' => $payment->id,
                'gross_amount' => $payment->jumlah,
            ),
            'customer_details' => array(
                'first_name' => $customer->nama_member,
                'email' => $customer->email,
                'phone' => $customer->no_hp
            ),
        );

        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return response()->json(['snapToken' => $snapToken]);
    }

    public function success(Request $request)
    {
        $paymentId = $request->query('payment_id');
        $payment = Payment::findOrFail($paymentId);
        $payment->status = 'DIBAYAR';
        $payment->save();

        return redirect()->route('home')->with('success', 'Payment successful!');
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
