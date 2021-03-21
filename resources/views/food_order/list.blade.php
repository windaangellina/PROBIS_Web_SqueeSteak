@extends('layouts.layout-master')

@section('web-title')
    List Pesanan Makanan
@endsection


@section('web-content')
<div class="container-fluid mb-4">
    <h1 class="mt-4">{{ $title }}</h1>
</div>
<div class="container-fluid mb-4">
    @include('layouts.display-items.alert')
</div>
<div class="container-fluid mb-4">
    @isset($dataPesanan)
        @if (count($dataPesanan) == 0)
            <h5 class="my-4">Semua Pesanan Menu Sudah Selesai Disiapkan</h5>
        @else
            <div class="row">
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
                                            @isset($dataMenuPesanan)
                                                @if (count($dataMenuPesanan) >= 0)
                                                    @foreach ($dataMenuPesanan as $menuPesanan)
                                                        @if ($menuPesanan->jumlah > 0)
                                                            <tr>
                                                                <td>{{ $menuPesanan->nama }}</td>
                                                                <td>{{ $menuPesanan->jumlah }}</td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            @endisset
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
                                <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3">
                            @else
                                <div class="row row-cols-1 row-cols-md-3 row-cols-xl-4">
                            @endif
                                @foreach ($dataPesanan as $pesanan)
                                    <div class="col mb-4">
                                        <div class="card" style="min-height: 15rem;">
                                            <div class="card-header">
                                                <p class="card-title">
                                                    <strong>
                                                        Meja {{ $pesanan->nomor_meja . ' / ' . $pesanan->kode_order }}
                                                    </strong>
                                                </p>
                                            </div>
                                            <div>
                                                <ul class="list-group list-group-flush">
                                                    @foreach ($pesanan->details as $detail)
                                                        @php
                                                            $displayValid = true;
                                                        @endphp
                                                        @if ($status == 'ongoing')
                                                            @if ($detail->status_diproses != 1)
                                                                @php
                                                                    $displayValid = false;
                                                                @endphp
                                                            @endif
                                                        @elseif ($status == 'all')
                                                            @if ($detail->status_diproses == 0)
                                                                @php
                                                                    $displayValid = false;
                                                                @endphp
                                                            @endif
                                                        @endif
                                                        @if ($displayValid)
                                                            <li class="list-group-item">
                                                                <div class="row">
                                                                    <div class="col-sm-5 col-md-6 col-xl-7">
                                                                        {{ $detail->menu->nama }}
                                                                    </div>
                                                                    <div class="col text-left">
                                                                        x {{ $detail->jumlah }}
                                                                    </div>
                                                                    @if ($detail->status_diproses == 1)
                                                                        <div class="col text-right">
                                                                            @if ($status == 'ongoing')
                                                                                <form method="POST">
                                                                                    @csrf
                                                                                    <button type="submit" class="btn btn-success" formaction="{{ route('foodorder.foodPrepared', ['id' => $detail->id]) }}">
                                                                                        <i class="fas fa-check"></i>
                                                                                    </button>
                                                                                </form>
                                                                            @elseif ($status == 'all')
                                                                                <button class="btn btn-secondary" disabled>
                                                                                    <i class="fas fa-spinner"></i>
                                                                                </button>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </li>
                                                        @endif
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @if ($status == 'ongoing')
                                                <hr>
                                                <div class="text-center mb-3">
                                                    <form method="POST">
                                                        @csrf
                                                        <button type="submit" formaction="{{ route('foodorder.foodPreparedAll', ['id' => $pesanan->id]) }}" class="btn btn-primary w-75">Sudah Selesai Semua</button>
                                                    </form>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        @endif
    @endisset
</div>
@endsection
