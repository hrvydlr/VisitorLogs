@extends('layout')

@section('content')
<div class="container visitor-details-container">
    <h2 class="visitor-details-header">Visitor Details</h2>
    <div class="card visitor-details-card">
        <div class="card-body">
            <div class="col-md-4 visitor-image-container">
                @if($visitor->image_path)
                    <img src="{{ asset($visitor->image_path) }}" alt="Visitor Image" class="img-fluid visitor-image">
                @else
                    <p>No Image Available</p>
                @endif
            </div>
            <div class="visitor-info mt-4">
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
            </div>

            <div class="d-flex justify-content-end mt-4 visitor-details-action-buttons">
                <a href="{{ route('visitor.index') }}" class="btn btn-primary btn-md rounded-pill">Back to Visitors</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/Visitors.js'])
@endpush