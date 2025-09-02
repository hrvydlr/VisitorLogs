<!DOCTYPE html>
<html lang="en">
@include('layouts.head')
<body id="visitor-log">
    <div id="visitorLog-container">
        <div class="header"></div>
        <div class="content">
            <img src="/images/Magellan_pure_white_logo.png" class="logo mb-3" alt="logo">
            <h1 class="fw-bold">Welcome to</h1>
            <h1 class="fw-bold">Magellan Solutions!</h1>
        </div>

        <div class="form">
            <form class="row m-3 gap-3" id="visitorsForm">
                <div class="form-fields">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-md-6 mb-4">
                            <input type="text" name="id_number" id="id_number" placeholder="ID Number"class="form-control rounded-pill p-3" required minlength="3" maxlength="4">
                            </div>

                            <input type="hidden" name="id">

                            <div class="col-md-6 mb-4">
                                <select name="visitor_type" id="visitor_type" class="form-control rounded-pill w-100 p-3">
                                    <option value="" disabled selected>Select Visitor Type</option>
                                    @foreach($visitorTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('visitor_type', $visitor->visitor_type_id ?? '') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                        <div class="col-12 mb-4">
                            <input type="text" id="fname" name="first_name" class="form-control rounded-pill p-3" placeholder="First Name">
                        </div>

                        <div class="col-12 mb-4">
                            <input type="text" id="mname" name="middle_name" class="form-control rounded-pill p-3" placeholder="Middle Name">
                        </div>

                        <div class="col-12 mb-4">
                            <input type="text" id="lname" name="last_name" class="form-control rounded-pill p-3" placeholder="Last Name">
                        </div>

                        <div class="col-12 mb-4">
                            <input type="text" id="address" name="address" class="form-control rounded-pill p-3" placeholder="Address Name">
                        </div>

                        <div class="col-12 mb-5">
                            <input type="text" id="number" name="number" class="form-control rounded-pill p-3" placeholder="Contact Number">
                        </div>
                </div>

                <div class="camera-container">
                    <div class="camera">
                        <label class="form-label fw-bold">Capture Image:</label>
                            <div id="my_camera" class="border p-2 mb-3" style="transform:scaleX(-1);"></div>
                            <div class="d-flex justify-content-center gap-4">
                                <button type="button" class="btn btn-primary" id="captureBtn">Capture</button>
                                <button type="button" class="btn btn-danger" id="recaptureBtn" disabled>Recapture</button>
                            </div>
                            <input type="hidden" name="image" id="captured_image" required>
                            <div id="image-error" class="text-danger mt-1" style="display: none;">Please capture an image before submitting.</div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary rounded-pill p-3 save-button">Save</button>
            </form>
        </div>
    </div>
</body>


<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<!-- External JS file inclusion -->
@vite(['resources/js/VisitorsForm.js'])
</html>