@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Pembayaran Pending</h2>

    <table class="table table-bordered table-hover">
        <thead class="thead-dark">
            <tr>
                <th>ID Pembayaran</th>
                <th>Tujuan Travel</th>
                <th>Waktu Pembayaran</th>
                <th>Jumlah Pembayaran</th>
                <th>Bukti Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody id="pembayaranBody">
            <tr>
                <td colspan="6" class="text-center">Memuat data...</td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal Upload Bukti Pembayaran -->
<div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalLabel">Upload Bukti Pembayaran</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUploadBukti">
                    @csrf
                    <input type="hidden" id="pembayaran_id" name="pembayaran_id">

                    <div class="form-group">
                        <label for="bukti_pembayaran">Upload Bukti (JPEG/PNG)</label>
                        <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="form-control" accept="image/*">
                    </div>

                    <button type="submit" class="btn btn-primary">Upload</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>

async function loadPendingPayments() {
    let token = localStorage.getItem("token");

    if (!token) {
        alert("Anda harus login untuk melihat pembayaran.");
        return;
    }

    try {
        let response = await fetch("/api/pembayaran/pending", {
            method: "GET",
            headers: {
                "Authorization": "Bearer " + token,
                "Content-Type": "application/json"
            }
        });

        if (!response.ok) {
            throw new Error("Gagal mengambil data pembayaran.");
        }

        let result = await response.json();
        let data = result.data;

        let tbody = document.getElementById("pembayaranBody");
        tbody.innerHTML = ""; // Kosongkan isi sebelumnya

        if (data.length === 0) {
            tbody.innerHTML = `<tr><td colspan="6" class="text-center">Tidak ada pembayaran pending</td></tr>`;
            return;
        }

        // Loop untuk menampilkan data ke tabel
        data.forEach(item => {
            let row = `<tr>
                <td>${item.id}</td>
                <td>${item.pemesanan.jadwal_travel.tujuan}</td>
                <td>${formatTanggal(item.waktu_pembayaran)}</td>
                <td>Rp ${new Intl.NumberFormat().format(item.jumlah_pembayaran)}</td>
                <td>${item.bukti_pembayaran ? `<img src="/storage/${item.bukti_pembayaran}" width="100">` : "Belum ada bukti"}</td>
                <td>
                    ${item.bukti_pembayaran ? "Sudah Bayar" : `<button class="btn btn-success btn-sm" onclick="bukaModalUpload(${item.id})">Upload Bukti</button>`}
                </td>
            </tr>`;
            tbody.innerHTML += row;
        });
    } catch (error) {
        console.error(error);
        alert("Terjadi kesalahan saat mengambil data pembayaran.");
    }
}

// Fungsi untuk membuka modal upload bukti pembayaran
function bukaModalUpload(id) {
    document.getElementById("pembayaran_id").value = id;
    document.getElementById("bukti_pembayaran").value = ""; // Reset file input
    $('#modalUpload').modal('show');
}

// Fungsi untuk upload bukti pembayaran
document.getElementById("formUploadBukti").addEventListener("submit", async function(e) {
    e.preventDefault();
    
    let formData = new FormData(this);
    let pembayaran_id = document.getElementById("pembayaran_id").value;
    let token = localStorage.getItem("token");

    let response = await fetch(`/api/pembayaran/upload/${pembayaran_id}`, {
        method: "POST",
        headers: {
            "Authorization": "Bearer " + token,
        },
        body: formData
    });

    let result = await response.json();

    if (response.ok) {
        alert("Bukti pembayaran berhasil diunggah.");
        $('#modalUpload').modal('hide');
        loadPendingPayments(); // Refresh data setelah upload
    } else {
        alert(result.message || "Gagal mengunggah bukti pembayaran.");
    }
});


// Fungsi untuk memformat tanggal menjadi tulisan
function formatTanggal(tanggal) {
    if (!tanggal) return "-";
    let date = new Date(tanggal);
    return date.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    }) + " " + date.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        hour12: false
    });
}

// Panggil fungsi saat halaman dimuat
document.addEventListener("DOMContentLoaded", loadPendingPayments);

</script>
@endsection
