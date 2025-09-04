
@extends('layout')


@section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100 " id="user_type_index">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addUT"><i class="bi bi-plus-circle"></i> Add User Type</button>
    </div>
@endsection


@section('content')
<div class="container" id = "user_type_index">

<h2 class="usertype">User Types</h2>
    <!-- Existing Visitor Types Table -->
    <div class="card ">
        <div class="card-body">
            <h5 class="card-title">All User Types</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
            <table class="table table-bordered" id="userType"></table>
            </div>
        </div>
    </div>
</div>
@include('components.modal', [
    'modal_id'      => 'usertypemodal',
    'modal_size'    => '',
    'form_title'    => 'Register User Type',
    'form_content'  => view('user_type.form')->render()
])
@endsection


@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.user_type')) !!} </script>
@vite(['resources/js/UserType.js'])
@endpush    

