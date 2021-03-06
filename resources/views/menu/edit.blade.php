@extends('layouts.layout-master')

@section('web-title')
    Edit Menu
@endsection

@section('web-style')
    <style>
        #fotoMenu{
            object-fit: cover; width: 300px; height: 300px;
        }
    </style>
@endsection

@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Edit Menu</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li>
        <li class="breadcrumb-item active">Edit Menu</li>
    </ol>
</div>
{{-- alert --}}
<div class="container-fluid mb-4">
    @include('layouts.display-items.alert')
</div>
<div class="container my-5">
    {{-- form --}}
    <form method="POST" enctype="multipart/form-data">
        @csrf
        {{-- <div class="row mt-4 d-flex flex-row-reverse">
            <button class="btn btn-primary btnReset">Reset</button>
        </div> --}}

        {{-- preview foto --}}
        <div class="row mt-4 d-flex justify-content-center">
            <div class="col-sm-12 col-lg-4 text-center">
                <img id="fotoMenu" class="img-responsive w-100 border border-dark" src="{{ asset('storage/res/' . $dataMenu->kategori->folder . '/' . $dataMenu->url_foto_menu) }}">
            </div>
        </div>

        {{-- isi form --}}
        <div class="form-group my-4">
            <label>Foto menu</label>
            <input id="inputFileFotoMenu" type="file" name="picture" class="form-control my-2">
        </div>
        <div class="my-4 text-danger text-left">
            <p id="errNoteFoto">
            </p>
            @error('picture')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control my-2" value="{{ $dataMenu->nama }}" placeholder="Steak ...">
        </div>
        <div class="my-4 text-danger text-left">
            @error('nama')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control my-2" value="{{ $dataMenu->harga }}" placeholder="88000">
        </div>
        <div class="my-4 text-danger text-left">
            @error('harga')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control my-2" rows="5"
                style="resize: none">{{ $dataMenu->deskripsi }}</textarea>
        </div>
        <button type="submit" class="btn btn-dark mb-4 float-right">
            Simpan
        </button>
    </form>
</div>
@endsection


@push('js')
<script>
    // preview image sebelum diupload
    function readURL(input) {
        if (input.files && input.files[0]) {
            var file = input.files[0];
            var fileType = file["type"];
            var validImageTypes = ["image/jpeg", "image/png", "image/jpg", "image/tiff", "image/bmp"];

            if ($.inArray(fileType, validImageTypes) < 0) {
                // invalid file type code goes here.
                $('#fotoMenu').attr('src', "{{ asset('assets/img/no-image.jpg') }}");
                $('#inputFileFotoMenu').val('');
                $('#errNoteFoto').html('Foto harus dalam format jpeg,jpg,png,bmp atau tiff');
            }
            else{
                $('#errNoteFoto').html('');

                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#fotoMenu').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    $("#inputFileFotoMenu").change(function(){
        readURL(this);
    });

</script>
@endpush
