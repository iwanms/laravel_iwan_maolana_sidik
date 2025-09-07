<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Hospital</a>
            <div class="dropdown ms-auto">
                <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                {{ Auth::user()->name }}
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                <li class="dropdown-item text-center">
                    <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}" class="rounded-circle mb-2" width="60" alt="Foto User">
                    <div><strong>{{ Auth::user()->username }}</strong></div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="dropdown-item text-danger">Logout</button>
                    </form>
                </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Daftar Pasien</h4>
            <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalTambahPasien">
            + Tambah Data Pasien
            </button>
        </div>

        <table class="table table-bordered" id="pasien-table">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Alamat</th>
                    <th>No HP</th>
                    <th>Rumah Sakit</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function () {
            let table = $('#pasien-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route("pasien.data") }}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'address', name: 'address' },
                    { data: 'no_hp', name: 'no_hp' },
                    { data: 'hospital_name', name: 'hospital_name' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#form-tambah-pasien').submit(function (e) {
                e.preventDefault();

                $.ajax({
                    url: '{{ route("pasien.store") }}',
                    type: 'POST',
                    data: {
                        name: $('input[name="name"]').val(),
                        address: $('input[name="address"]').val(),
                        no_hp: $('input[name="no_hp"]').val(),
                        hospital_id: $('select[name="hospital_id"]').val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#modalTambahPasien').modal('hide');
                        $('#form-tambah-pasien')[0].reset();
                        table.ajax.reload(null, false);
                    },
                    error: function (xhr) {
                        let errors = xhr.responseJSON.errors;
                        let message = 'Gagal menyimpan data.';
                        if (errors) {
                            message = Object.values(errors).map(e => e.join(', ')).join('\n');
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: message
                        });
                    }
                });
            });

            $('#pasien-table').on('click', '.delete-btn', function () {
                let id = $(this).data('id');
                Swal.fire({
                    title: 'Yakin ingin menghapus?',
                    text: 'Data akan dihapus permanen!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                    }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                        url: '/pasien/' + id,
                        type: 'DELETE',
                        success: function (response) {
                            Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                            });
                            table.ajax.reload(null, false);
                        },
                        error: function () {
                            Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Gagal menghapus data.',
                            });
                        }
                        });
                    }
                });
            });

            $('#pasien-table').on('click', '.edit-btn', function () {
                $('#edit-id').val($(this).data('id'));
                $('#edit-name').val($(this).data('name'));
                $('#edit-address').val($(this).data('address'));
                $('#edit-no_hp').val($(this).data('no_hp'));
                $('#edit-hospital_id').val($(this).data('hospital_id'));
            });

            // Submit form edit
            $('#form-edit-pasien').submit(function (e) {
                e.preventDefault();
                let id = $('#edit-id').val();

                $.ajax({
                        url: '/pasien/' + id,
                        type: 'PUT',
                        data: {
                        name: $('#edit-name').val(),
                        address: $('#edit-address').val(),
                        no_hp: $('#edit-no_hp').val(),
                        hospital_id: $('#edit-hospital_id').val()
                    },
                    success: function (response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.success,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#modalEditPasien').modal('hide');
                        table.ajax.reload(null, false);
                    },
                    error: function () {
                        alert('Gagal update data.');
                    }
                });
            });
        });
    </script>

    <!-- Modal Tambah Pasien -->
    <div class="modal fade" id="modalTambahPasien" tabindex="-1" aria-labelledby="modalTambahPasienLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-tambah-pasien">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                <h5 class="modal-title" id="modalTambahPasienLabel">Tambah Pasien</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <div class="mb-3">
                    <label>Nama</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Alamat</label>
                    <input type="text" name="address" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>No HP</label>
                    <input type="text" name="no_hp" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Rumah Sakit</label>
                    <select name="hospital_id" class="form-select" required>
                    <option value="">-- Pilih Rumah Sakit --</option>
                    @foreach($hospitals as $hospital)
                        <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                    @endforeach
                    </select>
                </div>
                </div>
                <div class="modal-footer">
                <button type="submit" class="btn btn-success">Simpan</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                </div>
            </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Pasien -->
    <div class="modal fade" id="modalEditPasien" tabindex="-1" aria-labelledby="modalEditPasienLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="form-edit-pasien">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Pasien</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="edit-id">
                        <div class="mb-3">
                            <label>Nama</label>
                            <input type="text" id="edit-name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Alamat</label>
                            <input type="text" id="edit-address" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>No HP</label>
                            <input type="text" id="edit-no_hp" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Rumah Sakit</label>
                            <select id="edit-hospital_id" class="form-select" required>
                            <option value="">-- Pilih Rumah Sakit --</option>
                            @foreach($hospitals as $hospital)
                                <option value="{{ $hospital->id }}">{{ $hospital->name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </div>
            </form>
        </div>
    </div>


</body>
</html>
