@extends('layouts.layout-master')

@section('web-title')
    Pengaturan
@endsection

@section('web-content')
<div class="container-fluid">
    <h1 class="mt-4">Pengaturan Password Aplikasi</h1>
    {{-- <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Pengaturan</li>
    </ol> --}}
    <div class="card my-4">
        <div class="card-body">
            Password ini digunakan untuk konfirmasi kepemilikan akses saat mengatur nomor meja pada aplikasi android Squee Steak.
        </div>
    </div>
</div>

{{-- alert --}}
<div class="container-fluid mb-4">
    @include('layouts.display-items.alert')
</div>
<div class="container my-4">
    <form method="POST" action="{{ route('admin.setting.submit') }}">
        @csrf
        <div class="form-group my-4">
            <label>Password lama</label>
            <div class="d-flex justify-content-between">
                <input type="password" name="oldpass" class="form-control my-2 inputpw" value="{{ old('oldpass') }}"
                    placeholder="Masukkan password lama">
                <button type="button" class="btn btn-sm btn-light ml-3 py-0 btn-toggle-pw" mode='hidden'>
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>

        </div>
        <div class="my-4 text-danger text-left">
            @error('oldpass')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Password baru</label>
            <div class="d-flex justify-content-between">
                <input type="password" name="newpass" class="form-control my-2 inputpw" value="{{ old('newpass') }}"
                    placeholder="Masukkan password baru">
                <button type="button" class="btn btn-sm btn-light ml-3 py-0 btn-toggle-pw" mode='hidden'>
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
        </div>
        <div class="my-4 text-danger text-left">
            @error('newpass')
                {{ $message }}
            @enderror
        </div>
        <div class="form-group my-4">
            <label>Konfirmasi password baru</label>
            <div class="d-flex justify-content-between">
                <input type="password" name="newpassconfirm" class="form-control my-2 inputpw" value="{{ old('newpassconfirm') }}"
                placeholder="Konfirmasi password baru">
                <button type="button" class="btn btn-sm btn-light ml-3 py-0 btn-toggle-pw" mode='hidden'>
                    <i class="fas fa-eye-slash"></i>
                </button>
            </div>
        </div>
        <div class="my-4 text-danger text-left">
            @error('newpassconfirm')
                {{ $message }}
            @enderror
        </div>
        <button type="submit" class="btn btn-dark mb-4 float-right">
            Simpan
        </button>
    </form>
</div>

@endsection

@push('js')
    <script>
        function toggleVisibilityInputPassword(btnToggle){
            let mode = $(btnToggle).attr('mode');
            let attrType = 'text';
            if (mode == 'hidden') {
                mode ='visible';

                $(btnToggle).html('<i class="fas fa-eye"></i>');
            }
            else if (mode == 'visible') {
                mode = 'hidden';
                attrType ='password';

                $(btnToggle).html('<i class="fas fa-eye-slash"></i>');
            }

            let inputpw = $(btnToggle).siblings('.inputpw')[0];
            $(inputpw).attr('type', attrType);
            $(btnToggle).attr('mode', mode);
        }

        $(document).on('click', '.btn-toggle-pw', function(){
            toggleVisibilityInputPassword(this);
        });
    </script>
@endpush
