@extends('layout')

<body>

    @section('button')
        <div class="button1 d-flex justify-content-end align-items-center mt-5 pt-5 w-100">
            <a href="{{ route('guard.form') }}" target="_blank" class="btn btn-primary btn-md rounded-pill"
                style="position: relative; right: 110px; padding: 12px;" id="btn-addUsers"><i class="bi bi-plus-circle"></i>
                Add Visitor</a>
        </div>
    @endsection


    @section('content')
        <div class="container">
            <h2 class="registerid" style= "position: relative; bottom: 50px; left: -190px">Visitor Log Sheets</h2>
            <!-- Existing Users Table -->
            <div class="card" style= "width: 130%; position : relative; bottom: 30px; margin-left: -200px">
                <div class="card-body">
                    <h5 class="card-title">All Users</h5>

                    <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
                        <table class="table table-bordered" id="visitorsTable"></table>
                    </div>
                </div>
            </div>
        @endsection
</body>
@push('scripts')
    <script>
        let default_fields = {!! json_encode(config('constants.crud.visitor')) !!}
    </script>
    @vite(['resources/js/Guard.js'])
@endpush
