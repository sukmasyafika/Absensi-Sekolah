<!DOCTYPE html>
<html lang="en">

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
<meta name="author" content="">

<title><?= $title; ?> | SMK N 5</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<!-- icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<link href="<?= base_url('/assets/vendor/fontawesome-free/css/all.min.css'); ?>" rel="stylesheet" type="text/css">

<link
  href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
  rel="stylesheet">

<!-- Css-->
<link href="<?= base_url('/assets/css/sb-admin-2.min.css'); ?>" rel="stylesheet">

<!-- chart js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- datatabel -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">

</head>

<body id="page-top">
  <div id="wrapper">

    <?= $this->include('layout/sidebar'); ?>

    <div id="content-wrapper" class="d-flex flex-column">
      <!-- Main Content -->
      <div id="content">

        <?= $this->include('layout/navbar'); ?>

        <?= $this->renderSection('admin-content'); ?>

      </div>
      <!-- End Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white border mt-5">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; USTJ FIKOM 2025</span>
          </div>
        </div>
      </footer>
      <!-- End  Footer -->

    </div>
  </div>

  <!-- Scroll Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= base_url('logout') ?>">Logout</a>
        </div>
      </div>
    </div>
  </div>


  <!-- js-->
  <script src="<?= base_url('/assets/vendor/jquery/jquery.min.js'); ?>"></script>
  <script src="<?= base_url('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js'); ?>"></script>
  <script src="<?= base_url('/vendor/jquery-easing/jquery.easing.min.js'); ?>"></script>
  <script src="<?= base_url('/assets/js/sb-admin-2.min.js'); ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
  <script src=" <?= base_url('/assets/vendor/datatables/jquery.dataTables.min.js'); ?> "></script>
  <script src="<?= base_url('/assets/vendor/datatables/dataTables.bootstrap4.min.js'); ?> "></script>
  <script src=" <?= base_url('/assets/js/demo/datatables-demo.js'); ?> "></script>
  <script src=" <?= base_url('/assets/js/script.js'); ?> ">
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- my js -->
  <script src="<?= base_url('assets/js/myscript.js'); ?>"></script>

</body>

</html>