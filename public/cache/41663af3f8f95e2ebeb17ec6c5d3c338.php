<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">

<body class="g-sidenav-show  bg-gray-100">

   <!-- sidebar -->
   <?php echo $__env->make('inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

  <main class="pt-3 main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="bg-white navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb ">
           
          <h6 class="font-weight-bolder mb-0"><?= APP_NAME; ?></h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
             
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">


            <li class="nav-item d-flex align-items-center">
              <a class="btn btn-outline-success btn-sm mb-0 me-3"  href="<?= APP_URL; ?>/logout">Sair <i style="font-size:14px;" class="fa fa-power-off"></i> </a>
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
      <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card bg-white">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold responsive-text">Usuários</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid fa-users text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card bg-white">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Plataformas</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid fa-desktop text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card bg-white">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Comissões este mês</p>
                    <h5 class="font-weight-bolder mb-0" id="card_value_dash">
                      R$ 0,00
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid fa-chart-line text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card bg-white">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Comissões hoje</p>
                    <h5 class="font-weight-bolder mb-0">
                      R$ 1,00
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa-solid fa-chart-pie text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

     

      <div class="row mt-4">
        <div class="col-lg-5 mb-lg-0 mb-4">
          <div class="card z-index-2 bg-white">
            <div class="card-body p-3">
              <div class="bg-gradient-primary border-radius-lg py-3 pe-1 mb-3">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
              <h6 class="ms-2 mt-4 mb-0">Atividades dos usuários</h6>
              <p class="text-sm ms-2"> <span id="direction_percent_news_customers" > </span> novos clientes este mês</p>
              <div class="container border-radius-lg">
                <div class="row">
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-user"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Novos</p>
                    </div>
                    <h4 class="font-weight-bolder" id="newsCustomers" >0</h4>
                    <div class="progress w-75">
                      <div id="newsCustomers_progress" class="progress-bar bg-gradient-primary" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-info text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-refresh"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Renovações</p>
                    </div>
                    <h4 class="font-weight-bolder" id="renovatedsCustomers">0</h4>
                    <div class="progress w-75">
                      <div id="renovatedsCustomers_progress" class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-wallet"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Vendas</p>
                    </div>
                    <h4 class="font-weight-bolder" id="valueThisMonth" >0,00</h4>
                    <div class="progress w-75">
                      <div id="valueThisMonth_progress" class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                   
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="card z-index-2 bg-white">
            <div class="card-header pb-0 bg-white">
              <h6>Comissões e resgates</h6>
              <p class="text-sm">
                <i class="fa fa-arrow-up text-success"></i>
                <span class="font-weight-bold">4% mais</span> que março
              </p>
            </div>
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas" height="300"></canvas>
              </div>
            </div>
          </div>
        </div>
      </div>



    </div>
  </main>
  

<!-- footer -->
<?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

 
 
</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\balancebet\public\views/dashboard.blade.php ENDPATH**/ ?>