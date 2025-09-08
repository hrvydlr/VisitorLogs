@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">Reports</h2>
            <p class="page-subtitle mb-3">Monitor and track every logged visitor</p>
           <button type="button" class="btn btn-primary rounded-3 btn-addUT mb-1 justify-content-end" id="filterButton" data-bs-toggle="modal" data-bs-target="#filterModal">
                <i class="fas fa-filter"></i> Filter Report
            </button>
    
        </div>
    </div>

    <div class="table-card py-4">
        <div class="table-container table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table modern-table border border-dark-subtle" id="reportsTable">
            </table>
        </div>
    </div>
</div>
<div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filterModalLabel">Filter Reports</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body fs-5">
                <form id="filterForm" class="w-100">
                    <div class="mb-3 w-100">
                        <label for="visitorTypeFilter" class="form-label">Visitor Type</label>
                        <select class="form-select form-select-lg w-100 mt-1 mb-1" id="visitorTypeFilter" name="visitor_type">
                            <option value="">All Visitor Types</option>
                            <option value=3>OJT</option>
                            <option value=2>Trainee</option>
                            <option value=1>Applicant</option>
                        </select>
                    </div>
                    <div class="mb-3 w-100">
                        <label for="visitDateFilter" class="form-label">Visit Date</label>
                        <input type="date" class="form-control form-control-lg w-100 mt-1 mb-1" id="visitDateFilter" name="visit_date">
                    </div>
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary px-4 border-0" id="applyFilterBtn">Apply Filter</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.reports')) !!};

</script>
@vite(['resources/js/Reports.js'])
@vite('resources/sass/app.scss')
@endpush