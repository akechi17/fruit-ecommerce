@extends('layout.app')

@section('title', 'Order Report')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                  <h4 class="card-title">Order Report</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form>
                                <div class="form-group">
                                    <label for="dari">From</label>
                                    <input type="date" name="dari" id="dari" class="form-control" value="{{ request()->input('dari') }}">
                                </div>
                                <div class="form-group">
                                    <label for="">To</label>
                                    <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request()->input('sampai') }}">
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    @if (request()->input('dari'))
                    <div>
                        <table class="table">
                            <thead class=" text-primary">
                                <th>No</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Bought Amount</th>
                                <th>Total Qty</th>
                                <th>Profit</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div> 
</div>

@endsection

@push('js')
    <script>
        $(function(){
            const dari = '{{ request()->input('dari') }}'
            const sampai = '{{ request()->input('sampai') }}'
        
            function rupiah(angka){
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'RP ' + convert.join('.').split('').reverse().join('');
            }



            const token = localStorage.getItem('token');
            $.ajax({
                url : `/api/reports?dari=${dari}&sampai=${sampai}`,
                headers : {
                    "Authorization": token
                },
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.product_name}</td>
                            <td>${rupiah(val.price)}</td>
                            <td>${val.jumlah_dibeli}</td>
                            <td>${val.total_qty}</td>
                            <td>${rupiah(val.pendapatan)}</td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            })

        });
    </script>
@endpush