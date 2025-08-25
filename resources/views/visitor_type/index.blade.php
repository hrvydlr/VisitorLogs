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
                body{
                overflow: hidden;
                }
            .card {
                position: relative;
                width: 110%!important;
                height: 50%!important;
                right: 5%;
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


            .visitortype{            position: relative;
                left: 35%!important;
            }
        }

        @media screen and (min-width: 850px) {
            .card {
                width: 80%!important;
                height: 50%!important;
                left:28.5%;
            }
            .visitortype{            position: relative;
                left: 30%!important;
            }
        }

        @media screen and (min-width: 1000px) {
            .card {
                width: 75%!important;
                left:26.5%;
            }
            .visitortype{            position: relative;
                left: 28%!important;
            }
        }

        @media screen and (min-width: 1200px) {
            .card {
                width: 85%!important;         
                left:19%;
            }
            .visitortype{            position: relative;
                left: 21%!important;
            }
        }

        @media screen and (min-width: 1600px) {
            .card {
                width: 100%!important;         
                left:10%;
            }
            .visitortype{            position: relative;
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
            .visitortype{            position: relative;
                left: 2%!important;
            }
        }

        
    }

    </style>
</head>
</body>

@section('button')
    <div class="d-flex justify-content-end mt-5 pt-5 w-100">
        <button type="button" class="btn btn-primary btn-md rounded-pill" id="btn-addVT" style="padding: 12px; position: relative; right: 25px" id="btn-addVT"><i class="bi bi-plus-circle"></i> Add Visitor Type</button>
    </div>
@endsection

@section('content')
<div class="container">
    <h2 class="visitortype" style="position: relative; bottom: 50px; left: 8px">Visitor Types</h2>
    <!-- Existing Visitor Types Table -->
    <div class="card" style="width: 120%; position : relative; bottom: 30px">
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
