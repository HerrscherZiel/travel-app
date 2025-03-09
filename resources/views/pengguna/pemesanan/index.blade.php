@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Pemesanan Tiket (Pending)</h2>
        <a href="{{ url('/pengguna/riwayat-pemesanan') }}" class="btn btn-secondary">Lihat Riwayat Pemesanan</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tujuan Travel</th>
                <th>Pemberangkatan Travel</th>
                <th>Tanggal Pemesanan</th>
                <th>Status Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pemesananBody">
            <tr>
                <td colspan="5" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>


<script>
    async function loadPemesanan() {
        let token = localStorage.getItem("token"); 
        let userId = localStorage.getItem("user_id"); 

        let response = await fetch(`/api/pemesanan-tiket?user_id=${userId}`, {
            headers: { "Authorization": "Bearer " + token }
        });

        let result = await response.json();
        let data = result.data; 

        let tbody = document.getElementById("pemesananBody");
        tbody.innerHTML = ""; 

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada pemesanan pending</td></tr>`;
            return;
        }

        data.forEach(item => {
            let row = `<tr>
                <td>${item.jadwal_travel.tujuan}</td>  
                <td>${formatTanggal(item.jadwal_travel.tanggal_jam).toLocaleString()}</td>
                <td>${formatTanggal(item.tanggal_pemesanan).toLocaleString()}</td>
                <td>${item.status_pembayaran}</td>
                <td>
                    <button class="btn btn-danger btn-sm" onclick="batalkanPemesanan(${item.id})">Batalkan</button>
                    <a href="#" class="btn btn-primary btn-sm" onclick="bayarTiket(${item.id})">Bayar</a>
                </td>
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

    async function batalkanPemesanan(id) {
        let token = localStorage.getItem("token");

        Swal.fire({
            title: "Apakah Anda yakin?",
            text: "Tiket yang dibatalkan tidak bisa dikembalikan!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Batalkan!",
            cancelButtonText: "Batal"
        }).then(async (result) => {
            if (result.isConfirmed) {
                let response = await fetch(`/api/pemesanan-tiket/${id}`, {
                    method: "DELETE",
                    headers: { "Authorization": "Bearer " + token }
                });

                let result = await response.json();

                Swal.fire({
                    title: "Dibatalkan!",
                    text: result.message,
                    icon: "success"
                });

                // Muat ulang tabel setelah pembatalan berhasil
                loadPemesanan();
            }
        });
    }

    function bayarTiket(id) {
        Swal.fire({
            title: "Menuju Pembayaran",
            text: "Anda akan diarahkan ke halaman pembayaran.",
            icon: "info",
            confirmButtonText: "Lanjutkan"
        }).then(() => {
            window.location.href = `/pembayaran/pending`;
        });
    }

    document.addEventListener("DOMContentLoaded", loadPemesanan);
</script>
@endsection
