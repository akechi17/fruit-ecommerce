@extends('layout.app')

@section('title', 'Finished Orders Data')

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Finished Orders Data</h4>
        </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead class=" text-primary">
                <th>
                  No
                </th>
                <th>
                  Order Date
                </th>
                <th>
                  Invoice
                </th>
                <th>
                  Customer
                </th>
                <th>
                  Total
                </th>
              </thead>
              <tbody>

              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div> 
</div>

@endsection

@push('js')
    <script>
        $(function(){
            function rupiah(angka){
                const format = angka.toString().split('').reverse().join('');
                const convert = format.match(/\d{1,3}/g);
                return 'RP ' + convert.join('.').split('').reverse().join('');
            }

            function date(date){
                var date = new Date(date);
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();

                return `${day}-${month}-${year}`;
            }

            const token = localStorage.getItem('token');
            $.ajax({
                url : '/api/pesanan/finished',
                headers : {
                    "Authorization": token
                },
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${date(val.created_at)}</td>
                            <td>${val.invoice}</td>
                            <td>${val.customer.nama_customer}</td>
                            <td>${rupiah(val.grand_total)}</td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            })

        });
    </script>
@endpush