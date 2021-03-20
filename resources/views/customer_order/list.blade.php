@extends('layouts.layout-master')

@section('web-title')
    Cust. Order {{ ' - ' . $status  }}
@endsection


@section('web-content')
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
                        @isset($datapesananpelanggan)
                            @if (count($datapesananpelanggan) >= 0)
                                @foreach ($datapesananpelanggan as $pesanan)
                                    <tr>
                                        <td>{{ $pesanan->nomor_meja }}</td>
                                        <td>{{ $pesanan->kode_order }}</td>
                                        <td class="text-right">{{ number_format($pesanan->total == null ? 0 : $pesanan->total,0,",",".")  }}</td>
                                        <td>{{ $pesanan->created_at }}</td>
                                        @if ($status == 'closed')
                                            <td>{{ $pesanan->updated_at }}</td>
                                            <td>{{ $pesanan->kasir->nama }}</td>
                                        @endif
                                        <td class="text-center align-middle">
                                            <a class="btn btn-secondary mx-1 my-1 btnDelete"
                                                href="{{ url("customer-order/" . $pesanan->id . "/detail") }}">
                                                <i class="fas fa-receipt"></i>
                                            </a>
                                            <form>
                                                @if ($status == 'done')
                                                    <button type="button" class="btn btn-success mx-1 my-1 btnConfirm"
                                                        formaction="{{ route('custorder.confirmpayment',
                                                        ['id' => $pesanan->id]) }}">
                                                        <i class="fas fa-check"></i>
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
<div class="modal fade" id="modalConfirmation" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    Modal title
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modalBody">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    Close
                </button>
                <form method="POST">
                    @csrf
                    <button type="submit" class="btn" id="btnAction" formaction="#">
                        Save changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
    <script>
        function setModalMode(action){
            $("#modalTitle").html('Konfirmasi Pembayaran')

            $("#btnAction").html('Konfirmasi');
            $("#btnAction").addClass('btn-success');

            $("#modalBody").html('Yakin ingin konfirmasi pembayaran?');
            $("#btnAction").attr('formaction', action);
            $("#modalConfirmation").modal('show');
        }

        $(document).on('click', ".btnConfirm", function(){
            // console.log(this);
            let action = $(this).attr('formaction');
            setModalMode(action);
        });
    </script>
@endsection
