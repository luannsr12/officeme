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
          <h3 class="text-white">
            Gateways de pagamentos
          </h3>
        </div>
      </div>


      <div class="row" >

        <div class="col-lg-2 col-6 col-md-6">
            <div class="card bg-white">
                <div class="p-2 pb-0 mb-0 m-0 text-center card-head">
                    <h5 class="text-white" >SuitPay</h5>
                </div>
                <div class="pt-0 mt-0 text-center card-body">
                    <img width="100%" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSu5d-7Sy-9mH8NNPsoSWIghdHK8sUvKSG2ZA&s" alt="..." class="img-thumbnail">
                    <a href="<?= APP_URL; ?>/p/gateways/edit/suitpay" class="w-100 mt-2 btn bg-gradient-primary" > <i class="fa fa-cogs"></i> Configurar</a> 
                </div>
            </div>
        </div>

        
        <div class="col-lg-2 col-6 col-md-6">
            <div class="card bg-white">
                <div class="p-2 pb-0 mb-0 m-0 text-center card-head">
                    <h5 class="text-white" >Asaas</h5>
                </div>
                <div class="pt-0 mt-0 text-center card-body">
                    <img width="100%" src="https://s3.amazonaws.com//beta-img.b2bstack.net/uploads/production/product/product_image/580/logo-asaas-azul-.png" alt="..." class="img-thumbnail">
                    <a href="<?= APP_URL; ?>/p/gateways/edit/asaas" class="w-100 mt-2 btn bg-gradient-primary" > <i class="fa fa-cogs"></i> Configurar</a> 
                </div>
            </div>
        </div>

      </div>


    </div>
  </main>


  <!-- footer -->
  <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\balancebet\public\views/admin/gateways/list.blade.php ENDPATH**/ ?>