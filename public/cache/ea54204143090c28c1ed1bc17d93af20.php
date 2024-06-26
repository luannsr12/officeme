<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">

<body class="g-sidenav-show  bg-gray-100">

  <!-- sidebar -->
  <?php echo $__env->make('inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <main class="pt-3 main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="bg-white navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
      navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb ">

          <h6 class="font-weight-bolder mb-0">
            <?= APP_NAME; ?>
          </h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">

            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">


            <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-success btn-sm mb-0 me-3" href="<?= APP_URL; ?>/logout">Sair <i
                  style="font-size:14px;" class="fa fa-power-off"></i> </a>
            </li>


            <li class="nav-item p-3 d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>

            <li class="nav-item pe-2 d-flex align-items-center">
              <a href="<?= APP_URL; ?>/settings/profile" class="nav-link text-body p-0">
                <i class="fa fa-cog cursor-pointer"></i>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4">

      <div class="row mb-3">
        <div class="col-md-12">
          <h3 class="text-secondary">
            Lista dos grupos separados por cada bot
          </h3>
          <p>
            Clique sobre o bot desejado para vizualizar os grupos.
          </p>
        </div>
      </div>


      <div class="row" id="list-groups-bot">

        <div class="col-lg-12 col-12 col-md-12 text-center">
          <div class="card bg-white">
            <div class="card-body">
              <h3>Você não possui bots cadastrados.</h3>
              <p>
                Cadastre um bot e depois volte aqui para buscar os grupos que o bot pertence.
              </p>
              <a href="<?= APP_URL; ?>/p/bots" class="btn bg-gradient-primary">Cadastrar um bot</a>
            </div>
          </div>
        </div>

      </div>


    </div>
  </main>


  <!-- footer -->
  <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <script
    src="<?= APP_URL; ?>/public/assets/js/groups.js?v=<?= filemtime(BASEDIR . '/public/assets/js/groups.js'); ?>"></script>

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/groups.blade.php ENDPATH**/ ?>