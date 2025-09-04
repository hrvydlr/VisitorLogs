@extends('layout')

@section('button')
    <div class="d-flex justify-content-end mt-5 pt-5 w-100" id="visitor_type_index">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addVT"><i class="bi bi-plus-circle"></i> Add Visitor Type</button>
    </div>
@endsection

@section('content')
<div class="container" id="visitor_type_index">
    <h2 class="visitortype" >Visitor Types</h2>
    <!-- Existing Visitor Types Table -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
             <table class="table table-bordered" id="visitorTypeTable"></table>

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="usertype-heading">
                <i class="bi bi-people-fill title-icon"></i> Visitor Types
            </h2>
            <p class="page-subtitle">Manage and organize different visitor categories</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-value">12</div>
                <div class="stat-label">Total Types</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">10</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>

    <div class="table-card" style="height: 80vh; overflow-y: auto;">
        <div class="card-header">
            <div class="header-left">
                <h5 class="card-title">All Visitor Types</h5>
                <p class="entries-info" id="entries-info"></p>
            </div>
            <div class="header-right">
                <button type="button" class="btn btn-primary btn-md rounded-pill btn-addUT ms-2" id="btn-addVT">
                    <i class="bi bi-plus-circle"></i> Add Visitor Type
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table modern-table" id="visitorTypeTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created By</th>
                        <th>Updated By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by VisitorType.js -->
                </tbody>
            </table>
        </div>
    </div>
</div>

@include('components.modal', [
    'modal_id'      => 'visitortypemodal',
    'modal_size'    => '',
    'form_title'    => 'Register Visitor Type',
    'form_content'  => view('visitor_type.form')->render()
])
@endsection

@push('scripts')
<script>
let default_fields = {!! json_encode(config('constants.crud.visitor_type')) !!};
</script>
@vite(['resources/js/VisitorType.js'])
@endpush
