<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f2f2f2;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            font-family: Arial, sans-serif;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            max-width: 400px;
            width: 100%;
            background-color: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        .social-icons i {
            font-size: 24px;
            margin: 0 10px;
            color: #000;
            transition: color 0.3s;
        }

        .social-icons i:hover {
            color: #0d6efd;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body>

    <main>
        <div class="login-box text-center">
            <h2 class="fw-bold mb-4">LOGIN</h2>

            <form action="<?= site_url('login/auth'); ?>" method="post">
                <?= csrf_field(); ?>

                <div class="mb-3 text-start">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username" id="username" placeholder="Enter your username" required>
                </div>

                <div class="mb-4 text-start">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password" required>
                </div>

                <button type="submit" class="btn btn-primary w-100 mb-3">Login</button>
            </form>

            <hr>

            <p>Ikuti Kami di Media Sosial</p>
            <div class="social-icons">
                <a href="#"><i class="bi bi-facebook"></i></a>
                <a href="#"><i class="bi bi-instagram"></i></a>
                <a href="#"><i class="bi bi-youtube"></i></a>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="sticky-footer bg-secondary mt-5 p-4">
        <div class="container my-auto ">
            <div class="copyright text-center my-auto text-white">
                <span>Copyright &copy; USTJ 2025</span>
            </div>
        </div>
    </footer>
    <!-- End  Footer -->

</body>

</html>