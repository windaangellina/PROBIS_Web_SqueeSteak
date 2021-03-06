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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Kategori</th>
                            <th class="text-center align-middle">Nama</th>
                            <th class="text-center align-middle">Harga</th>
                            <th class="text-center align-middle">Ditampilkan</th>
                            <th class="text-center align-middle">Ditambahkan pada</th>
                            <th class="text-center align-middle">Terakhir diubah pada</th>
                            <th class="text-center align-middle">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($datamenu)
                            @if (count($datamenu) >= 0)
                                @foreach ($datamenu as $menu)
                                    <tr>
                                        <td>{{ $menu->kategori->nama }}</td>
                                        <td>{{ $menu->nama }}</td>
                                        <td class="text-right">{{ number_format($menu->harga,0,",",".")   }}</td>
                                        <td>
                                            @if ($menu->deleted_at != null)
                                                <span class="text-danger">Tidak</span>
                                            @else
                                                <span class="text-success">Iya</span>
                                            @endif
                                        </td>
                                        <td>{{ $menu->created_at }}</td>
                                        <td>
                                            @if ($menu->deleted_at != null)
                                                {{ $menu->deleted_at }}
                                            @else
                                                {{ $menu->updated_at }}
                                            @endif
                                        </td>
                                        <td class="text-center align-middle">
                                            <a class="btn btn-secondary mx-1 my-1"
                                                href="{{ url("/menu/" . $menu->id . "/edit") }}">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form method="POST">
                                                @csrf
                                                @if ($menu->deleted_at == null)
                                                    <button type="button" class="btn btn-danger mx-1 my-1 btnAksiModal"
                                                        formaction="{{ url("/menu/" . $menu->id . "/delete") }}" mode="Hapus" item="menu">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success mx-1 my-1 btnAksiModal"
                                                    formaction="{{ url("/menu/" . $menu->id . "/restore") }}" mode="Restorasi" item="menu">
                                                        <i class="fas fa-trash-restore"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        @endisset
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
    <script src="{{ mix('js/konfirmasi.js') }}"></script>
@endpush
