@extends('layout.app')

@section('title', 'Data Transaksi')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <div class="card-title">Data Transaksi</div>
    </div>
    <div class="card-body">
        <div class="d-flex justify-content-end mb-4">
            <a href="#modal-form" class="btn btn-primary modal-tambah">Tambah Data</a>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-stripped">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Barang</th>
                        <th>Supplier</th>
                        <th>Kuantitas</th>
                        <th>Harga</th>
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Form Transaksi</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-barang">
                        <div class="form-group">
                            <label for="product">Nama Barang</label>
                            <input type="text" class="form-control" name="product" placeholder="Nama Barang" required>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier</label>
                            <select name="supplier_id" id="supplier_id" class="form-control">
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}">{{ $supplier->name }}</option> 
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="kuantitas">Kuantitas</label>
                            <input type="number" class="form-control" name="kuantitas" placeholder="Kuantitas" required>
                        </div>
                        <div class="form-group">
                          <label for="total_harga">Harga</label>
                          <input type="number" class="form-control" name="total_harga" placeholder="Harga" required>
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
        function formatDate(date) {
            const months = [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ];

            let day = date.getDate();
            let month = months[date.getMonth()];
            let year = date.getFullYear();

            return `${day} ${month} ${year}`;
        }

        $(function(){
            $.ajax({
                url : '/api/purchases',
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        let date = new Date(val.created_at);
                        let formattedDate = formatDate(date);
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.product}</td>
                            <td>${val.supplier.name}</td>
                            <td>${val.kuantitas}</td>
                            <td>${val.total_harga}</td>
                            <td>${formattedDate}</td>
                            <td>
                                <a data-toggle="modal" href="#modal-form" data-id="${val.id}" class="btn btn-warning modal-ubah">Edit</a>
                                <a href="#" data-id="${val.id}" class="btn btn-danger btn-hapus">Delete</a>
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
                        url : '/api/purchases/' + id,
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

            $('.modal-tambah').click(function(){
                $('#modal-form').modal('show');
                $('input[name="nama_barang"]').val('');
                $('textarea[name="deskripsi"]').val('');

                $('.form-barang').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url : 'api/purchases',
                        type : 'POST',
                        data : formdata,
                        cache : false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'Authorization': token
                        },
                        success : function(data) {
                            if(data.success){
                                alert('data added successfully');
                                location.reload();
                            }
                        }
                    })
                })
            })

            $(document).on('click', '.modal-ubah', function(){
                $('modal-form').modal('show');
                const id = $(this).data('id');
                $.get('/api/purchases/' + id, function({data}){
                    $('input[name="product"]').val(data.product);
                    $('select[name="supplier_id"] option').each(function() {
                      if ($(this).val() == data.supplier_id) {
                        $(this).prop('selected', true);
                      }
                    });
                    $('input[name="kuantitas"]').val(data.kuantitas);
                    $('input[name="total_harga"]').val(data.total_harga);
                })
                $('.form-barang').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url :  `api/purchases/${id}?_method=PUT`,
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