@extends('layout')
<head>
    <style>

    </style>
</head>
</body>


@section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100" id="user_index">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addUsers"><i class="bi bi-plus-circle"></i> Add User</button>
    </div>
@endsection


@section('content')
<div class="container" id="user_index">
    <h2 class="user" >User</h2>
    <!-- Existing Users Table -->
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">All Users</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
                <table class="table table-bordered" id="usersTable"></table>
            <table class="table table-bordered" id="usersTable"></table>
            </div>
        </div>
    </div>
</div>

@include('components.modal', [
    'modal_id'     => 'usermodal',
    'modal_size'   => '',
    'form_title'   => 'Add Users',
    'form_content' => view('users.form')->render()
])

@endsection
</body>

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.users')) !!} </script>
@vite(['resources/js/User.js'])
@endpush