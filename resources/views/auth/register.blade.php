<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-4">
        <div class="card shadow">
          <div class="card-header text-center">Register</div>
          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf
              <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" autocomplete="off" required>
              </div>
              <div class="mb-3">
                <label>Username</label>
                <input type="text" name="username" class="form-control" autocomplete="off" required>
              </div>
              <div class="mb-3">
                <label>Email</label>
                <input type="text" name="email" class="form-control" autocomplete="off" required>
              </div>
              <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" autocomplete="off" required>
              </div>
              <button type="submit" class="btn btn-success w-100">Register</button>
            </form>
            <div class="mt-3 text-center">
              <a href="{{ route('login') }}">Sudah punya akun?</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
