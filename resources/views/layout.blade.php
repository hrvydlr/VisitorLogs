<!DOCTYPE html>
<html lang="en">

@include('layouts.head')

<body>

    @include('layouts.header')

    @include('layouts.sidebar')

    <div id="content">

        <div class="content-box">

            <div class="content-wrapper">

                <div class="page-title">

                    <div class="d-flex justify-content-between align-items-center box  px-4 py-3">

                    <h3 class="position-absolute start-50 translate-middle-x m-0 text-center mt-5 pt-3 ">@yield('title')</h3>

                        @yield('button')

                    </div>

                </div>

                @yield('content')

            </div>

            @include('components.confirmation')
            @include('components.toast')

            @stack('scripts')

        </div>

    </div>
    
    @include('layouts.footer')

    

</body>

</html>
