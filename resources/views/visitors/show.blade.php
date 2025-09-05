@extends('layout')


@section('content')
<div class="main-content">
    <div id="show-container" class="d-flex flex-column align-items-center mb-3">
        <div class="d-flex w-100 justify-content-start align-items-center mb-4">
            <a href="javascript:history.back()" class="btn btn-link text-dark me-2">
                <i class="bi bi-arrow-left fs-4"></i>
            </a>
            <h2 class="mb-1">Visitor Details</h2>
        </div>
        <div class="card p-5 shadow-sm w-100 mt-4">
            <div class="row g-5">
                <div class="col-lg-3 d-flex flex-column align-items-center text-center">
                    <div class="image-container border p-2 rounded mb-4">
                        @if($visitor->image_path)
                            <img src="{{ asset($visitor->image_path) }}" alt="Visitor Image" class="img-fluid rounded-top h-100 w-100 object-fit-cover">
                        @else
                            <div class="text-muted d-flex align-items-center justify-content-center h-100">No Image</div>
                        @endif
                    </div>
                    <h4 class="mb-0 fw-bold">{{ $visitor->first_name }} {{ $visitor->middle_name }} {{ $visitor->last_name }}</h4>
                    <p class="text-muted mb-0">{{ $visitor->number }}</p>
                </div>
                <div class="col-lg-9">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <h5 class="d-flex align-items-center mb-3 fw-bold">
                                <i class="bi bi-person me-2"></i> Personal Information
                            </h5>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Visitor Type:</label>
                                <input type="text" class="form-control" value="{{ $visitor->visitorType ? $visitor->visitorType->type_name : 'N/A' }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">ID Number:</label>
                                <input type="text" class="form-control" value="{{ $visitor->id_number ?? 'N/A' }}" readonly>
                            </div>
                            <div>
                                <label class="form-label text-muted fw-bold">Address:</label>
                                <input type="text" class="form-control" value="{{ $visitor->address }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5 class="d-flex align-items-center mb-3 fw-bold">
                                <i class="bi bi-calendar-event me-2"></i> Visit Information
                            </h5>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Visit Date:</label>
                                <input type="text" class="form-control" value="{{ $visitor->visit_date }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted fw-bold">Time In:</label>
                                <input type="text" class="form-control" value="{{ $visitor->time_in }}" readonly>
                            </div>
                            <div>
                                <label class="form-label text-muted fw-bold">Time Out:</label>
                                <input type="text" class="form-control" value="{{ $visitor->time_out ?? 'Not Timed Out' }}" readonly>
                            </div>
                        </div>
                        <hr class="mt-4">
                        <div class="col-12">
                            <h5 class="d-flex align-items-center mb-3 fw-bold">
                                <i class="bi bi-gear me-2"></i> System Information
                            </h5>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold">Created By:</label>
                                    <input type="text" class="form-control" value="{{ $visitor->creator ? $visitor->creator->username : 'N/A' }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted fw-bold">Last Updated By:</label>
                                    <input type="text" class="form-control" value="{{ $visitor->updater ? $visitor->updater->username : 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection