@extends('layout.app')

@section('title', 'About')

@section('content')
<div class="card shadow">
    <div class="card-header">
        <div class="card-title">Data About</div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-12">
                <form class="form-about" method="POST" enctype="multipart/form-data" action="/tentang/{{ $about->id }}">
                    @csrf
                    <div class="form-group">
                        <label for="judul_website">Judul Website</label>
                        <input type="text" class="form-control" name="judul_website" placeholder="Judul Website" required value="{{ $about->judul_website }}">
                    </div>
                    <img src="/uploads/{{ $about->logo }}" alt="{{ $about->logo }}" width="200">
                    <div class="form-group">
                        <label for="">Logo</label>
                        <input type="file" class="form-control" name="logo">
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <textarea id="" class="form-control" cols="30" rows="10" name="deskripsi" placeholder="Deskripsi" required>{{ $about->deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea id="" class="form-control" cols="30" rows="10" name="alamat" placeholder="Alamat" required>{{ $about->alamat }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" name="email" placeholder="Email" required value="{{ $about->email }}">
                    </div>
                    <div class="form-group">
                        <label for="telepon">Telepon</label>
                        <input type="text" class="form-control" name="telepon" placeholder="Telepon" required value="{{ $about->telepon }}">
                    </div>
                    <div class="form-group">
                        <label for="atas_nama">Atas Nama</label>
                        <input type="text" class="form-control" name="atas_nama" placeholder="Atas Nama" required value="{{ $about->atas_nama }}">
                    </div>
                    <div class="form-group">
                        <label for="no_rekening">No. Rekening</label>
                        <input type="text" class="form-control" name="no_rekening" placeholder="No. Rekening" required value="{{ $about->no_rekening }}">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection