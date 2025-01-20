@extends('layout.home')
@section('title', 'Cart')
@section('content')
      <!-- Cart -->
      <section class="section-wrap shopping-wishlist">
        <div class="container relative">
          <form class="form-wishlist">
            <input type="hidden" name="id_member" value="{{ Auth::guard('webcustomer')->user()->id }}">
            <div class="row">
              <div class="col-md-12">
                <div class="table-wrap mb-30">
                  <table class="shop_table wishlist table">
                    <thead>
                      <tr>
                        <th class="product-name" colspan="2">Product</th>
                        <th class="product-price">Price</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($wishlists as $wishlist)
                      <input type="hidden" name="id_produk[]" value="{{ $wishlist->product->id }}">
                      <tr class="wishlist_item">
                        <td class="product-thumbnail">
                          <a href="#">
                            <img src="/uploads/{{ $wishlist->product->gambar1 }}" alt="">
                          </a>
                        </td>
                        <td class="product-name">
                          <a href="#">{{ $wishlist->product->nama_barang }}</a>
                        </td>
                        <td class="product-price">
                          <span class="amount">{{ "Rp ". number_format($wishlist->product->harga) }}</span>
                        </td>
                        <td class="product-remove">
                          <a href="/delete_from_wishlist/{{ $wishlist->id }}" class="remove" title="Remove this item">
                            <i class="ui-close"></i>
                          </a>
                        </td>
                      </tr>
                      @endforeach     
                    </tbody>
                  </table>
                </div>
              </div> <!-- end col -->
            </div> <!-- end row -->  
          </form>

          
        </div> <!-- end container -->
      </section> <!-- end wishlist -->
@endsection