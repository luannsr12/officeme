<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">
<input type="hidden" id="botid" value="<?php echo e($bot->id); ?>">

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
                <a class="btn bg-gradient-primary" href="<?= APP_URL;?>/p/bots/add/command/new/<?php echo e($bot->id); ?>" > <i class="fa fa-plus"></i> Adicionar Comando</a>
            </div>
        </div>

        <div class="row" id="listBotCommands">
            
           
        </div>


    </div>
  </main>
  

<!-- footer -->
<?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<script src="<?= APP_URL; ?>/public/assets/js/bots.js?v=<?= filemtime(BASEDIR . '/public/assets/js/bots.js'); ?>"></script>

<!-- Modal -->
<div class="modal fade" id="modalAddBotCommand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar novo comando ao bot</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

          <input type="hidden" name="" id="command_id" value="0" >

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Comando</label>
              <input type="text" id="command_command" placeholder="/comando" class="form-control">
              <small style="font-size: 11px;" >32 caracteres. Pode conter apenas letras minúsculas do inglês, dígitos e sublinhados.</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Descrição</label>
              <input type="text" id="command_description" placeholder="Descrição do comando" class="form-control">
              <small style="font-size: 11px;" >Descrição do comando; 1-256 caracteres.</small>
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Visível no menu?</label>
              <select name="" id="command_is_menu" class="form-control" >
                <option value="1" >Sim</option>
                <option value="0" >Não</option>
              </select>
            </div>
          </div>
    

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Tipo de resposta</label>
              <select name="" id="command_type" class="form-control" >
                <option value="message" >Texto</option>
                <option value="groups" >Listar Grupo(s)</option>
              </select>
            </div>
          </div>
    
          
          <div class="col-md-12">
            <div class="form-group">
              <label for="">Mensagem </label>
               <textarea rows="5" name="" class="form-control" id="command_response" placeholder="Mensagem aqui" ></textarea>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <label for="">Botões </label>
               <textarea rows="5" name="" class="form-control" id="command_response" placeholder="Mensagem aqui" ></textarea>
            </div>
          </div>


        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn bg-gradient-primary" id="btnAddBotCommand" onclick="addCommandBot();" >Adicionar</button>
      </div>
    </div>
  </div>
</div>

  

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/commands_bot.blade.php ENDPATH**/ ?>