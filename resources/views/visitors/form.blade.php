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
        <div class="form-wrapper mt-5 p-5 w-75">
            <!-- Mobile Logo -->
            <h1 class="form-title text-left mb-4">Welcome to Magellan Solutions!</h1>
            
            <form id="visitorsForm" class="needs-validation" novalidate>
                <div class="row g-4">
                    <!-- Form Fields Section -->
                    <div class="col-lg-6">
                        <div class="row g-4">
                            <!-- ID Number and Visitor Type -->
                            <div class="col-sm-6">
                                <input type="text" name="id_number" id="id_number" placeholder="ID Number" 
                                       class="form-control form-control-lg p-3" required minlength="3" maxlength="4">
                                <div class="invalid-feedback">
                                    Please provide a valid ID number (3-4 characters).
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <select name="visitor_type" id="visitor_type" class="form-select form-select-lg p-3" required>
                                    <option value="" disabled selected>Select Visitor Type</option>
                                   @foreach($visitorTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('visitor_type', $visitor->visitor_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach 
                                </select>
                            </div>

                            <!-- First Name and Middle Name -->
                            <div class="col-sm-6">
                                <input type="text" id="fname" name="first_name" class="form-control form-control-lg p-3" 
                                       placeholder="First Name" required>
                                
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="mname" name="middle_name" class="form-control form-control-lg p-3" 
                                       placeholder="Middle Name">
                            </div>

                            <!-- Last Name and Contact Number -->
                            <div class="col-sm-6">
                                <input type="text" id="lname" name="last_name" class="form-control form-control-lg p-3" 
                                       placeholder="Last Name" required>
                              
                            </div>
                            <div class="col-sm-6">
                                <input type="text" id="number" name="number" class="form-control form-control-lg p-3" 
                                       placeholder="Contact Number" required pattern="[0-9+\-\s]+">
                              
                            </div>

                            <!-- Address -->
                            <div class="col-12">
                                <textarea class="form-control form-control-lg p-4" name="address" id="address" 
                                          placeholder="Enter your address here..." required></textarea>
                            
                            </div>
                        </div>
                          <!-- Form Actions -->
                <div class="col-12 mt-4 mb-2">
                                <div class="d-flex justify-content-center gap-3 flex-wrap">
                                    <button type="submit" class="btn btn-save btn-lg px-4 w-45">
                                        Save
                                    </button>
                                    <button type="button" class="btn btn-cancel btn-lg px-4 w-45" onclick="clearForm()">
                                        Cancel
                                    </button>
                                </div>
                            </div>
                    </div>
                    
                    <!-- Camera Section -->
                    <div class="col-lg-6">
                        <div class="camera-section mb-3">
                            <div class="camera-label mb-3 text-center text-white">Capture Image
                            <div id="my_camera" class="mb-3">
                                <div class="text-muted text-center">
                                    {{-- <small>Camera will appear here</small> --}}
                                </div>
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
                </div>
                
                
                {{-- <input type="hidden" name="id"> --}}
            </form>
        </div>
    </div>
</body>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- External JS file inclusion -->
@vite(['resources/js/VisitorsForm.js'])
</html>