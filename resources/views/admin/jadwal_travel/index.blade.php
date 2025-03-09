@extends('layouts.master')

@section('content')
<div class="container">
<h2>Jadwal Travel</h2>
    <div class="row justify-content-md-center">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="col-md-12">
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 my-auto">
                                    <h6 class="font-weight-bold text-primary m-0">Data Jadwal Travel</h6>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end">
                                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTambahJadwal">
                                        <i class="fas fa-plus"></i> Tambah Jadwal
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center data-table" id="jadwalTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Tujuan</th>
                                            <th>Tanggal & Waktu</th>
                                            <th>Kuota</th>
                                            <th>Harga Tiket</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!-- Modal Tambah Jadwal -->
    <div class="modal fade" id="modalTambahJadwal" tabindex="-1" role="dialog" aria-labelledby="modalTambahJadwalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTambahJadwalLabel">Tambah Jadwal Travel</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formTambahJadwal">
                        @csrf
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" class="form-control" id="tujuan" name="tujuan" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal & Jam Keberangkatan</label>
                            <input type="datetime-local" class="form-control" id="tanggal_jam" name="tanggal_jam" required>
                        </div>
                        <div class="form-group">
                            <label>Kuota Penumpang</label>
                            <input type="number" class="form-control" id="kuota" name="kuota" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Tiket</label>
                            <input type="number" class="form-control" id="harga_tiket" name="harga_tiket" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Update Modal -->
    <div class="modal fade" id="editJadwalModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Jadwal</h5>
                    <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="editJadwalForm">
                        <input type="hidden" id="jadwal_id">
                        <div class="form-group">
                            <label>Tujuan</label>
                            <input type="text" id="tujuan" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal & Jam</label>
                            <input type="datetime-local" id="tanggal_jam" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Kuota</label>
                            <input type="number" id="kuota" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Harga Tiket</label>
                            <input type="number" id="harga_tiket" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


<!-- Get Data -->
<script>
    $(document).ready(function() {
        $('#jadwalTable').DataTable({
            processing: true,
            serverSide: false, // Pakai false karena data langsung di-load dari API
            ajax: {
                url: "{{ url('/api/admin/jadwal-travel') }}",
                type: "GET",
                headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
                error: function(xhr, status, error) {
                    console.error("Error fetching data:", error);
                    console.log(xhr.responseText);
                }
            },

            columns: [
                { data: 'id' },
                { data: 'tujuan' },
                { 
                data: 'tanggal_jam', 
                name: 'tanggal_jam',
                render: function (data) {
                    let date = new Date(data);
                    let options = { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' };
                    let formattedDate = date.toLocaleDateString('id-ID', options);
                    let formattedTime = date.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

                    return `${formattedDate}, ${formattedTime}`;
                }
            },
                { data: 'kuota' },
                { data: 'harga_tiket' },{
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
    $('#jadwalTable').on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        editJadwal(id);
    });

    // Event listener tombol hapus
    $('#jadwalTable').on('click', '.delete-btn', function() {
    let id = $(this).data('id');
    deleteJadwal(id);
    });

    });
</script>

<!-- Add Data -->
<script>
    $(document).ready(function() {
        // Fungsi Tambah Jadwal Travel
        $("#formTambahJadwal").submit(function(e) {
            e.preventDefault(); // Mencegah reload halaman

            let formData = {
                tujuan: $("#tujuan").val(),
                tanggal_jam: $("#tanggal_jam").val(),
                kuota: $("#kuota").val(),
                harga_tiket: $("#harga_tiket").val(),
            };

            $.ajax({
                url: "{{ url('/api/admin/jadwal-travel') }}",
                type: "POST",
                data: JSON.stringify(formData),
                contentType: "application/json",
                headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
                success: function(response) {
                    alert("Jadwal travel berhasil ditambahkan!");
                    $("#modalTambahJadwal").modal("hide");
                    $("#jadwalTable").DataTable().ajax.reload(); // Reload DataTables
                },
                error: function(xhr, status, error) {
                    alert("Gagal menambahkan jadwal!");
                    console.log(xhr.responseText);
                }
            });
        });
    });

    function editJadwal(id) {
    $.ajax({
        url: `/api/admin/jadwal-travel/${id}`,
        type: "GET",
        headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
        success: function(response) {
            $("#editJadwalModal #jadwal_id").val(response.data.id);
            $("#editJadwalModal #tujuan").val(response.data.tujuan);
            $("#editJadwalModal #tanggal_jam").val(response.data.tanggal_jam);
            $("#editJadwalModal #kuota").val(response.data.kuota);
            $("#editJadwalModal #harga_tiket").val(response.data.harga_tiket);
            $("#editJadwalModal").modal('show');
        },
        error: function(xhr) {
            console.error(xhr.responseText);
            alert("Gagal mengambil data jadwal!");
        }
    });
    }

    function deleteJadwal(id) {
    Swal.fire({
        title: "Apakah Anda yakin?",
        text: "Data jadwal akan dihapus secara permanen!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya, Hapus!",
        cancelButtonText: "Batal"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/api/admin/jadwal-travel/${id}`,
                type: "DELETE",
                headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
                success: function(response) {
                    Swal.fire({
                        title: "Terhapus!",
                        text: "Jadwal berhasil dihapus.",
                        icon: "success",
                        timer: 1500,
                        showConfirmButton: false
                    });

                    // Reload tabel setelah penghapusan
                    $('#jadwalTable').DataTable().ajax.reload();
                },
                error: function(xhr) {
                    Swal.fire({
                        title: "Gagal!",
                        text: "Terjadi kesalahan saat menghapus jadwal.",
                        icon: "error"
                    });
                }
            });
        }
    });
    }

    
</script>

<!-- Update Data -->


@endsection
