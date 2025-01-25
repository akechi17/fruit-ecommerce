@extends('layout.home')
@section('title', 'Checkout')
@section('content')
<!-- breadcrumb-section -->
<div class="breadcrumb-section breadcrumb-bg">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 offset-lg-2 text-center">
        <div class="breadcrumb-text">
          <p>Fresh and Organic</p>
          <h1>My Orders</h1>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- end breadcrumb section -->

<section class="section-wrap checkout pb-70">
  <div class="container relative">
    <div class="row">
      <div class="ecommerce col-md-12 py-5">
        <h2>My Payments</h2>
        <table class="table table-ordered table-hover table-stripped">
          <thead>
            <th>No</th>
            <th>Tanggal</th>
            <th>Nominal Transfer</th>
            <th>Status</th>
            <th>Action</th>
          </thead>
          <tbody>
              @foreach ($payments as $index => $payment)
                <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $payment->created_at }}</td>
                  <td>Rp. {{ number_format($payment->jumlah) }}</td>
                  <td>{{ $payment->status }}</td>
                  <td>
                    @if ($payment->status === 'DIBAYAR')
                      <button type="button" class="btn btn-success pay-button" data-id="{{ $payment->id }}" disabled>DIBAYAR</button>
                    @else
                      <button type="button" class="btn btn-success pay-button" data-id="{{ $payment->id }}">BAYAR</button>
                    @endif                    
                  </td>
                </tr>
              @endforeach
          </tbody>
        </table>
      </div> <!-- end ecommerce -->

      <div class="ecommerce col-md-12 pb-5">
        <h2>My Orders</h2>
        <table class="table table-ordered table-hover table-stripped">
          <thead>
            <th>No</th>
            <th>Produk</th>
            <th>Tanggal</th>
            <th>Status</th>
            <th>Aksi</th>
          </thead>
          <tbody>
              @foreach ($orders as $index => $order)
                @php $firstDetail = true; @endphp
                @foreach ($orderdetails[$order->id] as $detail)
                <tr>
                  @if ($firstDetail)
                    <td>{{ $index+1 }}</td>
                    @php $firstDetail = false; @endphp
                  @else
                    <td></td>
                  @endif
                  <td>{{ $detail->product->product_name }}</td>
                  <td>{{ $order->created_at }}</td>
                  <td>{{ $order->status }}</td>
                  <td>
                    @if ($order->status === 'Selesai')
                      <!-- Button to trigger modal -->
                      <button type="button" class="btn btn-success" data-toggle="modal" data-target="#reviewModal{{ $detail->id }}">REVIEW</button>

                      <!-- Modal -->
                      <div class="modal fade" id="reviewModal{{ $detail->id }}" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel{{ $detail->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="reviewModalLabel{{ $detail->id }}">Review Produk {{ $detail->product->product_name }}</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <form action="/submit_review" method="POST" id="reviewform">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $detail->product->id }}">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="rating" style="font-size: 24px; direction: rtl;">
                                        <i class="fa fa-star" data-value="5"></i>
                                        <i class="fa fa-star" data-value="4"></i>
                                        <i class="fa fa-star" data-value="3"></i>
                                        <i class="fa fa-star" data-value="2"></i>
                                        <i class="fa fa-star" data-value="1"></i>
                                    </div>
                                    <input type="hidden" name="rating" value="" required>
                                </div>
                                <div class="form-group">
                                  <label for="review">Review</label>
                                  <textarea class="form-control" id="review" name="review" rows="3" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Submit Review</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                    @else
                      <form action="/pesanan_selesai/{{ $order->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">SELESAI</button>
                      </form>
                    @endif  
                  </td>
                </tr>
                @endforeach
              @endforeach
          </tbody>
        </table>
      </div> <!-- end ecommerce -->

    </div> <!-- end row -->
  </div> <!-- end container -->
</section> <!-- end checkout -->
@endsection

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-AW4Eljj2dIb4kaLq"></script>
<script type="text/javascript">
document.addEventListener("DOMContentLoaded", function() {
    // Adding the pay-button class to the buttons that are not disabled
    document.querySelectorAll('.pay-button:not([disabled])').forEach(function(button) {
        button.addEventListener('click', function(event) {
            // Prevent default action for the button click
            event.preventDefault();
            
            var paymentId = this.getAttribute('data-id');
            console.log('Pay button clicked for payment ID:', paymentId);

            // Make an AJAX call to get the Snap token
            fetch(`/get-snap-token/${paymentId}`)
                .then(response => response.json())
                .then(data => {
                    console.log('Snap token received:', data.snapToken);
                    window.snap.pay(data.snapToken, {
                        onSuccess: function(result){
                          console.log('Payment successful:', result);
                          window.location.href = `{{ route('payment.success') }}?payment_id=${paymentId}`;
                        },
                        onPending: function(result){
                            alert("waiting for your payment!"); console.log(result);
                        },
                        onError: function(result){
                            alert("payment failed!"); console.log(result);
                        },
                        onClose: function(){
                            alert('you closed the popup without finishing the payment');
                        }
                    });
                }).catch(error => {
                    console.error('Error fetching Snap token:', error);
                });
        }, { passive: false });
    });

    const stars = document.querySelectorAll('.rating .fa-star');
			const ratingInput = document.querySelector('input[name="rating"]');
			let ratingSelected = false;
		
			stars.forEach(star => {
				star.addEventListener('click', () => {
					ratingSelected = true;
					const ratingValue = star.getAttribute('data-value');
					ratingInput.value = ratingValue;
		
					// Reset the color of all stars
					stars.forEach(s => s.classList.remove('selected'));
		
					// Set the color of the selected stars
					star.classList.add('selected');
					let nextStar = star.nextElementSibling;
					while (nextStar) {
						nextStar.classList.add('selected');
						nextStar = nextStar.nextElementSibling;
					}
				});
		
				star.addEventListener('mouseover', () => {
					stars.forEach(s => s.classList.remove('hover'));
					star.classList.add('hover');
					let nextStar = star.nextElementSibling;
					while (nextStar) {
						nextStar.classList.add('hover');
						nextStar = nextStar.nextElementSibling;
					}
				});
		
				star.addEventListener('mouseout', () => {
					stars.forEach(s => s.classList.remove('hover'));
				});
			});
		
			// Add event listener to the form
			const form = document.querySelector('#reviewform');
			form.addEventListener('submit', (e) => {
				if (!ratingSelected) {
					e.preventDefault();
					alert('Please select a rating.');
				}
		});
});
</script>
