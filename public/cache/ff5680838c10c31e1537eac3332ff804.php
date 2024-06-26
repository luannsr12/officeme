<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="#" >
        <span class="ms-1 font-weight-bold">Vendedores</span>
        <br>
        <small style="font-size:9px;" >
            Clique sobre o Vendedor para edita-lo ou remove-lo
        </small>
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav" id="listSales">


      </ul>
    </div>
    <div class="sidenav-footer mx-3 ">
      <a class="btn bg-gradient-success mt-3 w-100" href="javascript:addSales();">Adicionar <i class="fa fa-plus"></i></a>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
           
          <h6 class="font-weight-bolder mb-0">Whatsapp Sender</h6>
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
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold responsive-text">Vendedores</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($nSales); ?>

                    </h5>
                    <small style="font-size: 12px;" >&nbsp;</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-users text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Listas de contatos</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($numLists); ?>

                    </h5>
                    <small style="font-size: 12px;" >&nbsp;</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-box text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-2 col-md-3 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Total de contatos</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($numContatcs); ?>

                    </h5>
                    <small style="font-size: 12px;" >&nbsp;</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-whatsapp text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Campanhas ativas</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($activesC); ?>

                    </h5>
                    <small style="font-size: 12px;" >&nbsp;</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-reply text-lg opacity-10" aria-hidden="true"></i>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 col-sm-4 col-6 pb-2">
          <div class="card">
            <div class="card-body p-3">
              <div class="row">
                <div class="col-8">
                  <div class="numbers">
                    <p class="text-sm mb-0 text-capitalize font-weight-bold text-responsive">Respostas</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($replysCampaign); ?>

                    </h5>
                    <small style="font-size: 12px;" >Da última campanha</small>
                  </div>
                 
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-reply text-lg opacity-10" aria-hidden="true"></i>
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
                    <h5 class="font-weight-bolder">Whatsapp Sender</h5>
                    <p class="mb-5">Para enviar campanhas, clique no botão abaixo para se conectar ao Whatsapp</p>
                    <button disabled="true" onclick="loadQrcode(<?php echo e($isDevice); ?>);" class="btnLoadQr btn btn-sm bg-gradient-success" >
                        Carregar QrCode <i class="fa fa-qrocde"></i>
                    </button>
                  </div>
                </div>
                <div class="col-lg-5 ms-auto text-center mt-5 mt-lg-0">
                  <div class="bg-gradient-success border-radius-lg h-100">
                    <img src="public/assets/img/shapes/waves-white.svg" class="position-absolute h-100 w-50 top-0 d-lg-block d-none" alt="waves">
                    <div class="position-relative d-flex align-items-center justify-content-center h-100">
                      <img class="w-100 position-relative z-index-2 p-1" style="width: 200px!important;" src="public/assets/img/illustrations/icon-whatsapp.webp" alt="rocket">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5">
          <div class="card h-100 p-3">
            <div class="overflow-hidden position-relative border-radius-lg bg-cover h-100" style="background-image: url('public/assets/img/illustrations/bg-wpp.png');">
              <span class="mask bg-gradient-dark"></span>
              <div class="card-body position-relative z-index-1 d-flex flex-column h-100 p-3">
                <h5 class="text-white font-weight-bolder pt-2">Sua última campanha</h5>
                <p class="text-white">
                    <ul class="text-white">
                        <li>Enviados: <?php echo e($sendsCampaign); ?> Mensagens</li>
                        <li>Entregues: <?php echo e($deliveredCampaign); ?> Mensagens</li>
                        <li>Respondidas: <?php echo e($replysCampaign); ?> Mensagens</li>
                    </ul>
                </p>
                <a class="text-white text-sm font-weight-bold mb-0 icon-move-right mt-auto" href="javascript:modalCampanha();">
                  Ver mais
                  <i class="fas fa-arrow-right text-sm ms-1" aria-hidden="true"></i>
                </a>
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
                  <h6>Listas de contatos</h6>

                  <div class="btn-groups">
                    <button class="btn bg-gradient-success" onclick="$('#modalAddList').modal('show');" >
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
                 <div class="col-md-6">
                 <h6>Horários de envio</h6>
                        <button class="btn btn-sm bg-gradient-success" onclick="btnAddHourIptn();" >
                            Add <i class="fa fa-plus" ></i>
                        </button>
                 </div>
                 <div class="col-md-6">
                     <label for="">Quantidade</label>
                     <input onkeyup="saveQtdperH();" id="qtd_per_hour" type="text" value="<?php echo e(option('qtd_send_hours')); ?>" class="form-control form-control-sm" placeholder="0" >
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
        <button type="button" class="btn bg-gradient-success" id="btnAddList" >Adicionar</button>
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
        <button type="button" class="btn bg-gradient-success" onclick="createCampaignModal();" >Criar nova campanha</button>
      </div>
    </div>
  </div>
</div>


</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\wpp-sales\public\views/dashboard.blade.php ENDPATH**/ ?>