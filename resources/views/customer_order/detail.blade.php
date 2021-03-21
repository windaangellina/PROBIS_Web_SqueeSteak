@extends('layouts.layout-master')

@section('web-title')
   Cust. Order Detail
@endsection

@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Detail Pesanan Pelanggan</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item">
            <a href="{{ route('custorder.list', ['status' => $status]) }}">Daftar Pesanan</a>
        </li>
        <li class="breadcrumb-item active">{{ $dataPesanan->kode_order == null ? '' : $dataPesanan->kode_order }}</li>
    </ol>
    <div>
        @include('layouts.display-items.alert')
    </div>
</div>
@if ($status == "done")
    <div class="container-fluid mb-4 text-right">
        <button type="button" class="btn btn-success btnConfirm" formaction="{{ route('custorder.confirmpayment',
            ['id' => $dataPesanan->id]) }}">
            <i class="fas fa-check"></i><span class="ml-2">Konfirmasi Pembayaran</span>
        </button>
    </div>
@endif
<div class="container-fluid">
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>Tanggal Transaksi</strong>
                        </div>
                        <div class="col">
                            {{ $dataPesanan->created_at->format('D, d M Y - H:i:s') }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Nomor Meja / Kode Order</strong>
                        </div>
                        <div class="col">
                            {{ $dataPesanan->nomor_meja . ' / ' . $dataPesanan->kode_order }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Total</strong>
                        </div>
                        <div class="col">
                            <strong>
                                Rp. {{ number_format($dataPesanan->total == null ? 0 :
                                    $dataPesanan->total,0,",",".")  }}
                            </strong>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-6">
                    <div class="row">
                        <div class="col-4">
                            <strong>Kasir</strong>
                        </div>
                        <div class="col">
                            {{ $dataPesanan->kasir == null ? '-' : $dataPesanan->kasir->nama }}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <strong>Status</strong>
                        </div>
                        <div class="col">
                            @if ($dataPesanan->status_order == 0)
                                Pending
                            @elseif($dataPesanan->status_order == 1)
                                Sedang Berlangsung
                            @elseif($dataPesanan->status_order == 2)
                                Sudah Selesai
                            @elseif($dataPesanan->status_order == 3)
                                Sudah Dibayar
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                            <th class="text-center align-middle">Menu</th>
                            <th class="text-center align-middle">Harga</th>
                            <th class="text-center align-middle">Jumlah</th>
                            <th class="text-center align-middle">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @isset($dataPesanan)
                            @foreach ($dataPesanan->details as $pesanan)
                                {{-- tampilkan pesanan yang sudah dicheck out aja --}}
                                @if ($pesanan->status_diproses != 0)
                                    <tr>
                                        <td>
                                            {{ $pesanan->menu->nama }}
                                            @if ($pesanan->keterangan != null)
                                                <p class="ml-2 font-italic text-muted">
                                                    Catatan : {{ $pesanan->keterangan }}
                                                </p>
                                            @endif
                                        </td>
                                        <td class="text-right">{{ number_format($pesanan->harga == null ? 0 : $pesanan->harga,0,",",".")  }}</td>
                                        <td>{{ $pesanan->jumlah }}</td>
                                        <td class="text-right">{{ number_format($pesanan->subtotal == null ? 0 : $pesanan->subtotal,0,",",".")  }}</td>
                                    </tr>
                                @endif
                            @endforeach
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
