@extends('layouts.master')

@section('content')
<div class="container mt-4">
    <h2 class="mb-3">Laporan Jumlah Penumpang Travel</h2>

    <table id="laporanTable" class="table table-bordered display nowrap" style="width:100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tujuan</th>
                <th>Tanggal Keberangkatan</th>
                <th>Jumlah Penumpang</th>
                <th>Kuota</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<script>
$(document).ready(function () {
    $('#laporanTable').DataTable({
        processing: true,
        serverSide: false, 
        ajax: {
            url: "{{ url('/api/laporan-travel') }}",
            type: "GET",
            headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                console.log(xhr.responseText);
            }
        },

        columns: [
            { 
                data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1; 
                }
            },
            { data: "jadwal_travel.tujuan" },
            { 
                data: "jadwal_travel.tanggal_jam",
                render: function (data) {
                    let date = new Date(data);
                    let options = { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' };
                    let formattedDate = date.toLocaleDateString('id-ID', options);
                    let formattedTime = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                    return `${formattedDate}, ${formattedTime}`;
                }
            },
            { data: "jumlah_penumpang" },
            { data: "jadwal_travel.kuota" },
            { 
                data: null, 
                orderable: false, 
                searchable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-success btn-sm edit-btn" data-id="${row.id}"><i class="fa fa-lg fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm delete-btn" data-id="${row.id}"><i class="fa fa-lg fa-trash"></i></button>
                    `;
                }
            }
        ]
    });

    // Event listener tombol edit
    $('#laporanTable').on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        editLaporan(id);
    });

    // Event listener tombol hapus
    $('#laporanTable').on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        deleteLaporan(id);
    });
});

// Fungsi Edit (Sesuaikan dengan kebutuhan Anda)
function editLaporan(id) {
    alert("Fitur edit laporan dengan ID " + id + " belum dibuat!");
}

// Fungsi Delete (Sesuaikan dengan kebutuhan Anda)
function deleteLaporan(id) {
    if (confirm("Apakah Anda yakin ingin menghapus laporan ini?")) {
        $.ajax({
            url: "{{ url('/api/laporan-travel') }}/" + id,
            type: "DELETE",
            headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
            success: function(response) {
                alert("Laporan berhasil dihapus!");
                $('#laporanTable').DataTable().ajax.reload();
            },
            error: function(xhr, status, error) {
                console.error("Gagal menghapus:", error);
                console.log(xhr.responseText);
            }
        });
    }
}
</script>

@endsection
