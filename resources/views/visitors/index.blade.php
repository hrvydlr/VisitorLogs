@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">Visitor Log Sheets</h2>
            <p class="page-subtitle mb-3">Manage and track all visitor entries</p>
            <a href="{{ route('visitor.form') }}" class="btn btn-primary rounded-3 btn-addUT mb-1 justify-content-end" id="btn-addUsers">
                <i class="bi bi-plus-circle"></i> Add Visitor
            </a>
        </div>
    </div>

    <div class="table-card py-4">
        <div class="table-container table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table modern-table border border-dark-subtle" id="visitorsTable">
            </table>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.visitor')) !!} </script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/js/Visitors.js'])
@vite('resources/sass/app.scss')
@endpush