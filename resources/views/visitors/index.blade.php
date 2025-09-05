@extends('layout')

@section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100" >
        <a href="{{ route('visitor.form') }}" class="btn btn-primary btn-md rounded-3 border-0 p-2" target="_blank"  id="btn-addUsers"><i class="bi bi-plus-circle"></i> Add Visitor</a>
    </div>
@endsection

@section('content')
<div class="container">
    <h2 class="log">Visitor Log Sheets</h2>
    <!-- Existing Users Table -->
    <div class="card">
        <div class="card-body py-4" >
            <div class="table-responsive-sm table-responsive-md table-responsive-lg visitor-table-responsive">
                <table class="table table-bordered visitor-data-table" id="visitorsTable"></table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.visitor')) !!} </script>
@vite(['resources/js/Visitors.js'])
@endpush