@extends('layouts.layout-master')

@section('web-title')
    List Menu
@endsection


@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Daftar Menu</h1>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li> --}}
        <li class="breadcrumb-item active">Menu</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            Squee Steak menyediakan berbagai macam menu steaks, hidangan pendamping dan minuman.
        </div>
        <div class="test" style="max-width: 200px; max-height: 200px"></div>
    </div>
    <div class="mb-4">
        @include('layouts.display-items.alert')
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Menu
        </div>
        <div class="card-body">
            <div class="mt-3 mb-4">
                Toggle kolom :
                <a class="toggle-vis" data-column="0">Kategori</a> -
                <a class="toggle-vis" data-column="1">Foto</a> -
                <a class="toggle-vis" data-column="3">Harga</a> -
                <a class="toggle-vis" data-column="4">Ditampilkan</a> -
                <a class="toggle-vis" data-column="5">Ditambahkan pada</a> -
                <a class="toggle-vis" data-column="6">Terakhir diubah pada</a></a>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Kategori</th>
                            <th class="text-center align-middle">Foto</th>
                            <th class="text-center align-middle">Nama</th>
                            <th class="text-center align-middle">Harga</th>
                            <th class="text-center align-middle">Ditampilkan</th>
                            <th class="text-center align-middle">Ditambahkan pada</th>
                            <th class="text-center align-middle">Terakhir diubah pada</th>
                            <th class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Modal --}}
@include('layouts.display-items.modal-confirmation')

@endsection


@push('js')
    {{-- node js / laravel mix. keterangan baca di CATATAN.txt --}}
    <script src="{{ mix('js/menu/ajax-list.js') }}"></script>
    <script src="{{ mix('js/konfirmasi.js') }}"></script>
@endpush
