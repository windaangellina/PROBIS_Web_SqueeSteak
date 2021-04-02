@extends('layouts.layout-master')

@section('web-title')
    Tambah Menu Baru
@endsection


@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Tambah Menu Baru</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li>
        <li class="breadcrumb-item active">Tambah Menu</li>
    </ol>
</div>
{{-- alert --}}
<div class="container-fluid mb-4">
    @include('layouts.display-items.alert')
</div>
<div class="container my-4">
    {{-- form --}}
    <form method="POST" enctype="multipart/form-data">
        @csrf
        {{-- preview foto --}}
        <div class="row mt-4">
            <div class="col-12 text-center" style="width: 17em; height: 17em;">
                {{-- <img id="fotoMenu" class="img-responsive w-25 border border-dark" src="{{ asset('assets/img/no-image.jpg') }}" style="min-width: 200px; max-width: 300px; min-height: 200px; max-height: 300px;"> --}}
                <img id="fotoMenu" class="img-responsive w-25 border border-dark" src="{{ asset('assets/img/no-image.jpg') }}" style="object-fit: cover; width: 300px; height: 300px;">
            </div>
        </div>

        {{-- isi form --}}
        <div class="form-group my-4">
            <label>Foto menu</label>
            <input id="inputFileFotoMenu" type="file" name="picture" required class="form-control my-2">
        </div>
        <div class="my-4 text-danger text-left">
            @error('picture')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control my-2" value="{{ old('nama') }}" placeholder="Steak ...">
        </div>
        <div class="my-4 text-danger text-left">
            @error('nama')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Kategori</label>
            <select name="kategori" required class="form-control">
                @if (isset($dataKategori) && count($dataKategori) > 0)
                    @foreach ($dataKategori as $category)
                        <option value="{{ $category->id }}">
                            {{ $category->nama }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="form-group my-4">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control my-2" value="{{ old('harga') }}" placeholder="88000">
        </div>
        <div class="my-4 text-danger text-left">
            @error('harga')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control my-2" rows="5"
                style="resize: none">{{ old('deskripsi') }}</textarea>
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
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#fotoMenu').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $("#inputFileFotoMenu").change(function(){
        readURL(this);
    });
</script>
@endpush
