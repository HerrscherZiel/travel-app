<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <!-- Custom fonts for this template-->


    <link href="{{url('/')}}/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{url('/')}}/css/select2.min.css" rel="stylesheet">

    <!-- Custom styles for this template-->
     <link href="{{url('/')}}/css/sb-admin-2.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

     <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
    <!-- Sweetalert 2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>

<body id="page-top">

    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/dashboard">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Travel <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Halaman <span id="role">Pengguna</span>
            </div>

            <li class="nav-item">
                <a class="nav-link admin-only" style="display: none;" href="/admin/users">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Pengguna</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link admin-only" style="display: none;" href="/admin/jadwal">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Jadwal Travel</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link admin-only" style="display: none;" href="/admin/laporan-travel">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Laporan Travel</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link user-only" href="/pengguna/jadwal-travel">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Jadwal Travel</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link user-only" href="/pengguna/pemesanan">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Pemesanan Tiket</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link user-only" href="/pembayaran/pending">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Pembayaran</span></a>
            </li>

            <li class="nav-item">
                <a class="nav-link user-only" href="/pengguna/riwayat-pemesanan">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Riwayat Pemesanan</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <!-- Dropdown - Messages -->
                            <span id="username">{{ Auth::user()->username ?? 'Guest' }}</span>
                        </li>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                
                                <button class="btn" onclick="logout()">Logout</button>

                            </a>

                            <!-- Dropdown - User Information -->
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <div class="container-fluid">
                    @yield('content')

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; Your Website 2025</span>
                </div>
            </div>
        </footer>
        </div>


        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>


    <!-- Bootstrap core JavaScript-->
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{url('/')}}/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{url('/')}}/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="{{url('/')}}/vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{url('/')}}/js/demo/chart-area-demo.js"></script>
    <script src="{{url('/')}}/js/demo/chart-pie-demo.js"></script>


    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
    </script>

    <script>
        async function getUser() {
            let token = localStorage.getItem('token'); // Retrieve token from localStorage
            console.log(localStorage.getItem('token'));

            if (!token) {
                window.location.href = "/login"; // Redirect to login if no token found
                return;
            }

            let response = await fetch('/api/user', {
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + token }
            });

            if (response.ok) {
                let user = await response.json();
                document.getElementById('username').innerText = user.username;
                document.getElementById('role').innerText = user.role;

                // Ambil semua tombol
                let adminButtons = document.querySelectorAll('.admin-only');
                let userButtons = document.querySelectorAll('.user-only');

                // Reset visibilitas
                adminButtons.forEach(btn => btn.style.display = 'none');
                userButtons.forEach(btn => btn.style.display = 'none');

                // Tampilkan tombol berdasarkan role
                if (user.role === 'admin') {
                    adminButtons.forEach(btn => btn.style.display = 'block');
                } else if (user.role === 'user') {
                    userButtons.forEach(btn => btn.style.display = 'block');
                }
            } else {
                localStorage.removeItem('token');
                window.location.href = "/login";
            }
        }

        getUser(); // Call function when the page loads
    </script>

    <script>
        function logout() {
            fetch("{{ url('/api/logout') }}", {
                method: "POST",
                headers: {
                    "Authorization": "Bearer " + localStorage.getItem("token"),
                    "Accept": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                localStorage.removeItem("token"); // Hapus token
                window.location.href = "/login";
            })
            .catch(error => console.error("Error:", error));
        }
    </script>


    <!-- @stack('scripts') -->
</body>

</html>