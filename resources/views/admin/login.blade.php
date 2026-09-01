<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Login Admin | E-Pilketos</title>
    <!-- Tabler Core -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@2.36.0/tabler-icons.min.css" rel="stylesheet"/>
    <style>
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", sans-serif; background-color: #f1f5f9; }
    </style>
</head>
<body class="d-flex flex-column">
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="#" class="navbar-brand navbar-brand-autodark">
                    <img src="{{ asset('img/epilketos-logo.jpg') }}" height="50" alt="Logo" class="rounded shadow-sm">
                </a>
            </div>
            <div class="card card-md shadow-sm border-0" style="border-radius: 12px;">
                <div class="card-body">
                    <h2 class="h2 text-center mb-4">Login Panel Admin</h2>
                    
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <div class="d-flex">
                                <div><i class="ti ti-alert-circle icon alert-icon"></i></div>
                                <div>{{ $errors->first() }}</div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username admin" autocomplete="off" required value="{{ old('username') }}">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <div class="input-group input-group-flat">
                                <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password" autocomplete="off" required>
                                <span class="input-group-text">
                                    <a href="#" class="link-secondary" id="togglePassword" title="Tampilkan password" data-bs-toggle="tooltip">
                                        <i class="ti ti-eye" id="eyeIcon"></i>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="form-footer">
                            <button type="submit" class="btn btn-primary w-100">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="text-center text-muted mt-3">
                &copy; {{ date("Y") }} E-Pilketos by Panitia.
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta17/dist/js/tabler.min.js"></script>
    <script>
        document.getElementById("togglePassword").addEventListener("click", function(e) {
            e.preventDefault();
            const passwordInput = document.getElementById("passwordInput");
            const eyeIcon = document.getElementById("eyeIcon");
            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.classList.remove("ti-eye");
                eyeIcon.classList.add("ti-eye-off");
            } else {
                passwordInput.type = "password";
                eyeIcon.classList.remove("ti-eye-off");
                eyeIcon.classList.add("ti-eye");
            }
        });
    </script>
</body>
</html>
