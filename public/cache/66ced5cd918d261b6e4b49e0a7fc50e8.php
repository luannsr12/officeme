<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body style="background-color: #141727;" >
  
  <main class="main-content  mt-0">
    <section>
      <div class="page-header min-vh-75">
        <div class="container">
          <div class="row">
            <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
              <div class="card card-plain mt-8 bg-white">
                <div class="card-header pb-0 text-left bg-transparent">
                  <h3 class="font-weight-bolder" style="color:#17c1e8;"><i class="fa-brands fa-telegram"></i> Conectar minha conta</h3>
                  <p class="mb-0" >Você irá se conectar com sua conta do <?php echo e($gateway->title); ?> para receber sua comissão</p>
                </div>
                <div class="card-body">

                <div class="row">
                    <div class="col-md-12">
                        <ul>
                            <li>
                                Plataforma: <b><?php echo e($gateway->title); ?></b>
                            </li>
                            <li>
                                Bot: <b>@</b><b><?php echo e($bot->username); ?></b>
                            </li>
                            <li>
                                Comissão: <b><?php echo e($payment_settings->$gateway_name->split->percent); ?></b><b>%</b>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12">
                        <p style="font-size: 13px;border-left: 5px solid #17c1e8;padding-left: 10px;">
                            Após se conectar você receberá <span><?php echo e($payment_settings->$gateway_name->split->percent); ?></span><span>%</span> 
                            por cada nova assinatura de grupos que este bot participa
                        </p>
                    </div>
                </div>

                    <div class="text-center">
                      <button type="button" style="background-color: #17c1e8;color: #fff;font-weight: 500!important;font-size: 20px;" id="btnConnectSplit" class="btn w-100 mt-4 mb-0">
                          <i class="fa-solid fa-plug"></i> Conectar
                      </button>
                    </div>

                </div>
                
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>
  </main>
  <!-- footer --> 
  <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/split_payment.blade.php ENDPATH**/ ?>