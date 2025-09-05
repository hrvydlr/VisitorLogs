{{-- index.blade.php --}}
@extends('layout')

@section('content')
<div class="container" id="report_container">

    <h2 class="reports fw-bold">Reports</h2>
    <!-- Existing Users Table -->
    <div class="card">
        <div class="card-body">
           
            <h5 class="card-title">Reports</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg">
                <table class="table table-bordered" id="reportsTable"></table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.reports')) !!}
</script>
@vite(['resources/js/Reports.js'])
@endpush