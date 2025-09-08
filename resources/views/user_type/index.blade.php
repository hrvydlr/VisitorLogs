@extends('layout')



@section('content')

<div class="user-types-container mt-4">
    <div class="page-header">
        <div class="header-content">
            <h2 class="page-title">User Types</h2>
            <p class="page-subtitle mb-3">Manage and organize different user roles and permissions</p>
            <button type="button" 
                        class="btn btn-primary rounded-3 btn-addUT mb-1 justify-content-end" 
                        id="btn-addUT">
                    <i class="bi bi-plus-circle "></i> Add User Type
                </button>
           
        </div>
    </div>

    <div class="table-card table-card-fixed-height py-4">
        <div class="table-container table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table modern-table border border-dark-subtle" id="userType">
            
            </table>
        </div>
    </div>
</div>

@include('components.modal', [
    'modal_id'      => 'usertypemodal',
    'modal_size'    => '',
    'form_title'    => 'Register User Type',
    'form_content'  => view('user_type.form')->render()
])
@endsection

@push('scripts')
<script>
    let default_fields = {!! json_encode(config('constants.crud.user_type')) !!};
</script>
@vite(['resources/js/UserType.js'])
@vite('resources/sass/app.scss')
@endpush
