<!DOCTYPE html>
<html lang="en">

    @include('layouts.head')
    @yield('content')
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
              document.addEventListener('DOMContentLoaded', function() {
                const passwordInput = document.getElementById('passwordInput');
                const togglePassword = document.getElementById('togglePassword');
                const eyeIcon = document.getElementById('eyeIcon');
            
                togglePassword.addEventListener('click', function() {
                  const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                  passwordInput.setAttribute('type', type);
                  eyeIcon.classList.toggle('bi-eye-fill');
                  eyeIcon.classList.toggle('bi-eye-slash-fill');
                });
              });
            </script>
</html>