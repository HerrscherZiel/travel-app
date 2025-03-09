@extends('layouts.master') <!-- Sesuaikan dengan layout Anda -->

@section('content')
<div class="container">
<h2>Users</h2>
    <div class="row justify-content-md-center">
            <div class="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div class="col-md-12">
                    <div class="card shadow mb-4">

                        <div class="card-header py-3">
                            <div class="row">
                                <div class="col-md-6 my-auto">
                                    <h6 class="font-weight-bold text-primary m-0">Data Users</h6>
                                </div>
                                <div class="col-md-6 my-auto">
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered text-center data-table" id="usersTable" width="100%" cellspacing="0">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>No HP</th>
                                        <th>Role</th>
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

<script>
    $('#usersTable').DataTable({
        processing: true,
        serverSide: false, // Ubah ke false dulu untuk debugging
        ajax: {
            url: "{{ url('/api/admin/users') }}",
            type: "GET",
            headers: { "Authorization": "Bearer " + localStorage.getItem('token') },
            dataSrc: 'data', // Sesuaikan dengan struktur JSON
            error: function(xhr, status, error) {
                console.error("Error fetching data:", error);
                console.log(xhr.responseText);
            }
        },
        columns: [
            { data: 'id' },
            { data: 'username' },
            { data: 'email' },
            { data: 'no_hp' },
            { data: 'role' }
        ]
    });
</script>

@endsection
