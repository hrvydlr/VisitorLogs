@extends('layout')

@section('content')
<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">
                <i class="title-icon"></i>Visitor Types
            </h2>
            <p class="page-subtitle mb-3">Manage and organize different visitor categories</p>
            <button type="button" 
                        class="btn btn-primary btn-md rounded-3 btn-addUT" 
                        id="btn-addVT">
                    <i class="bi bi-plus-circle"></i> Add Visitor Type
                </button>
        </div>
        </div>

    <div class="table-card table-card-fixed-height py-4">
        <div class="table-container table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table modern-table border border-dark-subtle" id="visitorTypeTable">
                
            </table>
        </div>
    </div>
</div>

@include('components.modal', [
    'modal_id'      => 'visitortypemodal',
    'modal_size'    => '',
    'form_title'    => 'Register Visitor Type',
    'form_content'  => view('visitor_type.form')->render()
])
@endsection

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.visitor_type')) !!};
</script>
@vite(['resources/js/VisitorType.js'])
@endpush
