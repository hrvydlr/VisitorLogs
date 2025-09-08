<!DOCTYPE html>
<html lang="en">
@extends('layouts.visitorlog')
@include('layouts.head')
@section('content')
<body id="visitor-log">
    <div id="visitorLog-container">
        <div class="header"></div>
        <div class="content">
            <img src="{{ asset('/images/Magellan_pure_white_logo.png') }}" class="logo" alt="Magellan Solutions company logo in the visitor log form, centered above the form fields">
        </div>
        <div class="container-fluid form-container d-flex align-items-center justify-content-center mt-5" id="form-container">
            <div class="form-wrapper mt-5 p-5 w-75" id="form-wrapper">
                <div class="d-flex w-100 justify-content-start align-items-center mb-4">
                    <a href="{{ route('visitor.index') }}" class="btn btn-link text-dark me-2">
                        <i class="bi bi-arrow-left fs-4 p-0 icon-left"></i>
                    </a>
                    <h1 class="form-title text-left mt-4 mb-4">Welcome to Magellan Solutions!</h1>
                </div>
                <form id="visitorsForm" class="needs-validation" novalidate>
                    <div class="row g-4" id="row">
                        <div class="col-lg-8">
                            <div class="row g-4">
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" name="id_number" id="id_number"
                                            class="form-control form-control-lg" required minlength="3" maxlength="4" placeholder="ID Number">
                                        <label for="id_number">ID Number</label>
                                        <div class="invalid-feedback">
                                            Please provide a valid ID number (3-4 characters).
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <select name="visitor_type" id="visitor_type" class="form-select form-select-lg" required>
                                            <option value="" disabled selected>Select Visitor Type</option>
                                            @foreach($visitorTypes as $type)
                                                <option value="{{ $type->id }}" {{ old('visitor_type', $visitor->visitor_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <label for="visitor_type">Visitor Type</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" id="fname" name="first_name" class="form-control form-control-lg"
                                            required placeholder="First Name">
                                        <label for="fname">First Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" id="mname" name="middle_name" class="form-control form-control-lg"
                                            placeholder="Middle Name">
                                        <label for="mname">Middle Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" id="lname" name="last_name" class="form-control form-control-lg"
                                            required placeholder="Last Name">
                                        <label for="lname">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-floating">
                                        <input type="text" id="number" name="number" class="form-control form-control-lg"
                                            required pattern="[0-9+\-\s]+" placeholder="Contact Number">
                                        <label for="number">Contact Number</label>
                                    </div>
                                </div>
                                <div class="col-12s">
                                    <div class="form-floating">
                                        <textarea class="form-control form-control-lg" name="address" id="address"
                                            placeholder="Enter your address here..." required></textarea>
                                        <label for="address">Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4 mb-2">
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <button type="submit" class="btn btn-save btn-lg px-4 w-45">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-cancel btn-lg px-4 w-45" onclick="clearForm()">
                                        Clear
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Camera Section --}}
                        <div class="col-lg-4">
                            <div class="camera-section mb-3">
                                <div class="camera-label mb-3 text-center text-white">Capture Image</div>
                                <div id="my_camera" class=" camera-wrapper">
                                    <div class="text-muted text-center">
                                        <input type="hidden" name="image" id="captured_image" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center gap-2 flex-wrap mt-4">
                                <button type="button" class="btn btn-camera btn-capture" id="captureBtn">
                                    Capture
                                </button>
                                <button type="button" class="btn btn-camera btn-recapture" id="recaptureBtn">
                                    Recapture
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@vite(['resources/js/VisitorsForm.js'])
</html>