@extends('layouts.layout-master')

@section('web-title')
    List Pesanan Makanan
@endsection


@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Daftar Pesanan Makanan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li>
        <li class="breadcrumb-item active">List</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            Squee Steak menyediakan berbagai macam menu steaks, hidangan pendamping dan minuman.
        </div>
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
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Ditampilkan</th>
                            <th>Ditambahkan pada</th>
                            <th>Terakhir diubah pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($datamenu) >= 0)
                            @foreach ($datamenu as $menu)
                                <tr>
                                    <td>{{ $menu->kategori->nama }}</td>
                                    <td>{{ $menu->nama }}</td>
                                    <td>{{ $menu->harga }}</td>
                                    <td>
                                        @if ($menu->deleted_at != null)
                                            <span class="text-danger">Tidak</span>
                                        @else
                                            <span class="text-success">Iya</span>
                                        @endif
                                    </td>
                                    <td>{{ $menu->created_at->diffForHumans() }}</td>
                                    <td>
                                        @if ($menu->deleted_at != null)
                                            {{ $menu->deleted_at->diffForHumans() }}
                                        @else
                                            {{ $menu->updated_at->diffForHumans() }}
                                        @endif
                                    </td>
                                    <td class="text-center align-middle">
                                        <a class="btn btn-warning mx-1 my-1"
                                            href="{{ url("/menu/" . $menu->id . "/edit") }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST">
                                            @csrf
                                            @if ($menu->deleted_at == null)
                                                <button type="button" class="btn btn-danger mx-1 my-1 btnDelete"
                                                    formaction="{{ url("/menu/" . $menu->id . "/delete") }}" mode="delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            @else
                                                <button type="button" class="btn btn-success mx-1 my-1 btnRestore"
                                                formaction="{{ url("/menu/" . $menu->id . "/restore") }}" mode="restore">
                                                    <i class="fas fa-trash-restore"></i>
                                                </button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
