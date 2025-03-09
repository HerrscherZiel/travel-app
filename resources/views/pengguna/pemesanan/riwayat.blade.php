@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Riwayat Pemesanan Tiket</h2>
        <a href="{{ url('/pengguna/pemesanan') }}" class="btn btn-success">Kembali ke Pemesanan</a>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tujuan Travel</th>
                <th>Pemberangkatan Travel</th>
                <th>Tanggal Pemesanan</th>
                <th>Status Pembayaran</th>
            </tr>
        </thead>
        <tbody id="riwayatBody">
            <tr>
                <td colspan="4" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<script>
    async function loadRiwayat() {
        let token = localStorage.getItem("token");
        let userId = localStorage.getItem("user_id");

        let response = await fetch(`/api/pemesanan-tiket/riwayat?user_id=${userId}`, {
            headers: { "Authorization": "Bearer " + token }
        });

        let result = await response.json();
        let data = result.data;
        let tbody = document.getElementById("riwayatBody");
        tbody.innerHTML = "";

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="4" class="text-center">Tidak ada riwayat pemesanan</td></tr>`;
            return;
        }

        data.forEach(item => {
            let row = `<tr>
                <td>${item.jadwal_travel.tujuan}</td>  
                <td>${formatTanggal(item.jadwal_travel.tanggal_jam).toLocaleString()}</td>
                <td>${formatTanggal(item.tanggal_pemesanan).toLocaleString()}</td>
                <td><button class="btn bg-success text-white" >Lunas</button></td>
            </tr>`;
            tbody.innerHTML += row;
        });
    }

    function formatTanggal(tanggal) {
        let date = new Date(tanggal);

        let formattedDate = date.toLocaleDateString('id-ID', {
            weekday: 'long',  
            day: '2-digit',   
            month: 'long',    
            year: 'numeric'   
        });

        let formattedTime = date.toLocaleTimeString('id-ID', {
            hour: '2-digit',   
            minute: '2-digit', 
            hour12: false      
        });

        return `${formattedDate} ${formattedTime}`;
    }

    document.addEventListener("DOMContentLoaded", loadRiwayat);
</script>
@endsection
