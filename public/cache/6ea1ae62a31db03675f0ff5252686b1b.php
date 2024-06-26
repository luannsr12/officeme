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
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold responsive-text">Clientes</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Ativos</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Inadimplentes</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa fa-user text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-3 col-md-4 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Planos</p>
                    <h5 class="font-weight-bolder mb-0">
                      1
                    </h5>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                    <i class="fa fa-box text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-lg-6">
                  <div class="d-flex flex-column h-100">
                    <p class="mb-1 pt-2 text-bold">Você está: <span id="statusWpp" class="badge bg-gradient-secondary" >Verificando status...</span> <span class="badge bg-danger logoutWpp" style="display:none;cursor:pointer;" > Desconectar <i class="fa fa-power-off"></i> </span> </p>
                    <h5 class="font-weight-bolder">Api Whatsapp</h5>
                    <p class="mb-5">Conecte-se ao whatsapp para enviar cobranças automáticas</p>
                    <button disabled="true" onclick="loadQrcode(<?php echo e($isDevice); ?>);" class="btnLoadQr btn btn-sm bg-gradient-primary" >
                        Carregar QrCode <i class="fa fa-qrocde"></i>
                    </button>
                  </div>
                </div>
                <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                  <div class="bg-gradient-primary border-radius-lg h-100">
                    <img src="<?= APP_URL; ?>/public/assets/img/shapes/waves-white.svg" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                    <div class="position-relative d-flex align-items-center justify-content-center h-100">
                      <img class="w-100 position-relative z-index-2 p-1" style="width: 200px!important;" src="<?= APP_URL; ?>/public/assets/img/rocket-white.png" alt="rocket">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-gradient-primary bg-cover h-100" style="background-position: top!important;background:url('https://png.pngtree.com/thumb_back/fh260/background/20211118/pngtree-financial-technology-data-graph-image_908921.jpg');" >
              <span class="mask bg-gradient-primary " ></span>  
            <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                <h5 class="text-white font-weight-bolder pt-2">Financeiro <i style="float:right;cursor:pointer;" data-view='1' class="view-balance fa fa-eye"></i> </h5>
                <p class="text-white">
                   <div class="row">
                      <div class="col-md-4">
                         <h3 class="text-white" >R$ <span class="balance_view" data-value="200.00" >200.00</span></h3>
                         <span class="text-white"> <i class="text-success fa fa-arrow-up"></i> Entradas em abril </span>
                      </div>
                      
                      <div class="col-md-4">
                        <h3 class="text-white" >R$ <span class="balance_view" data-value="200.00" >200.00</span></h3>
                        <span class="text-white"><i class="text-danger fa fa-arrow-down"></i> Saídas em abril</span> 
                      </div>
                    
                      <div class="col-md-4">
                        <h3 class="text-white" >R$ <span class="balance_view" data-value="200.00" >200.00</span></h3>
                        <span class="text-white"><i class="text-info fa fa-wallet"></i> Saldo líquido</span> 
                      </div>

                   </div>
                </p>
                <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:modalCampanha();">
                  Movimentações
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-4">
        <div class="col-lg-5 mb-lg-0 mb-4">
          <div class="card z-index-2">
            <div class="card-body p-3">
              <div class="bg-gradient-primary border-radius-lg py-3 pe-1 mb-3">
                <div class="chart">
                  <canvas id="chart-bars" class="chart-canvas" height="170"></canvas>
                </div>
              </div>
              <h6 class="ms-2 mt-4 mb-0">Atividades de clientes </h6>
              <p class="text-sm ms-2"> (<span class="font-weight-bolder">+23%</span>) novos clientes este mês</p>
              <div class="container border-radius-lg">
                <div class="row">
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-primary text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-user"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Novos</p>
                    </div>
                    <h4 class="font-weight-bolder">10</h4>
                    <div class="progress w-75">
                      <div class="progress-bar bg-gradient-primary w-60" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-info text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-refresh"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Renovações</p>
                    </div>
                    <h4 class="font-weight-bolder">234</h4>
                    <div class="progress w-75">
                      <div class="progress-bar bg-gradient-info  w-90" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                  <div class="col-4 py-3 ps-0">
                    <div class="d-flex mb-2">
                      <div class="pt-2 icon icon-shape icon-xxs shadow border-radius-sm bg-gradient-warning text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="text-white fa fa-wallet"></i>
                      </div>
                      <p class="text-xs mt-1 mb-0 font-weight-bold">Vendas</p>
                    </div>
                    <h4 class="font-weight-bolder">R$ <span class="balance_view" data-value="200.00" >200.00</span></h4>
                    <div class="progress w-75">
                      <div class="progress-bar bg-gradient-warning w-30" role="progressbar" aria-valuenow="30" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                   
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-7">
          <div class="card z-index-2">
            <div class="card-header pb-0">
              <h6>Movimentações financeiras</h6>
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

      <div class="row my-4">
        <div class="col-lg-8 col-md-6 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Listas de campanhas</h6>

                  <div class="btn-groups">
                    <button class="btn bg-gradient-primary" onclick="$('#modalAddList').modal('show');" >
                        Nova Lista <i class="fa fa-plus"></i>
                    </button>
                  </div>

                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nome</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Contatos</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Campanhas ativas</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Opções</th>
                    </tr>
                  </thead>
                  <tbody id="listsResponse" >
                   
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-md-6">
          <div class="card h-100">
            <div class="card-header pb-0">
             
               <div class="row">
                 <div class="col-md-12">
                      <h6>Horários de cobranças</h6>
                 </div>
                 <div class="col-md-6">
                   <button class="mt-4 btn btn-sm bg-gradient-primary" onclick="btnAddHourIptn();" >
                        novo horário <i class="fa fa-plus" ></i>
                    </button>
                 </div>
                 <div class="col-md-6">
                     <label for="">Quantidade de envio p/hr</label>
                     <input onkeyup="saveQtdperH();" id="qtd_per_hour" type="text" value="<?php echo e(option('qtd_send_hours')); ?>" class="form-control form-control-sm" placeholder="0" >
                     <small style="font-size:10px;" >Máximo de 100 envio por hora</small>
                 </div>
                 <div class="col-md-12">
                   <p style="font-size: 14px;" class="response_edit_hours text-success" ></p>
                   <p style="font-size: 14px;" class="response_edit_hours_error text-danger" ></p>
                 </div>
               </div>
            </div>
            <div class="card-body p-3">
              <div class="timeline timeline-one-side" id="listHours">

             
            
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </main>
  

