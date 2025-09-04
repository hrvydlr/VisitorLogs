{{-- login.blade.php --}}
@extends('layout')

@section('content')
<div id="login">
        <div class="container-fluid d-flex justify-content-center align-items-center vh-100">
            <div class="row login-form-container">
                <div class="col-12 col-lg-6 welcome-container d-flex flex-column justify-content-center align-items-center text-white">
                    <img src="{{ asset('Images/compass.png') }}" alt="Compass Icon" class="img-fluid mb-2 mw-250">
                    <h1 class="welcome-txt">Welcome to <br>Magellan Solutions!</h1>
                    <p class="tagline">See The Future Your Way</p>
                </div>
                <div class="col-12 col-lg-6 login-form d-flex justify-content-center align-items-center">
                    <form action="{{ route('login') }}" method="POST" class="d-flex flex-column align-items-center w-75">
                        @csrf 
                    <h1 class="logintxt text-center fw-bolder text-white">Login</h1>

                        <div class="input-box w-100">
                            <span class="input-box-text">
                                <i class="bi bi-person-fill"></i>
                            </span>
                            <input type="text"
                                   name="username"
                                   id="username"
                                   placeholder="Username"
                                   autocomplete="off"
                                   required>
                        </div>

                        <div class="input-box w-100">
                            <span class="input-box-text">
                                <i class="bi bi-lock-fill"></i>
                            </span>
                            <input type="password"
                                   name="password"
                                   id="password"
                                   placeholder="Password"
                                   autocomplete="off"
                                   required>
                            <button type="button" class="togglePassword-btn" onclick="togglePasswordVisibility()">
                                <i id="togglePasswordIcon" class="bi bi-eye-fill"></i>
                            </button>
                        </div>
                        <button type="submit" class="loginbtn mt-2">LOGIN</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
@endsection

@push('scripts')
    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleBtnIcon = document.getElementById('togglePasswordIcon');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleBtnIcon.classList.remove('bi-eye-fill');
                toggleBtnIcon.classList.add('bi-eye-slash-fill');
            } else {
                passwordInput.type = 'password';
                toggleBtnIcon.classList.remove('bi-eye-slash-fill');
                toggleBtnIcon.classList.add('bi-eye-fill');
            }
        }
    </script>
@endpush
