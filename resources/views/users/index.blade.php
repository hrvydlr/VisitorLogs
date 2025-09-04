@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">
                <i class="bi bi-person-circle title-icon"></i> Users
            </h2>
            <p class="page-subtitle">Manage and organize user accounts and their details</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-value">50</div> {{-- Example value --}}
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">45</div> {{-- Example value --}}
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>

    <div class="table-card">
        <div class="card-header">
            <div class="header-left">
                <h5 class="card-title">All Users</h5>
            </div>
            <div class="header-right">
                <button type="button" class="btn-addUT" id="btn-addUsers">
                    <i class="bi bi-plus-circle"></i> Add User
                </button>
            </div>
        </div>

        <div class="table-container">
            <table class="table modern-table" id="usersTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data will be populated by User.js --}}
                </tbody>
            </table>
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

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.users')) !!};
</script>
@vite(['resources/js/User.js', 'resources/sass/app.scss'])
@endpush