@extends('layout.home')
@section('title', 'Checkout')
@section('content')
<div class="bg-light py-3">
  <div class="container">
    <div class="row">
      <div class="col-md-12 mb-0">
        <a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> 
        <strong class="text-black">Cart</strong>
      </div>
    </div>
  </div>
</div>
<div class="site-section">
  <div class="container">
    <div class="row mb-5">
      <form class="col-md-12 form-cart">
        <div class="site-blocks-table">
          <h2>My Payments</h2>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="product-thumbnail">No</th>
                <th class="product-name">Date</th>
                <th class="product-price">Transfer Nominal</th>
                <th class="product-quantity">Status</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($payments as $index => $payment)
              <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $payment->created_at }}</td>
                <td>Rp. {{ number_format($payment->jumlah) }}</td>
                <td>{{ $payment->status }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </form>
      <form class="col-md-12 form-cart">
        <div class="site-blocks-table">
          <h2>My Orders</h2>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th class="product-thumbnail">No</th>
                <th class="product-name">Date</th>
                <th class="product-price">Grand Total</th>
                <th class="product-quantity">Status</th>
                <th class="product-quantity">Action</th>
              </tr>
            </thead>
            <tbody>
            @foreach ($orders as $index => $order)
              <tr>
                <td>{{ $index+1 }}</td>
                <td>{{ $order->created_at }}</td>
                <td>Rp. {{ number_format($order->grand_total) }}</td>
                <td>{{ $order->status }}</td>
                <td>
                  <form action="/pesanan_selesai/{{ $order->id }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">SELESAI</button>
                  </form>
                </td>
              </tr>
            @endforeach
            </tbody>
          </table>
        </div>
      </form>
    </div>
  </div>
</div>

@endsection