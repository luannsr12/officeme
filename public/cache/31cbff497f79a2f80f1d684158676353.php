<aside class="bg-white sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 " id="sidenav-main">
    <div class="sidenav-header text-center">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/soft-ui-dashboard/pages/dashboard.html " target="_blank">
        <img src="<?= APP_URL; ?>/public/assets/img/default-logo.png" class="navbar-brand-img h-100" alt="main_logo">
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link p_dashboard" href="<?= APP_URL; ?>/p/dashboard">
            <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="fa fa-dashboard"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php if(is_admin()){ ?>
          
          <li class="nav-item"> 
            <a class="nav-link p_customers" href="<?= APP_URL; ?>/p/customers">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-users"></i>
              </div>
              <span class="nav-link-text ms-1">Usuários</span>
            </a>
          </li>
        
          <li class="nav-item">
            <a class="nav-link p_plataforms p_setting_plataforms p_commands_plataforms p_command_edit p_command_buttons p_payment_setting p_gateways_payment" href="<?= APP_URL; ?>/p/plataforms">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-desktop"></i>
              </div>
              <span class="nav-link-text ms-1">Plataformas</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link p_financial" href="<?= APP_URL; ?>/p/financial">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-wallet"></i>
              </div>
              <span class="nav-link-text ms-1">Financeiro</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link p_gateways p_gateways_edit" href="<?= APP_URL; ?>/p/gateways">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-brands fa-amazon-pay"></i>
              </div>
              <span class="nav-link-text ms-1">Gateways</span>
            </a>
          </li>
        

          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Automação</h6>
          </li>

          <li class="nav-item">
            <a class="nav-link  " href="#">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa-solid fa-envelope-circle-check"></i>
              </div>
              <span class="nav-link-text ms-1">Email</span>
            </a>
          </li>
  
          <li class="nav-item mt-3">
            <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Outros</h6>
          </li>
  

          <li class="nav-item">
            <a class="nav-link  " href="#">
              <div class="icon icon-shape icon-sm shadow border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                <i class="fa fa-cogs"></i>
              </div>
              <span class="nav-link-text ms-1">Configurações</span>
            </a>
          </li>

        <?php } ?>
        
      </ul>
    </div>

    
  </aside><?php /**PATH C:\wamp64\www\workspace\jobs\balancebet\public\views/inc/sidebar.blade.php ENDPATH**/ ?>