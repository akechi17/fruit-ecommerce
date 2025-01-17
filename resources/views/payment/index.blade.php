@extends('layout.app')

@section('title', 'Data Pembayaran')

@section('content')
<div class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Payment Data</h4>
                </div>
                <div class="card-body">
                    <div>
                        <table class="table">
                        <thead class=" text-primary">
                            <th>
                            No
                            </th>
                            <th>
                            Date
                            </th>
                            <th>
                            Order
                            </th>
                            <th>
                            Total
                            </th>
                            <th>
                            Account Number
                            </th>
                            <th>
                            Name
                            </th>
                            <th>
                            Status
                            </th>
                            <th class='text-center'>
                            Action
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
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Form Pembayaran</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-pembayaran">
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="text" class="form-control" name="tanggal" placeholder="Tanggal" readonly>
                        </div>
                        <div class="form-group">
                            <label for="jumlah">Jumlah</label>
                            <input type="text" class="form-control" name="jumlah" placeholder="Jumlah" readonly>
                        </div>
                        <div class="form-group">
                            <label for="no_rekening">No Rekening</label>
                            <input type="text" class="form-control" name="no_rekening" placeholder="No Rekening" readonly>
                        </div>
                        <div class="form-group">
                            <label for="atas_nama">Atas Nama</label>
                            <input type="text" class="form-control" name="atas_nama" placeholder="Atas Nama" readonly>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" id="status" class="form-control">
                                <option value="DITERIMA">DITERIMA</option>
                                <option value="DITOLAK">DITOLAK</option>
                                <option value="MENUNGGU">MENUNGGU</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            
            $.ajax({
                url : '/api/payments',
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        tgl = new Date(val.created_at);
                        tgl_lengkap = `${tgl.getDate()}-${tgl.getMonth()}-${tgl.getFullYear()}`;
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${tgl_lengkap}</td>
                            <td>${val.id_order}</td>
                            <td>${rupiah(val.jumlah)}</td>
                            <td>${val.no_rekening}</td>
                            <td>${val.atas_nama}</td>
                            <td>${val.status}</td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                            </td>
                        </tr>
                        `;
                    });
                    $('tbody').append(row)
                }
            })

            $(document).on('click', '.btn-hapus', function(){
                const id = $(this).data('id');
                const token = localStorage.getItem('token');

                confirm_dialog = confirm('Are you sure you want to delete this?');
      
                if (confirm_dialog){
                    $.ajax({
                        url : '/api/payments/' + id,
                        type : "DELETE",
                        headers: {
                            "Authorization": token
                        },
                        success : function(data) {
                            if(data.message == "success"){
                                alert('data deleted successfully');
                                location.reload();
                            }
                        }
                    });
                }
            });

            function date(date){
                var date = new Date(date);
                var day = date.getDate();
                var month = date.getMonth();
                var year = date.getFullYear();

                return `${day}-${month}-${year}`;
            }

            $(document).on('click', '.modal-ubah', function(){
                $('modal-form').modal('show');
                const id = $(this).data('id');
                $.get('/api/payments/' + id, function({data}){
                    $('input[name="tanggal"]').val(date(data.created_at));
                    $('input[name="jumlah"]').val(rupiah(data.jumlah));
                    $('input[name="no_rekening"]').val(data.no_rekening);
                    $('input[name="atas_nama"]').val(data.atas_nama);
                    $('select[name="status"]').val(data.status);
                })
                $('.form-pembayaran').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url :  `api/payments/${id}?_method=PUT`,
                        type : 'POST',
                        data : formdata,
                        cache : false,
                        contentType: false,
                        processData: false,
                        headers: {
                            "Authorization": token
                        },
                        success : function(data) {
                            if(data.success){
                                alert('data updated successfully');
                                location.reload();
                            }
                        }
                    })
                })
            })
        });
    </script>
@endpush