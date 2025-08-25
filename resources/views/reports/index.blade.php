{{--index.blade.php --}}

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


            .reports{            position: relative;
                left: 35%!important;
            }
        }

        @media screen and (min-width: 850px) {
            .card {
                width: 90%!important;
                height: 50%!important;
                left:24%;
            }
            .reports{            position: relative;
                left: 26%!important;
            }
        }

        @media screen and (min-width: 1000px) {
            .card {
                width: 80%!important;
                left:24%;
            }
            .reports{            position: relative;
                left: 25%!important;
            }
        }

        @media screen and (min-width: 1200px) {
            .card {
                width:85%!important;         
                left:19%;
            }
            .reports{            position: relative;
                left: 19%!important;
            }
        }

        @media screen and (min-width: 1600px) {
            .card {
                width: 100%!important;         
                left:10%;
            }
            .reports{            position: relative;
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
            .reports{            position: relative;
                left: 1.5%!important;
            }
        }

        
    }

    </style>
    </head>
<body>
@section('content')
<div class="container">

    <h2 class="reports" style="position: relative; top: 10vh; left: 8px">Reports</h2>
    <!-- Existing Users Table -->
    <div class="card" style="width: 120%; position : relative; top: 120px">
        <div class="card-body">
           
            <h5 class="card-title">Reports</h5>

            <div class="table-responsive-sm table-responsive-md table-responsive-lg">
            <table class="table table-bordered" id="reportsTable"></table>
        </div>
    </div>
</div>
@endsection
</body>

@push('scripts')
<script> let default_fields = {!!json_encode(config('constants.crud.reports')) !!} </script>
@vite(['resources/js/Reports.js'])
@endpush
