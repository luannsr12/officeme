<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">
<input type="hidden" id="botid" value="<?php echo e($bot->id); ?>">
<input type="hidden" id="gateway" value="<?php echo e($gateway); ?>">
<input type="hidden" id="is-save" value="1">

<style>

     .col-lg-5{
        width: 49.666667;
     }

    <?php if($payment_settings->$gateway->enable == '1'){ echo '.hide-not-enable-gateway{ display:block; }'; } ?>
    <?php if($payment_settings->$gateway->split->enable == '1'){ echo '.hide-enable-split{ display:block; }'; } ?>
</style>

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
                <div class="col-md-6 col-6">
                    <a href="<?= APP_URL; ?>/p/bots/settings/gateways/<?php echo e($bot->id); ?>" class="btn bg-gradient-primary w-100 w-lg-50" > <i class="fa fa-arrow-left"></i>  Voltar</a>
                 </div>
            </div>

            <input type="hidden" name="<?php echo e($gateway); ?>[split][access_token]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->split->access_token); ?>" >
            <input type="hidden" name="<?php echo e($gateway); ?>[split][expire_access_token]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->split->expire_access_token); ?>" >
            <input type="hidden" name="<?php echo e($gateway); ?>[split][refresh_token]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->split->refresh_token); ?>" >
            <input type="hidden" name="<?php echo e($gateway); ?>[split][pin][expire]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->split->pin->expire); ?>" >
            <input type="hidden" name="<?php echo e($gateway); ?>[split][pin][number]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->split->pin->number); ?>" >
            <input type="hidden" name="<?php echo e($gateway); ?>[title]" class="payment-setting" value="<?php echo e($payment_settings->$gateway->title); ?>" >
            
            <div class="row">

                <div class="col-md-12">
                    <div class="card bg-white">
                        <div class="card-body">

                            <div class="row">

                            <div class="col-md-12">
                                <p class="info-not-save" style="display:none;" >
                                    <i class="fa-solid fa-warning"></i> Atenção, você deve salvar antes de sair desta pagina.
                                </p>
                            </div>

                            <div class="col-md-12">
                                <h3><?php echo e($payment_settings->$gateway->title); ?> <span class="status_gateway" ><?php if($payment_settings->$gateway->enable){ echo '<span class="badge bg-gradient-success" >Ligado</span>'; }else{ echo '<span class="badge bg-gradient-danger" >Desligado</span>'; } ?></span> </h3>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="">Ativar <?php echo e($payment_settings->$gateway->title); ?>?</label>
                                    <select onchange="changeEnableGateway();" name="<?php echo e($gateway); ?>[enable]" id="enable_gateway" class="form-control payment-setting" >
                                        <option <?php if($payment_settings->$gateway->enable){ echo 'selected'; } ?> value="1" >Sim</option>
                                        <option <?php if(!$payment_settings->$gateway->enable){ echo 'selected'; } ?> value="0" >Não</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4 hide-not-enable-gateway">
                                <div class="form-group">
                                    <label for="">Access Token</label>
                                    <input placeholder="Access Token" id="command_command" name="<?php echo e($gateway); ?>[data][access_token]" type="text"
                                        class="form-control payment-setting" value="<?php echo e($payment_settings->$gateway->data->access_token); ?>" >
                                    <small style="font-size: 11px;">Informe aqui o access token principal</small>
                                </div>
                            </div>

                            <div class="col-md-4 hide-not-enable-gateway">
                                <div class="form-group">
                                    <label for="">Ativar Split?</label>
                                    <select onchange="changeSplitEnable();" name="<?php echo e($gateway); ?>[split][enable]" id="split_enable" class="form-control payment-setting" >
                                        <option <?php if($payment_settings->$gateway->split->enable){ echo 'selected'; } ?> value="1" >Sim</option>
                                        <option <?php if(!$payment_settings->$gateway->split->enable){ echo 'selected'; } ?> value="0" >Não</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 col-lg-12 col-12 mt-3 hide-not-enable-gateway">
                                <div class="row" style="justify-content: space-between;">


                                    <div class="col-md-12 col-12 col-lg-6">
                                       <div class="row p-2" >
                                           <div class="col-md-12" style="background-color: #ededed;border-radius: 10px;">
                                                <div class="row p-4" >
                                                   <div class="col-md-12 col-lg-12 col-12">
                                                        <h5> <i class="fa-brands fa-pix"></i> Pagamentos por pix</h5>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Aceitar pix?</label>
                                                            <select onchange="changeEnablePix();" name="<?php echo e($gateway); ?>[methods][pix][enable]" id="enable_pix" class="form-control payment-setting" >
                                                                <option <?php if($payment_settings->$gateway->methods->pix->enable == '1'){ echo 'selected'; } ?> value="1" >Sim</option>
                                                                <option <?php if($payment_settings->$gateway->methods->pix->enable == '0'){ echo 'selected'; } ?> value="0" >Não</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label for="">Nome metodo</label>
                                                            <input placeholder="Pagamento com pix" name="<?php echo e($gateway); ?>[methods][pix][text]" type="text"
                                                                class="form-control payment-setting input-text-pix" value="<?php echo e($payment_settings->$gateway->methods->pix->text); ?>" >
                                                        </div>
                                                    </div>
                                                </div>
                                           </div>
                                       </div>
                                    </div>


                                    <div class="col-md-12 col-12 col-lg-6">
                                       <div class="row  p-2">
                                           <div class="col-md-12" style="background-color: #ededed;border-radius: 10px;" >
                                            <div class="row p-4"  >
                                                <div class="col-md-12 col-lg-12 col-12">
                                                    <h5> <i class="fa-solid fa-credit-card"></i> Pagamentos por Cartão</h5>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Aceitar Cartão?</label>
                                                        <select onchange="changeEnableCreditCard();" name="<?php echo e($gateway); ?>[methods][link][enable]" id="enable_credit_card" class="form-control payment-setting" >
                                                            <option <?php if($payment_settings->$gateway->methods->link->enable == '1'){ echo 'selected'; } ?> value="1" >Sim</option>
                                                            <option <?php if($payment_settings->$gateway->methods->link->enable == '0'){ echo 'selected'; } ?> value="0" >Não</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="">Nome metodo</label>
                                                        <input placeholder="Pagamento com pix" name="<?php echo e($gateway); ?>[methods][link][text]" type="text"
                                                            class="form-control payment-setting input-text-credit-card" value="<?php echo e($payment_settings->$gateway->methods->link->text); ?>" >
                                                    </div>
                                                </div>
                                            </div>
                                           </div>
                                       </div>
                                    </div>


                                </div>
                            </div>

                
                            <div class="col-md-12 col-12 col-lg-12 mt-3 hide-enable-split hide-not-enable-gateway">

                                <div class="row p-3 pt-4" style="background-color: #ededed;border-radius: 10px;">

                                <div class="col-md-12">
                                    <h5><i class="fa-solid fa-arrows-split-up-and-left"></i> Configurações do split</h5>
                                </div>

                                   <div class="col-md-8">
                                        <label for="">Link conectar ao split</label>
                                        <div class="input-group mb-sm-3 mb-lg-0 mb-md-0 group-btn-link-split">
                                            <input value="<?= APP_URL; ?>/connect/mercadopago/split/<?php echo e($bot->id); ?>/<?php echo e($payment_settings->$gateway->split->pin->number); ?>" <?php if(!$payment_settings->$gateway->split->enable){ echo 'disabled'; } ?> type="text" id="link_split" class="input-button-group-right form-control" placeholder="Link conectar ao split" aria-label="Link conectar ao split" aria-describedby="basic-addon2">
                                            <div class="btn-group" >
                                                <button <?php if(!$payment_settings->$gateway->split->enable){ echo 'disabled'; } ?> onclick="generateLinkSplit();" class="btn-button-group-center btn bg-gradient-primary" type="button"> <i class="fa-solid fa-refresh"></i> Gerar novo link</button>
                                                <button <?php if(!$payment_settings->$gateway->split->enable){ echo 'disabled'; } ?> onclick="copy('link_split');" class="btn-button-group-right btn bg-gradient-primary" type="button"> <i class="fa-solid fa-copy"></i> Copiar</button>
                                            </div>
                                        </div>

                                        <?php if($payment_settings->$gateway->split->pin->is_expired && $payment_settings->$gateway->split->enable){ ?>
                                            <p class="info-warning-small" >
                                                <i class="fa-solid fa-warning"></i> Link expirado, gere um novo.
                                            </p>
                                        <?php }else{ ?>
                                            <small class="input-group mb-sm-3 mb-lg-0 mb-md-0 group-btn-link-split" >O link tem válidade de 1 hora após ser gerado</small>
                                        <?php } ?>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="">% Comissão</label>
                                            <input placeholder="0%" id="" name="<?php echo e($gateway); ?>[split][percent]" type="number"
                                                class="form-control payment-setting" value="<?php echo e($payment_settings->$gateway->split->percent); ?>" >
                                            <small style="font-size: 11px;">Informe aqui a porcentagem de ganho de quem conectou</small>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Existe alguém conectado no split ?</label>
                                            <?php if(strlen($payment_settings->$gateway->split->access_token) <= 0){ ?>
                                                <p>
                                                    <span style="font-size:15px!important;" class="w-100 badge bg-gradient-danger" >
                                                          Ninguém conectado
                                                    </span>
                                                </p>
                                            <?php }else{ ?>
                                                <p>
                                                    <span style="font-size:15px!important;" class="w-100 text-center badge bg-gradient-success" >
                                                         Existe alguém Conectado
                                                    </span>
                                                    <br />
                                                    <small style="cursor:pointer;color:#640ff9;" > <i class="fa-solid fa-plug-circle-xmark"></i> Desconectar</small>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>


                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="">Expiração Access Token Split</label>
                                            <?php if($expire_split_token == '1'){ ?>
                                                <p>
                                                    <span style="font-size:15px!important;" class="w-100 text-center badge bg-gradient-danger" >
                                                      <i class="fa-solid fa-warning"></i> Expirado!
                                                    </span>
                                                    <br />
                                                    <small style="cursor:pointer;color:#640ff9;" > <i class="fa-solid fa-refresh"></i> Renovar</small>
                                                </p>
                                            <?php }else if($expire_split_token == '0' && (strlen((string)$payment_settings->$gateway->split->expire_access_token) > 0)){ ?>
                                                <p>
                                                    <span style="font-size:15px!important;" class="w-100 text-center badge bg-gradient-warning" >
                                                      <?= date('d/m/Y H:i:s', $payment_settings->$gateway->split->expire_access_token); ?>
                                                    </span>
                                                     
                                                </p>
                                            <?php }else if((string)$payment_settings->$gateway->split->expire_access_token == ''){ ?>
                                                <p>
                                                    <span style="font-size:15px!important;" class="w-100 text-center badge bg-gradient-danger" >
                                                      Ninguém conectado
                                                    </span>
                                                </p>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                             
                            <div class="mt-4 col-md-12 text-right d-flex justify-content-left">
                                <button type="button" class="btn bg-gradient-primary w-100 w-lg-50" id="btnSavePaymentSettings" onclick="saveGateway();" >Salvar</button>
                            </div>

                            </div>

                        </div>
                    </div>
                </div>

            </div>


        </div>
    </main>


    <!-- footer -->
    <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script
        src="<?= APP_URL; ?>/public/assets/js/payment.js?v=<?= filemtime(BASEDIR . '/public/assets/js/payment.js'); ?>"></script>
 

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/payment_setting.blade.php ENDPATH**/ ?>