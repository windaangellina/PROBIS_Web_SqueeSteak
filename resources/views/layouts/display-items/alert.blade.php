<div class="row">
    <div class="col-12">
        @if(session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between" role="alert">
                <span>{{ session()->get('success') }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show d-flex justify-content-between" role="alert">
                <span>{{ session()->get('error') }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    </div>
 </div>

