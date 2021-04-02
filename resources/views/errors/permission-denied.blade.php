@extends('layouts.layout-master')

@section('web-title')
    Permission Denied
@endsection

@section('web-content')
    {{-- <div class="container-fluid mb-4">
        <h3 class="mt-4">Anda tidak memiliki akses untuk membuka laman ini.</h3>
    </div> --}}
    <div class="container-fluid my-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        Anda tidak memiliki akses untuk membuka laman ini.
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <img src="{{ asset('assets/img/misc/you-shall-not-pass.jpg') }}" class="img-fluid w-50" alt="">
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        $(document).ready(function(){
            console.log('replace');
            window.history.pushState('', '', '{{ url()->previous() }}');
        });
    </script>
@endpush
