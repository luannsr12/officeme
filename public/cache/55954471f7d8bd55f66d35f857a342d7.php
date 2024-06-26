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

        <div class="row bg-white p-4 mb-4">
            <div class="col-md-12">
                <button class="btn bg-gradient-primary" onclick="$('#modaladdPlataform').modal('show');" > <i class="fa fa-plus"></i> Adicionar plataforma</button>
            </div>
        </div>

      
        <div class="row" id="listPlataforms">
            
           
        </div>


    </div>
  </main>
  

<!-- footer -->
<?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?= APP_URL; ?>/public/assets/js/plataforms.js?v=<?= filemtime(BASEDIR . '/public/assets/js/plataforms.js'); ?>"></script>

<!-- Modal -->
<div class="modal fade" id="modaladdPlataform" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar nova plataforma</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

          <input type="hidden" name="" id="id_bot" value="0" >

          <div class="col-md-12">
            <div class="form-group">
              <label for="">Nome da plataforma</label>
              <input type="text" id="bot_name" placeholder="Nome da plataforma" class="form-control">
            </div>
          </div>

          <!-- <div class="col-md-12">
            <div class="form-group">
              <label for="">Username do Bot</label>
              <input type="text" id="bot_username" placeholder="@username" class="form-control">
            </div>
          </div>
    
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Apikey do Bot</label>
              <input type="text" id="bot_apikey" placeholder="Api key" class="form-control">
            </div>
          </div> -->

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn bg-gradient-primary" id="btnaddPlataform" onclick="addPlataform();" >Adicionar</button>
      </div>
    </div>
  </div>
</div>

  

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\balancebet\public\views/admin/plataforms.blade.php ENDPATH**/ ?>