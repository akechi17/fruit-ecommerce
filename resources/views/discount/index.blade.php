@extends('layout.app')

@section('title', 'Discounts Data')

@section('content')
<div class="content">
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Discounts</h4>
        </div>
        <div class="card-header">
          <a href="#modal-form" class="modal-tambah"><span class="btn btn-round btn-primary ms-3">Add Discounts</span></a>
        </div>
        <div class="card-body">
          <div>
            <table class="table">
              <thead class=" text-primary">
                <th>
                  No
                </th>
                <th>
                  Product
                </th>
                <th>
                  Start Date
                </th>
                <th>
                  End Date
                </th>
                <th>
                  Percentage
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
                          <label for="id_barang">Product Name</label>
                          <select name="id_barang" id="category" class="form-control">
                            @foreach ($products as $product)
                              <option value="{{ $product->id }}">{{ $product->product_name }}</option> 
                            @endforeach
                          </select>
                      </div>
                      <div class="form-group">
                          <label for="start_date">Start Date</label>
                          <input type="date" class="form-control" name="start_date" required>
                      </div>
                      <div class="form-group">
                          <label for="end_date">End Date</label>
                          <input type="date" class="form-control" name="end_date" required>
                      </div>
                      <div class="form-group">
                          <label for="percentage">Percentage</label>
                          <input type="number" class="form-control" name="percentage" placeholder="percentage" required>
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
                url : '/api/discounts',
                success : function({data}){
                    let row;
                    data.map(function(val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.product.product_name}</td>
                            <td>${val.start_date}</td>
                            <td>${val.end_date}</td>
                            <td>${val.percentage}%</td>
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
                        url : '/api/discounts/' + id,
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
                        url : 'api/discounts',
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
                $.get('/api/discounts/' + id, function({data}){
                    $('input[name="start_date"]').val(data.start_date);
                    $('input[name="end_date"]').val(data.end_date);
                    $('input[name="percentage"]').val(data.percentage);

                    $('select[name="id_barang"] option').each(function() {
                      if ($(this).val() == data.id_barang) {
                        $(this).prop('selected', true);
                      }
                    });
                })
                $('.form-barang').submit(function(e){
                    e.preventDefault();

                    const token = localStorage.getItem('token');
                    const formdata = new FormData(this);

                    $.ajax({
                        url :  `api/discounts/${id}?_method=PUT`,
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