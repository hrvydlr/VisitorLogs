@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <!-- Page Header -->
    <div class="page-header">
        <div class="header-content">
            <h2 class="usertype-heading">
                <i class="bi bi-credit-card-2-front-fill title-icon"></i> Registered IDs
            </h2>
            <p class="page-subtitle">Manage and monitor all registered ID entries</p>
        </div>
        <div class="header-stats">
            <div class="stat-card">
                <div class="stat-value">25</div>
                <div class="stat-label">Total IDs</div>
            </div>
            <div class="stat-card">
                <div class="stat-value">22</div>
                <div class="stat-label">Active</div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="table-card" style="height: 80vh; overflow-y: auto;">
        <div class="card-header">
            <div class="header-left">
                <h5 class="card-title">All Registered IDs</h5>
                <p class="entries-info" id="entries-info"></p>
            </div>
            <div class="header-right">
                <button type="button" class="btn btn-primary btn-md rounded-pill btn-addUT ms-2" id="btn-addID">
                    <i class="bi bi-plus-circle"></i> Register ID
                </button>
            </div>
        </div>

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
<<<<<<< Updated upstream
<script> let default_fields = {!! json_encode(config('constants.crud.registered_id')) !!} 
    
=======
<script>
let default_fields = {!! json_encode(config('constants.crud.registered_id')) !!};
console.log(default_fields); // Debugging
>>>>>>> Stashed changes
</script>
@vite(['resources/js/RegisteredId.js', 'resources/sass/app.scss'])
@endpush
