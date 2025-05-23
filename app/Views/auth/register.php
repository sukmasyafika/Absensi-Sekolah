<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Login | SMK N 5</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
  <link href="<?= base_url('assets/css/sb-admin-2.min.css'); ?> " rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

</head>

<body>
  <div class="container">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
      <div class="col-lg-8 col-md-8">
        <div class="card shadow-lg border-1 rounded">
          <div class="card-body p-5">
            <h1 class=" text-center fw-bold h4 text-gray-900 mb-5">Create an Account!</h1>

            <?= view('Myth\Auth\Views\_message_block') ?>

            <form action="<?= url_to('register') ?>" method="post" class="user">
              <?= csrf_field() ?>

              <div class="mb-3">
                <label for="username" class="form-label fw-semibold"><i class="bi bi-person-fill me-2"></i>Username</label>
                <input type="text" name="username" id="username"
                  class="form-control form-control-user <?php if (session('errors.username')) : ?>is-invalid<?php endif ?>"
                  value="<?= old('username') ?>" placeholder="Masukkan username" required>
              </div>

              <div class="mb-3">
                <label for="email" class="form-label fw-semibold"><i class="bi bi-envelope-fill me-2"></i>Email</label>
                <input type="email" name="email" id="email"
                  class="form-control form-control-user <?php if (session('errors.email')) : ?>is-invalid<?php endif ?>"
                  value="<?= old('email') ?>" placeholder="contoh@email.com" required>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="password" class="form-label fw-semibold"><i class="bi bi-lock-fill me-2"></i>Password</label>
                  <input type="password" name="password" id="password"
                    class="form-control form-control-user <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>"
                    placeholder="********" required>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="pass_confirm" class="form-label fw-semibold"><i class="bi bi-shield-lock-fill me-2"></i>Konfirmasi Password</label>
                  <input type="password" name="pass_confirm" id="pass_confirm"
                    class="form-control form-control-user <?php if (session('errors.pass_confirm')) : ?>is-invalid<?php endif ?>"
                    placeholder="********" required>
                </div>
              </div>

              <div class="d-flex justify-content-between align-items-center mt-4">
                <a href="<?= site_url('login'); ?>" class="text-decoration-none fw-semibold text-primary">
                  <i class="bi bi-box-arrow-in-left me-1"></i>Sudah punya akun? Login
                </a>
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-check-circle-fill me-1"></i>Daftar Sekarang
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>

  <script src="<?= base_url('assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('assets/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?= base_url('assets/js/sb-admin-2.min.js'); ?>"></script>
</body>


</html>