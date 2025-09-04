@extends('layout')


@section('content')
<div class="container" id="report_show">
    <h2> Visitor Details</h2>
    <div class="card">
        <div class="card-body">
            <p><strong>Full Name:</strong> {{ $visitor->first_name }} {{ $visitor->middle_name }} {{ $visitor->last_name }}</p>
            <p><strong>Visitor Type:</strong> {{ $visitor->visitorType ? $visitor->visitorType->type_name : 'N/A' }}</p>
            <p><strong>Contact Number:</strong> {{ $visitor->number }}</p>
            <p><strong>Address:</strong> {{ $visitor->address }}</p>
            <p><strong>ID Number:</strong> {{ $visitor->id_number ?? 'N/A' }}</p>
            <p><strong>Visit Date:</strong> {{ $visitor->visit_date }}</p>
            <p><strong>Time In:</strong> {{ $visitor->time_in }}</p>
            <p><strong>Time Out:</strong> {{ $visitor->time_out ?? 'Not Timed Out' }}</p>
            
            <p><strong>Created By:</strong> {{ $visitor->creator ? $visitor->creator->username : 'N/A' }}</p>
            <p><strong>Last Updated By:</strong> {{ $visitor->updater ? $visitor->updater->username : 'N/A' }}</p>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('reports.index') }}" class=" back_report btn btn-primary btn-md rounded-pill">Back to Reports</a>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
@endpush