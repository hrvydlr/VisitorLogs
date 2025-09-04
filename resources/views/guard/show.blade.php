@extends('layout')


@section('content')
<div class="container">
    <h2 style="position: relative; top: 100px; left: 100px"> Visitor Details</h2>
    <div class="card" style="width: 75%; position: relative; top: 120px; font-size: 18px; padding: 20px; left: 150px;">
        <div class="card-body">
        
            <p><strong>Full Name:</strong> {{ $visitor->first_name }} {{ $visitor->middle_name }} {{ $visitor->last_name }}</p>
            <p><strong>Visitor Type:</strong> {{ $visitor->visitorType ? $visitor->visitorType->type_name : 'N/A' }}</p>
            <p><strong>Contact Number:</strong> {{ $visitor->number }}</p>
            <p><strong>Address:</strong> {{ $visitor->address }}</p>
            <p><strong>ID Number:</strong> {{ $visitor->id_number ?? 'N/A' }}</p>
            <p><strong>Visit Date:</strong> {{ $visitor->visit_date }}</p>
            <p><strong>Time In:</strong> {{ $visitor->time_in }}</p>
            <p><strong>Time Out:</strong> {{ $visitor->time_out ?? 'Not Timed Out' }}</p>
            <div class="d-flex align-items-start">
                <div class="me-4" style="flex: 1;">
                    <p><strong>Image:</strong> {{ $visitor->image_path }}</p>
                    <p><strong>Created By:</strong> {{ $visitor->creator ? $visitor->creator->username : 'N/A' }}</p>
                    <p><strong>Last Updated By:</strong> {{ $visitor->updater ? $visitor->updater->username : 'N/A' }}</p>
                </div>

                <div style="flex-shrink: 0;">
                    @if($visitor->image_path)
                        <img src="{{ asset($visitor->image_path) }}" alt="Visitor Image" class="img-fluid rounded" style="width: 400px; height: auto; object-fit: cover;">
                    @else
                        <p>No Image Available</p>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <a href="{{ route('guard.index') }}" class="btn btn-primary btn-md rounded-pill" style="position: relative; right: 25px">Back to Visitors</a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
@vite(['resources/js/Visitors.js'])
@endpush
