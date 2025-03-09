<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel - Register</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{url('/')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="{{url('/')}}/css/sb-admin-2.min.css" rel="stylesheet">
</head>
<body>
    <body class="bg-gradient-primary">

    <div class="container">
        <div class="d-flex justify-content-center align-items-center min-vh-100 w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-5 d-flex justify-content-center align-items-center">
                                <div class="image-container">
                                    <img src="{{ asset('img/4873.jpg') }}" alt="Logo" width="150">
                                </div>
                            </div>
                            <div class="col-lg-7">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Buat Akun Baru!</h1>
                                    </div>
                                    <form id="register-form" class="user">
                                        @csrf
                                        <div class="form-group">
                                                <input type="text" class="form-control form-control-user" name="username"
                                                    placeholder="Masukan Username">
                                        </div>
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email"
                                                placeholder="Email Address">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="password" class="form-control form-control-user" name="password"
                                                        placeholder="Masukan password">
                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                    <input type="text" class="form-control form-control-user" name="no_hp"
                                                        placeholder="Masukan Nomor Telepon">
                                            </div>
                                        </div>
                                        <input type="hidden" name="role" value="user">
                                        <button class="btn btn-primary btn-user btn-block">
                                            Register Account
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <p class="small">Sudah mempunyai akun?</p>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="/login">Login!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{url('/')}}/vendor/jquery/jquery-3.6.0.min.js"></script>
    <script src="{{url('/')}}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('/')}}/vendor/jquery-easing/jquery.easing.min.js"></script>
    <!-- Custom scripts for all pages-->
    <script src="{{url('/')}}/js/sb-admin-2.min.js"></script>
    <script>
        document.getElementById('register-form').addEventListener('submit', async function(e) {
            e.preventDefault();

            let formData = new FormData(this);
            let response = await fetch('/api/register', {
                method: 'POST',
                body: formData,
                headers: { 'Accept': 'application/json' } // Tambahkan header ini
            });

            let result = await response.json();
            if (response.ok) {
                alert('Register sukses! Token: ' + result.token);
                localStorage.setItem('token', result.token); // Simpan token untuk login
                window.location.href = "/dashboard"; // Redirect ke halaman lain
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
