@extends('layout')
<body>


@section('content')
<div class="container">
    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    @section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100" id="registered_id_index">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addID"><i class="bi bi-plus-circle"></i>  Register ID</button>
    </div>
@endsection
<div class="container" id="registered_id_index">
<h2 class="registerid">Registered IDs</h2>
    <!-- Existing Registered IDs Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">All Registered IDs</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
                <table class="table table-bordered" id="registeredidTable"></table>
            </div>
        </div>
    </div>

</div>

@include('components.modal', [
    'modal_id'      => 'addIDModal',
    'modal_size'    => '',
    'form_title'    => 'Register ID',
    'form_content'  => view('registered_id.form')->render()
])

@endsection
</body>

@push('scripts')
<script> let default_fields = {!! json_encode(config('constants.crud.registered_id')) !!} 
    
</script>

@vite(['resources/js/RegisteredId.js'])
@endpush
