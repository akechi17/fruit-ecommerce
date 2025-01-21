<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(){
        $monthly_earning = Payment::where('status', 'DIBAYAR')
                                ->where('created_at', '>=', Carbon::now()->subMonth())
                                ->sum('jumlah');
                                
        $today_earning = Payment::where('status', 'DIBAYAR')
                                ->whereDate('created_at', Carbon::today())
                                ->sum('jumlah');
        $monthly_spending = Purchase::where('created_at', '>=', Carbon::now()->subMonth())
                                ->sum('total_harga');
                                
        $today_spending = Purchase::whereDate('created_at', Carbon::today())
                                ->sum('total_harga');

        $newOrders = Order::where('status', 'Baru')->count();
        $sentOrders = Order::where('status', 'dikirim')->count();
        $receivedOrders = Order::where('status', 'diterima')->count();
        
        return view('dashboard.index', compact('monthly_earning', 'today_earning', 'monthly_spending', 'today_spending', 'newOrders', 'sentOrders', 'receivedOrders'));
    }
}
