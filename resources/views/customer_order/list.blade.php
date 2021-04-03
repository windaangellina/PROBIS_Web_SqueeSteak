@extends('layouts.layout-master')

@section('web-title')
    Cust. Order {{ ' - ' . $status  }}
@endsection


@section('web-content')
<input type="hidden" id="statusPesanan" value="{{ $status }}"/>
<div class="container-fluid">
    <h1 class="mt-4">{{ $title == '' ? 'Daftar Pesanan Pelanggan' : $title }}</h1>
    <ol class="breadcrumb mb-4">
        {{-- <li class="breadcrumb-item"><a href="{{ route('menu.list') }}">Menu</a></li> --}}
        <li class="breadcrumb-item active">Daftar Pesanan</li>
    </ol>
    <div class="card my-4">
        <div class="card-body">
            {{ $deskripsi == '' ? 'Daftar Pesanan Pelanggan' : $deskripsi }}
        </div>
    </div>
    <div class="mb-4">
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
                            @if ($status == 'closed')
                                <th class="text-center align-middle">Dilunasi Pada</th>
                                <th class="text-center align-middle">Kasir Bertugas</th>
                            @endif
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
    <script id="scriptList" src="{{ mix('js/customer_order/ajax-list.js') }}"></script>
    <script src="{{ mix('js/konfirmasi.js') }}"></script>
@endpush
