<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/whatsapp.css">

<body class="g-sidenav-show  bg-gray-100">

   <input type="hidden" value="<?php echo e($campaign->id); ?>" id="campaign_id">
   <input type="hidden" value="<?php echo e($pagename); ?>" id="pagename">

  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header">
       <a class="btn bg-gradient-success mt-3 w-100" href="<?= APP_URL; ?>/dashboard"><i class="fa fa-arrow-left"></i> Voltar </a>
    </div>
     
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" navbar-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
           
          <h6 class="font-weight-bolder mb-0">Detalhes da campanha #<?php echo e($campaign->id); ?></h6>
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
              <a href="<?= APP_URL; ?>/settings/profile" class="nav-link text-body p-0" >
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
                    <p class="text-sm mb-0 text-capitalize font-weight-bold responsive-text">Mensagens envidas</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($details->messages->sent); ?>

                    </h5>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="<?php echo e($details->percents->sent); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($details->percents->sent); ?>%;"></div>
                    </div>
                    <small><?php echo e($details->percents->sent); ?>%</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-send text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Mensagens entregues</p>
                    <h5 class="font-weight-bolder mb-0">
                       <?php echo e($details->messages->delivered); ?>

                    </h5>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="<?php echo e($details->percents->delivered); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($details->percents->delivered); ?>%;"></div>
                    </div>
                    <small><?php echo e($details->percents->delivered); ?>%</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-check-circle-o text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Mensagens não envidas</p>
                    <h5 class="font-weight-bolder mb-0">
                       <?php echo e($details->messages->error); ?>

                    </h5>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="<?php echo e($details->percents->error); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($details->percents->error); ?>%;"></div>
                    </div>
                    <small><?php echo e($details->percents->error); ?>%</small>
                  </div>
                </div>
                <div class="col-4 text-end">
                  <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                    <i class="fa fa-times-circle-o text-lg opacity-10" aria-hidden="true"></i>
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
                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Mensagens respondidas</p>
                    <h5 class="font-weight-bolder mb-0">
                      <?php echo e($details->messages->replys); ?>

                    </h5>
                    <div class="progress mt-2">
                      <div class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="<?php echo e($details->percents->replys); ?>" aria-valuemin="0" aria-valuemax="100" style="width: <?php echo e($details->percents->replys); ?>%;"></div>
                    </div>
                    <small><?php echo e($details->percents->replys); ?>%</small>
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
     
      <div class="row my-4">
        <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
          <div class="card">
            <div class="card-header pb-0">
              <div class="row">
                <div class="col-lg-6 col-7">
                  <h6>Registros</h6>
                </div>
                
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Destino</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Hora do envio</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mensagem respondida</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Vendedor alocado</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                    </tr>
                  </thead>
                  <tbody id="listMessagesCampaigns" >
                   
                  </tbody>
                 
                </table>
              </div>
            </div>

            <div class="card-footer">
                <div class=" ml-3 col-md-12">
                  <div class="pagination pagination-success mt-3"></div>
                  <div class="mt-2 total_items_pagination"></div>
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
<div class="modal fade" id="modalViewReply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Detalhes</h5>
        <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">

          <div class="col-md-12">
          <div class="page">
              <div class="marvel-device nexus5">
                <div class="top-bar"></div>
                <div class="sleep"></div>
                <div class="volume"></div>
                <div class="camera"></div>
                <div class="screen">
                  <div class="screen-container">
                    <div class="status-bar">
                      <div class="time">
                        10:10
                      </div>
                      <div class="battery">
                        <i class="fa fa-battery"></i>
                      </div>
                      <div class="network">
                        <i class="fa fa-whatsapp"></i>
                      </div>
                      <div class="wifi">
                        <i class="fa fa-wifi"></i>
                      </div>
                      <div class="star">
                        <i class="fa fa-facebook"></i>
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-container">
                        <div class="user-bar">
                          <div class="back">
                            <i class="fa fa-arrow-left"></i>
                          </div>
                          <div class="avatar">
                            <img src="https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.webp" alt="Avatar">
                          </div>
                          <div class="name">
                            <span id="destiny_view" >Seu Whatsapp</span>
                            <span class="status">online</span>
                          </div>
                          <div class="actions more">
                            <i class="zmdi zmdi-more-vert"></i>
                          </div>
                          <div class="actions attachment">
                            <i class="zmdi zmdi-attachment-alt"></i>
                          </div>
                          <div class="actions">
                            <i class="zmdi zmdi-phone"></i>
                          </div>
                        </div>
                        <div class="conversation">
                          <div class="conversation-container">
                            <div class="message sent">
                              What happened last night?
                              <span class="metadata">
                                  <span class="time"></span><span class="tick"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="15" id="msg-dblcheck-ack" x="2063" y="2076"><path d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z" fill="#4fc3f7"/></svg></span>
                              </span>
                            </div>
                            <div class="message received">
                              You were drunk.
                              <span class="metadata"><span class="time"></span></span>
                            </div>
                           
                          </div>
                         
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
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

        <div class="pagination mt-3" style="justify-content: right;"></div>
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

</html><?php /**PATH C:\wamp64\www\workspace\jobs\wpp-sales\public\views/sellers.blade.php ENDPATH**/ ?>