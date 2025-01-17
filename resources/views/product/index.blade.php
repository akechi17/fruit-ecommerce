@extends('layout.app')

@section('title', 'Products Data')

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Products</h4>
        </div>
        <div class="card-header">
          <a href="#modal-form" class="modal-tambah"><span class="btn btn-round btn-primary ms-3">Add Products</span></a>
        </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead class=" text-primary">
                <th>
                  No
                </th>
                <th>
                  Product Name
                </th>
                <th>
                  Category
                </th>
                <th>
                  Price
                </th>
                <th>
                  Stok
                </th>
                <th>
                  Img 1
                </th>
                <th>
                  Img 2
                </th>
                <th>
                  Img 3
                  </th>
                  <th>
                  Deskripsi
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

<div class="modal fade" id="modal-form" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Form Barang</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                  <form class="form-barang">
                      <div class="form-group">
                          <label for="product_name">Product Name</label>
                          <input type="text" class="form-control" name="product_name" placeholder="Nama Barang" required>
                      </div>
                      <div class="form-group">
                          <label for="">Product Category</label>
                          <select name="category" id="category" class="form-control">
                            <option value="sayur">Sayur</option>
                            <option value="buah">Buah</option>
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="price">Price</label>
                          <input type="number" class="form-control" name="price" placeholder="price" required>
                      </div>
                      <div class="form-group">
                          <label for="stok">Stok</label>
                          <input type="number" class="form-control" name="stok" placeholder="stok" required>
                      </div>
                      <div class="form-group">
                          <label for="foto1">Image 1</label>
                          <input type="file" class="form-control" name="foto1">
                      </div>
                      <div class="form-group">
                          <label for="foto2">Image 2</label>
                          <input type="file" class="form-control" name="foto2">
                      </div>
                      <div class="form-group">
                          <label for="foto3">Image 3</label>
                          <input type="file" class="form-control" name="foto3">
                      </div>
                      <div class="form-group">
                          <label for="deskripsi">Description</label>
                          <textarea id="deskripsi" class="form-control" cols="30" rows="10" name="deskripsi" placeholder="Description" required></textarea>
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
            $.ajax({
                url : '/api/products',
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.product_name}</td>
                            <td>${val.category}</td>
                            <td>${val.price}</td>
                            <td>${val.stok}</td>
                            <td><img src="/uploads/${val.foto1}" width="150" /></td>
                            <td><img src="/uploads/${val.foto2}" width="150" /></td>
                            <td><img src="/uploads/${val.foto3}" width="150" /></td>
                            <td>${val.deskripsi}</td>
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
                        url : '/api/products/' + id,
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
                $('input[name="product_name"]').val('');
                $('textarea[name="deskripsi"]').val('');

                $('.form-barang').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url : 'api/products',
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
                $.get('/api/products/' + id, function({data}){
                    $('input[name="product_name"]').val(data.product_name);
                    $('select[name="category"] option').each(function() {
                      if ($(this).val() == data.category) {
                        $(this).prop('selected', true);
                      }
                    });
                    $('input[name="price"]').val(data.price);
                    $('input[name="stok"]').val(data.stok);
                    $('textarea[name="deskripsi"]').val(data.deskripsi);
                })
                $('.form-barang').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url :  `api/products/${id}?_method=PUT`,
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