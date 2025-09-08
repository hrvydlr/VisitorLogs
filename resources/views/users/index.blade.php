@extends('layout')

@section('content')
<div class="user-types-container">
    <div class="page-header mt-4">
        <div class="header-content">
            <h2 class="page-title">
                <i class="title-icon m-0"></i>Users
            </h2>
            <p class="page-subtitle mb-3">Manage and organize user accounts and their </p>
           
                <button type="button" 
                        class="btn btn-primary btn-md rounded-3 btn-addUT mb-4 justify-content-end" 
                        id="btn-addUsers">
                    <i class="bi bi-plus-circle"></i> Add User
                </button>
        </div>
    </div>

    <div class="table-card table-card-fixed-height py-4">
        <div class="table-container table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table modern-table border border-dark-subtle" id="usersTable">
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
@vite(['resources/js/User.js'])
@vite('resources/sass/app.scss')
@endpush
