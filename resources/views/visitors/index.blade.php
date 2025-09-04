
@extends('layout')
<head>
    <style>
     

    </style>
    </head>
<body>

@section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100" >
        <a href="{{ route('visitor.form') }}" class="btn btn-primary btn-md rounded-pill" target="_blank"  id="btn-addUsers"><i class="bi bi-plus-circle"></i> Add Visitor</a>
    </div>
@endsection


@section('content')
<div class="container">
    <h2 class="log">Visitor Log Sheets</h2>
    <!-- Existing Users Table -->
    <div class="card">
        <div class="card-body" >
            <h5 class="card-title">All Users</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
            <table class="table table-bordered" id="visitorsTable"></table>
        </div>
    </div>
</div>
@endsection
</body>

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.visitor')) !!} </script>
@vite(['resources/js/Visitors.js'])
@endpush
