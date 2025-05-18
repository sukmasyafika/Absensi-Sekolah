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
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="row justify-content-center w-100">
            <div class="col-xl-10 col-lg-12 col-md-9">
                <div class="card o-hidden border-1 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                                <img src="<?= base_url('assets/img/lock.jpg'); ?>"
                                    alt="Login Image"
                                    class="img-fluid h-100"
                                    style="object-fit: cover;">
                            </div>

                            <div class="col-lg-6 d-flex align-items-center">
                                <div class="p-4 w-100">
                                    <div class="text-center mb-4">
                                        <h1 class="h4 text-gray-900 fw-bold">Welcome Back!</h1>
                                    </div>

                                    <?= view('Myth\Auth\Views\_message_block') ?>

                                    <form action="<?= base_url('login'); ?>" method="post" class="user">
                                        <?= csrf_field() ?>

                                        <div class="form-group mb-3">
                                            <input type="email" name="login" class="form-control form-control-user <?php if (session('errors.login')) : ?>is-invalid<?php endif ?>" id="login" placeholder="Enter Your Email">
                                            <div class="invalid-feedback">
                                                <?= session('errors.login') ?>
                                            </div>
                                        </div>
                                        <div class="form-group mb-3">
                                            <input type="password" name="password" class="form-control form-control-user  <?php if (session('errors.password')) : ?>is-invalid<?php endif ?>" id="password" placeholder="Password">
                                            <div class="invalid-feedback">
                                                <?= session('errors.password') ?>
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            <i class="fas fa-sign-in-alt me-2"></i>Login
                                        </button>
                                    </form>

                                    <div class="text-center mt-3">
                                        <a class="fw-bold text-decoration-none" href="<?= site_url('register'); ?>">Create an Account!</a>
                                    </div>

                                    <hr class="my-3 border-primary ">

                                    <div class="text-center">
                                        <p>Follow us on</p>
                                        <a href="#" class="mx-2 text-decoration-none text-primary" title="Instagram">
                                            <i class="bi bi-instagram fs-4"></i>
                                        </a>
                                        <a href="#" class="mx-2 text-decoration-none text-primary" title="Facebook">
                                            <i class="bi bi-facebook fs-4"></i>
                                        </a>
                                        <a href="#" class="mx-2 text-decoration-none text-primary" title="Twitter">
                                            <i class="bi bi-twitter fs-4"></i>
                                        </a>
                                        <a href="#" class="mx-2 text-decoration-none text-primary" title="GitHub">
                                            <i class="bi bi-github fs-4"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
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