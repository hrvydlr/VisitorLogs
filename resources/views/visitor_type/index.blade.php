@extends('layout')
<head>
    <style>
        
    </style>
</head>
</body>

@section('button')
    <div class="d-flex justify-content-end mt-5 pt-5 w-100" id="visitor_type_index">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addVT"><i class="bi bi-plus-circle"></i> Add Visitor Type</button>
    </div>
@endsection

@section('content')
<div class="container" id="visitor_type_index">
    <h2 class="visitortype" >Visitor Types</h2>
    <!-- Existing Visitor Types Table -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
             <table class="table table-bordered" id="visitorTypeTable"></table>
            </div>
        </div>
    </div>
</div>
@endsection
</body>

@include('components.modal', [
    'modal_id'      => 'visitortypemodal',
    'modal_size'    => '',
    'form_title'    => 'Visitor Type',
    'form_content'  => view('visitor_type.form' )
])

@push('scripts')
    <script> let default_fields = {!!json_encode(config('constants.crud.visitor_type')) !!} </script>
    @vite(['resources/js/VisitorType.js'])
@endpush
