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
                                                    <button type="button" class="btn btn-danger mx-1 my-1 btnDelete"
                                                        formaction="{{ url("/menu/" . $menu->id . "/delete") }}" mode="delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                @else
                                                    <button type="button" class="btn btn-success mx-1 my-1 btnRestore"
                                                    formaction="{{ url("/menu/" . $menu->id . "/restore") }}" mode="restorasi">
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
        function setModalMode(mode, action){
            if (mode == "restorasi") {
                $("#modalTitle").html('Restorasi Menu')

                $("#btnAction").html('Restorasi');
                $("#btnAction").addClass('btn-success');
            }
            else if(mode == "delete"){
                $("#modalTitle").html('Hapus Menu')

                $("#btnAction").html('Delete');
                $("#btnAction").addClass('btn-danger');
            }

            $("#modalBody").html('Yakin ingin '
                    + mode + ' menu?');
            $("#btnAction").attr('formaction', action);
            $("#modalConfirmation").modal('show');
        }

        $(document).on('click', ".btnDelete", function(){
            // console.log(this);
            let action = $(this).attr('formaction');
            let mode = $(this).attr("mode");
            setModalMode(mode, action);
        })

        $(document).on('click', ".btnRestore", function(){
            // console.log(this);
            let action = $(this).attr('formaction');
            let mode = $(this).attr("mode");
            setModalMode(mode, action);
        })
    </script>
@endsection
