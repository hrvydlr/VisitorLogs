@extends('layout')
<head>
    <style>
        .card {
            
            
            overflow-x: hidden; /* Optional, helps avoid scrollbars inside card */
            
        }

        @media screen and (min-width: 400px) and (max-width: 5760px){
            .card {
                width: 100%!important;
                height: 50%!important;
            }
            

            @media screen and (min-width: 580px) {
            .card {
                position: relative;
                width: 105%!important;
                height: 50%!important;
                right: 2%;
            }
            
        }

        @media screen and (min-width: 770px) {
            body{
                overflow: hidden;
            }
            .card {
                width: 70%!important;
             
                left:34%;
                
            }


            .user{            position: relative;
                left: 35%!important;
            }
        }

        @media screen and (min-width: 850px) {
            .card {
                width: 90%!important;
                height: 50%!important;
                left:24%;
            }
            .user{            position: relative;
                left: 26%!important;
            }
        }

        @media screen and (min-width: 1000px) {
            .card {
                width: 82%!important;
                left:23%;
            }
            .user{            position: relative;
                left: 25%!important;
            }
        }

        @media screen and (min-width: 1200px) {
            .card {
                width: 87%!important;         
                left:18%;
            }
            .user{            position: relative;
                left: 19%!important;
            }
        }

        @media screen and (min-width: 1600px) {
            .card {
                width: 100%!important;         
                left:10%;
            }
            .user{            position: relative;
                left: 11.5%!important;
            }
        }

        @media screen and (min-width: 1800px) {
            .card {
                width: 120%!important;
                height: auto!important;
                max-height: 650px!important;         
                left:0%;
            }
            .user{            position: relative;
                left: 2%!important;
            }
        }

        
    }

    </style>
</head>
</body>


@section('button')
    <div class="d-flex justify-content-end align-items-center mt-5 pt-5 w-100">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addUsers" style="padding: 12px; position: relative; right: 25px"><i class="bi bi-plus-circle"></i> Add User</button>
    </div>
@endsection


@section('content')
<div class="container">
    <h2 class="user" style="position: relative; bottom: 50px; left: 8px">User</h2>
    <!-- Existing Users Table -->
    <div class="card" style="width: 120%; position : relative; bottom: 30px">
        <div class="card-body">
            <h5 class="card-title">All Users</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg ">
                <table class="table table-bordered" id="usersTable"></table>
            <table class="table table-bordered" id="usersTable"></table>
            </div>
        </div>
    </div>
</div>

@include('components.modal', [
    'modal_id'     => 'usermodal',
    'modal_size'   => '',
    'form_title'   => 'Add Users',
    'form_content' => view('users.form', compact('userTypes'))->render()
])

@endsection
</body>

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.users')) !!} </script>
@vite(['resources/js/User.js'])
@endpush