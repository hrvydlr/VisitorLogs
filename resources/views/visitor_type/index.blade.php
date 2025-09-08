@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">
                <i class="title-icon m-0"></i>Visitor Types
            </h2>
            <p class="page-subtitle mb-3">Manage and organize different visitor categories</p>
            <button type="button" 
                        class="btn btn-primary btn-md rounded-3 btn-addUT" 
                        id="btn-addVT">
                    <i class="bi bi-plus-circle"></i> Add Visitor Type
                </button>
        </div>
        </div>

    <div class="table-card table-card-fixed-height py-4">
        <div class="table-container">
            <table class="table modern-table border border-dark-subtle" id="visitorTypeTable">
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
