@extends('layouts.layout-master')

@section('web-title')
    List Pesanan Makanan
@endsection

@section('web-content')
<input type="hidden" id="statusPesanan" value="{{ $status }}"/>
<div class="container-fluid mb-4">
    <h1 class="mt-4">{{ $title }}</h1>
</div>
<div class="container-fluid">
    @include('layouts.display-items.alert')
</div>
<div class="container-fluid mb-4">
    {{-- <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-body">
                    Semua Pesanan Menu Sudah Selesai Disiapkan
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12 text-center">
            <img src="{{ asset('assets/img/misc/chef-thumbs-up.png') }}" class="img-fluid w-25" alt="">
        </div>
    </div> --}}

    <div class="row" id="rowPageContent">
        {{-- table summary jumlah menu yang perlu disiapkan. tampilkan kalo menu ongoing --}}
        @if ($status == 'ongoing')
            <div class="col-12 col-xl-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <i class="fas fa-list-ul mr-1"></i>
                        Ringkasan Yang Perlu Disiapkan
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th class="text-center align-middle">Nama Menu</th>
                                        <th class="text-center align-middle">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        {{-- card per order --}}
        <div class="col-12 col-xl">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table mr-1"></i>
                    Detail Pesanan Per Order
                </div>
                <div class="card-body">
                    @if ($status == 'ongoing')
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3" id="containerCardPesanan">
                    @else
                    <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4" id="containerCardPesanan">
                    @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
    <script>
        var urlGambarChef = "{{ asset('assets/img/misc/chef-thumbs-up.png') }}";
    </script>
    <script src="{{ mix('js/food_order/ajax-list.js') }}"></script>
@endpush

