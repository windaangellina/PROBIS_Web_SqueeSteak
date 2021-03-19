@extends('layouts.layout-master')

@section('web-title')
    Cust. Order {{ ' - ' . $status  }}
@endsection


@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">{{ $title == '' ? 'Daftar Pesanan Pelanggan' : $title }}</h1>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li> --}}
        <li class="breadcrumb-item active">Pesanan Pelanggan</li>
    </ol>
    <div class="card my-4">
        <div class="card-body">
            {{ $deskripsi == '' ? 'Daftar Pesanan Pelanggan' : $deskripsi }}
        </div>
    </div>
    <div class="container my-2">
        @include('layouts.display-items.alert')
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table mr-1"></i>
            Daftar Pesanan
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th class="text-center align-middle">Nomor Meja</th>
                            <th class="text-center align-middle">Kode Order</th>
                            <th class="text-center align-middle">Total</th>
                            <th class="text-center align-middle">Transaksi dibuat pada</th>
                            @if ($status == 'done')
                                <th class="text-center align-middle">Aksi</th>
                            @elseif ($status == 'closed')
                                <th class="text-center align-middle">Dilunasi Pada</th>
                                <th class="text-center align-middle">Kasir Bertugas</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @isset($datapesananpelanggan)
                            @if (count($datapesananpelanggan) >= 0)
                                @foreach ($datapesananpelanggan as $pesanan)
                                    <tr>
                                        <td>{{ $pesanan->nomor_meja }}</td>
                                        <td>{{ $pesanan->kode_order }}</td>
                                        <td class="text-right">{{ $pesanan->total == null ? 0 : $pesanan->total }}</td>
                                        <td>{{ $pesanan->created_at }}</td>
                                        @if ($status == 'done')
                                            <td class="text-center align-middle">
                                                <form method="POST">
                                                    @csrf
                                                    <button type="button" class="btn btn-success mx-1 my-1 btnDelete"
                                                        formaction="{{ url(url()->current() . "/" . $pesanan->id . "/delete") }}">
                                                        <i class="fas fa-check"></i></i>
                                                    </button>
                                                </form>
                                            </td>
                                        @elseif ($status == 'closed')
                                            <td>{{ $pesanan->updated_at }}</td>
                                            <td>{{ $pesanan->kasir->nama }}</td>
                                        @endif
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
@endsection
