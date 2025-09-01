{{-- login.blade.php --}}
@extends('layout')

@section('content')
<div id="login-containers">
  <div class="clouds-container"></div>

  <div class="object container-fluid d-flex align-items-center justify-content-cente z-2">
    <div class="row w-100 pe-5">

      <div class="col-md-5 ms-2 mt-5 d-flex justify-content-center align-items-center logo-container">
        <img src="/images/logo.png" class="img-fluid" alt="Logo">
      </div>

      <div class="d-flex justify-content-end align-items-center login-form-container">
        <form class="p-5 forma w-100 bg-white" action="{{ route('login') }}" method="POST">
          @csrf
          <h2 class="logintxt text-center mb-5 fw-bolder">LOGIN</h2>

          <div class="input-group mb-3 d-flex">
            <span class="text-white d-flex align-items-center justify-content-center">
              <i class="bi bi-person-fill d-flex p-3" style="font-size: 1.2em;"></i>
            </span>
            <input type="text" name="username" class="form-control text-white" placeholder="Username" autocomplete="off">
          </div>

          <div class="input-group mb-4 d-flex">
            <span class="text-white d-flex align-items-center justify-content-center">
              <i class="bi bi-lock-fill d-flex p-3" style="font-size: 1.2em;"></i>
            </span>
            <input type="password" name="password" class="form-control text-white" placeholder="Password" id="passwordInput" autocomplete="off">
            <span class="text-white d-flex align-items-center justify-content-center" id="togglePassword">
              <i class="bi bi-eye-fill p-3" id="eyeIcon"></i>
            </span>
          </div>

          <button type="submit" class="btn w-100 rounded-pill fw-bold">LOGIN</button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const passwordInput = document.getElementById('passwordInput');
  const togglePassword = document.getElementById('togglePassword');
  const eyeIcon = document.getElementById('eyeIcon');

  if (togglePassword && passwordInput && eyeIcon) {
    togglePassword.addEventListener('click', function () {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      eyeIcon.classList.toggle('bi-eye-fill');
      eyeIcon.classList.toggle('bi-eye-slash-fill');
    });
  }
});
</script>
@endpush
