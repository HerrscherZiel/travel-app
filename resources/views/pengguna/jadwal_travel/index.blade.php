@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Jadwal Travel yang Tersedia</h2>
    
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="filterTujuan">Filter Tujuan</label>
            <input type="text" id="filterTujuan" class="form-control" placeholder="Cari tujuan...">
        </div>
        <div class="col-md-4">
            <label for="filterTanggal">Filter Tanggal</label>
            <input type="date" id="filterTanggal" class="form-control">
        </div>
        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-50 me-2" onclick="loadJadwal()">Filter</button>
            <button class="btn btn-secondary w-50" onclick="resetFilter()">Reset</button>
        </div>
    </div>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Tujuan</th>
                <th>Tanggal & Waktu</th>
                <th>Kuota</th>
                <th>Sisa Kuota</th>
                <th>Harga Tiket</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="jadwalBody">
            <tr>
                <td colspan="5" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal Pesan Tiket -->
    <div class="modal fade" id="modalPemesanan" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Pemesanan Tiket</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formPemesanan">
                        @csrf
                        <input type="hidden" id="jadwal_id" name="jadwal_travel_id">
                        <input type="hidden" id="user_id" name="user_id">
                        <input type="hidden" id="tanggal_pemesanan" name="tanggal_pemesanan">
                        <input type="hidden" id="status_pembayaran" name="status_pembayaran" value="pending">

                        <div class="form-group">
                            <label for="tujuan">Tujuan</label>
                            <input type="text" id="tujuan" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_jam">Tanggal & Waktu</label>
                            <input type="text" id="tanggal_jam" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="kuota">Kuota</label>
                            <input type="number" id="kuota" class="form-control" readonly>
                        </div>

                        <button type="submit" class="btn btn-primary">Pesan Tiket</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<script>
    async function loadJadwal() {
        let tujuan = document.getElementById('filterTujuan').value;
        let tanggal = document.getElementById('filterTanggal').value;
        let token = localStorage.getItem('token');

        if (!token) {
            alert("Anda harus login untuk melihat jadwal travel.");
            return;
        }

        let response = await fetch("{{ url('/api/jadwal-travel/available') }}", {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });

        if (!response.ok) {
            alert("Gagal mengambil data..");
            return;
        }

        let result = await response.json();
        let data = result.data;
        let tbody = document.getElementById("jadwalBody");
        tbody.innerHTML = ""; // Kosongkan isi sebelumnya

        // Hanya tampilkan jadwal dari hari ini ke depan
        let today = new Date().toISOString().split('T')[0]; // Format YYYY-MM-DD
        data = data.filter(item => item.tanggal_jam.split(" ")[0] >= today);

        // Filter berdasarkan input pengguna
        if (tujuan) {
            data = data.filter(item => item.tujuan.toLowerCase().includes(tujuan.toLowerCase()));
        }
        if (tanggal) {
            data = data.filter(item => item.tanggal_jam.startsWith(tanggal));
        }

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="5" class="text-center">Tidak ada jadwal tersedia</td></tr>`;
            return;
        }

        // Loop untuk menambahkan data ke tabel
        data.forEach(item => {
            let row = `<tr>
            <td>${item.tujuan}</td>
            <td>${formatTanggal(item.tanggal_jam).toLocaleString()}</td>
            <td>${item.kuota}</td>
            <td>${item.sisa_kuota}</td>
            <td>Rp ${new Intl.NumberFormat().format(item.harga_tiket)}</td>
            <td>
                ${item.sisa_kuota > 0 ? `<button class="btn btn-success btn-sm" onclick="bukaModalPemesanan(${item.id}, '${item.tujuan}', '${item.tanggal_jam}', ${item.sisa_kuota})">Pilih</button>` : '<button class="btn btn-danger btn-sm">Habis</button>'}
            </td>
        </tr>`;;
            tbody.innerHTML += row;
        });
    }

    function resetFilter() {
        document.getElementById('filterTujuan').value = "";
        document.getElementById('filterTanggal').value = "";
        loadJadwal();
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

    async function bukaModalPemesanan(id, tujuan, tanggal_jam, sisa_kuota) {
        let token = localStorage.getItem('token');

        let userResponse = await fetch("{{ url('/api/user') }}", {
            headers: { "Authorization": "Bearer " + token }
        });
        let userData = await userResponse.json();

        document.getElementById('jadwal_id').value = id;
        document.getElementById('tujuan').value = tujuan;
        document.getElementById('tanggal_jam').value = new Date(tanggal_jam).toLocaleString();
        document.getElementById('kuota').value = sisa_kuota;
        document.getElementById('user_id').value = userData.id; 
        document.getElementById('tanggal_pemesanan').value = new Date().toISOString().slice(0, 19).replace("T", " ");

        $('#modalPemesanan').modal('show');
    }

    document.addEventListener("DOMContentLoaded", loadJadwal);

    document.getElementById("formPemesanan").addEventListener("submit", async function(e) {
        e.preventDefault();
        let formData = new FormData(this);
        let token = localStorage.getItem('token');

        let response = await fetch("{{ url('/api/pemesanan-tiket') }}", {
            method: "POST",
            headers: {
                "Authorization": "Bearer " + token,
                "Accept": "application/json"
            },
            body: formData
        });

        let result = await response.json();

        if (response.ok) {
            window.location.href = "/pengguna/pemesanan";
        } else {
            alert(result.message || "Gagal melakukan pemesanan.");
        }
    });


</script>


@endsection
