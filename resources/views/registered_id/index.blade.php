@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">
                <i class="title-icon m-0"></i>Registered IDs
            </h2>
            <p class="page-subtitle mb-3">Manage and monitor all registered ID entries</p>
               <button type="button" 
                        class="btn btn-primary btn-md rounded-3 btn-addUT" 
                        id="btn-addID">
                    <i class="bi bi-plus-circle"></i> Register ID
                </button>
        </div>
    </div>

    <!-- Error Alert -->
    @if (session('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif

    <!-- Table Card -->
    <div class="table-card table-card-fixed-height py-4">
        <div class="table-container">
            <table class="table modern-table" id="registeredidTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>ID Number</th>
                        <th>Owner</th>
                        <th>Created By</th>
                        <th>Created Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Data will be populated by RegisteredId.js -->
                </tbody>
            </table>
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

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.registered_id')) !!};
</script>
@vite(['resources/js/RegisteredId.js'])
@endpush
