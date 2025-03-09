<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel - Login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{url('/')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

    <div class="container">

        <div class="d-flex justify-content-center align-items-center min-vh-100 w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex justify-content-center align-items-center">
                                <div class="image-container">
                                    <img src="{{ asset('img/4873.jpg') }}" alt="Logo" width="150">
                                </div>
                            </div>
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Selamat Datang!</h1>
                                        </div>
                                        <form  class="user" id="login-form">
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user"
                                                    id="email" aria-describedby="emailHelp"
                                                    placeholder="Enter Email Address..." required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user"
                                                    id="password" placeholder="Password" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                                Login
                                            </button>
                                            <hr>
                                        </form>
                                        <div class="text-center">
                                            <p class="small">Tidak mempunyai akun?</p>
                                        </div>
                                        <div class="text-center">
                                            <a class="small" href="/register">Buat Akun Baru!</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <script src="{{url('/')}}/vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="{{url('/')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('/')}}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{url('/')}}/js/sb-admin-2.min.js"></script>
    <script>
        document.getElementById('login-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            let email = document.getElementById('email').value;
            let password = document.getElementById('password').value;

            let response = await fetch('/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ email, password })
            });

            let result = await response.json();
            if (response.ok) {
                alert('Login sukses!');
                localStorage.setItem('token', result.token);
                localStorage.setItem("user_id", result.user.id);
                window.location.href = "/dashboard?token=" + result.token; // Kirim token ke dashboard
            } else {
                alert('Error: ' + result.message);
            }
        });
    </script>
    <style>
        .image-container {
            display: flex;

            width: 300px; 
            height: 300px;
            overflow: hidden; /* Cegah gambar keluar dari div */
            background-color: #f0f0f0; /* Opsional */
        }

        .image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* Memastikan gambar memenuhi ruang tanpa merusak rasio */
        }
    </style>
</body>
</html>
