<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
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
            <a href="#" class="btn btn-success">+ Tambah Data Pasien</a>
        </div>

        <table class="table table-bordered" id="pasien-table">
            <thead class="table-light">
                <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>No HP</th>
                </tr>
            </thead>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        $(function () {
        $('#pasien-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route("pasien.data") }}',
            columns: [
            { data: 'id', name: 'id' },
            { data: 'name', name: 'name' },
            { data: 'address', name: 'address' },
            { data: 'no_hp', name: 'no_hp' }
            ]
        });
        });
    </script>
</body>
</html>
