@extends('layouts.master')

@section('content')

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
    <div class="card">
        <div class="card-header">
            <h2>Selamat Datang, <span id="username2">User</span></h2>
        </div>
        <div class="card-body">
            <p>Website Travel ini dapat digunakan untuk melihat jadwal travel, data pemesanan tiket, pembayaran, dan data laporan travel pengguna</p>
            <p>Gunakan tombol sidebar untuk mengakses dan mengarahkan pada halaman fitur yang tersedia </p>
        </div>
    </div>

    <script>
        let urlParams = new URLSearchParams(window.location.search);
        let token = urlParams.get('token');

        if (token) {
            localStorage.setItem('token', token); 
            window.history.replaceState({}, document.title, "/dashboard"); 
        } else {
            token = localStorage.getItem('token');
        }

        async function getUser() {
            if (!token) {
                window.location.href = "/login";
                return;
            }

            let response = await fetch('/api/user', {
                method: 'GET',
                headers: { 'Authorization': 'Bearer ' + token }
            });

            console.log('Response Status:', response.status); 
            const responseBody = await response.text(); 
            console.log('Response Body:', responseBody); 

            if (response.ok) {
                let user = JSON.parse(responseBody); 
                console.log('User Data:', user); 
                document.getElementById('username2').innerText = user.username;
            } else {
                localStorage.removeItem('token');
                window.location.href = "/login";
            }
        }

        getUser();
    </script>


@endsection