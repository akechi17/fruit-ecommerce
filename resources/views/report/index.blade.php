@extends('layout.app')

@section('title', 'Laporan Pesanan')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <div class="card-title">Laporan Pesanan</div>
    </div>
    <div class="card-body">

        <div class="row">
            <div class="col-md-6">
                <form>
                    <div class="form-group">
                        <label for="">Dari</label>
                        <input type="date" name="dari" id="dari" class="form-control" value="{{ request()->input('dari') }}">
                    </div>
                    <div class="form-group">
                        <label for="">Sampai</label>
                        <input type="date" name="sampai" id="sampai" class="form-control" value="{{ request()->input('sampai') }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>

        @if (request()->input('dari'))
            <div class="row d-flex justify-content-end">
                <div class="col-md-2 mb-3">
                    <button id="print" class="btn btn-primary btn-block">Cetak Pesanan</button>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-stripped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Harga</th>
                            <th>Jumlah Dibeli</th>
                            <th>Total Qty</th>
                            <th>Pendapatan</th>

                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        @endif
        
    </div>
</div>
@endsection

@push('js')
<script>
    $(function(){
        const dari = '{{ request()->input('dari') }}';
        const sampai = '{{ request()->input('sampai') }}';
    
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
                let row = '';
                if (data.length === 0) {
                    row = `
                    <tr>
                        <td colspan="6" class="text-center">Tidak ada data pesanan pada ${dari} - ${sampai}</td>
                    </tr>
                    `;
                } else {
                    data.map(function(val, index){
                        row += `
                        <tr>
                            <td>${index+1}</td>
                            <td>${val.nama_barang}</td>
                            <td>${rupiah(val.harga)}</td>
                            <td>${val.jumlah_dibeli}</td>
                            <td>${val.total_qty}</td>
                            <td>${rupiah(val.pendapatan)}</td>
                        </tr>
                        `;
                    });
                }
                $('tbody').append(row);
            }
        });

        function generatePDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Extract table data and format it
            const table = document.querySelector('.table');
            const rows = table.querySelectorAll('tr');
            let body = [];
            rows.forEach((row, rowIndex) => {
                let cols = row.querySelectorAll('td, th');
                let dataRow = [];
                cols.forEach(col => {
                    dataRow.push(col.innerText);
                });
                body.push(dataRow);
            });

            // Use autoTable to generate the table in the PDF
            doc.autoTable({
                head: [body[0]], // First row as header
                body: body.slice(1) // Rest of the rows as body
            });

            const fileName = `laporan-pesanan (${dari})-(${sampai}).pdf`;

            doc.save(fileName);
        }

        $('#print').click(function() {
            generatePDF();
        });
    });
</script>
@endpush

