
@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="usertype-heading">
                <i class="bi bi-person-badge-fill title-icon"></i> User Types
            </h2>
            <p class="page-subtitle">Manage and organize different user roles and permissions</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-value">7</div>
                <div class="stat-label">Total Types</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">6</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>

    <div class="table-card" style="height: 80vh; overflow-y: auto;">
        <div class="card-header">
    <div class="header-left">
        <h5 class="card-title">All User Types</h5>
        <!-- dati static text, gawin nating empty container -->
        <p class="entries-info" id="entries-info"></p>
    </div>
    <div class="header-right">
        <button type="button" class="btn btn-primary btn-md rounded-pill btn-addUT ms-2" id="btn-addUT">
            <i class="bi bi-plus-circle"></i> Add User Type
        </button>
    </div>
</div>

        <div class="table-container">
            <table class="table modern-table" id="userType">
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
                    <!-- Data will be populated by UserType.js -->
                </tbody>
            </table>
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
<script>
let default_fields = {!! json_encode(config('constants.crud.user_type')) !!};
</script>
@vite(['resources/js/UserType.js', 'resources/sass/app.scss'])
@endpush