<!-- footer -->
<?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<!-- Modal -->
<div class="modal fade" id="modalAddList" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Adicionar nova Lista</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

        <input type="hidden" name="" id="id_list" value="0" >

          <div class="col-md-12">
            <div class="form-group">
              <label for="">Nome da lista</label>
              <input type="text" id="name_list" placeholder="Nome da lista" class="form-control">
            </div>
          </div>

          <div class="col-md-6">
            <div class="form-group">
              <label for="">Importar contatos</label>
              <textarea name="" id="contacts_list" placeholder="Fulano de tal;+551199999999
Beltrano de tal;+551199999999" class="form-control" cols="30" rows="10"></textarea>
             <small style="font-size: 11px;color: gray;">Nome ; Numero Whatsapp</small>
            </div>
          </div>

          <div class="col-md-6" >
              <div class="form-group" style="position: relative;">
                <label for="">Conteúdo da mensagem</label>
                <textarea name="" id="message_list" data-emojiable="true" placeholder="Sua mensagem aqui" class="textarea-control form-control" cols="30" rows="10"></textarea>
              </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn bg-gradient-primary" id="btnAddList" >Adicionar</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="modalViewCampaigns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Todas as campanhas desta lista</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">

        <input type="hidden" id="list_id_campaigns" value="0" >

        <div id="listCampaignsModal" class="container">

        </div>

        <div class="pagination mt-3 pagination-success" style="justify-content: right;"></div>
        <div style="float: right;" class="mt-2 total_items_pagination"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
        <button type="button" class="btn bg-gradient-primary" onclick="createCampaignModal();" >Criar nova campanha</button>
      </div>
    </div>
  </div>
</div>


</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\gestorlite\public\views/dashboard.blade.php ENDPATH**/ ?>