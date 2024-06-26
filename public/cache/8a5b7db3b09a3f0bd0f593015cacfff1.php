<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">
<input type="hidden" id="command_id" value="<?php if($new) { echo '0';  }else{ echo $command->id; } ?>">
<input type="hidden" id="botid" value="<?php if($new) { echo $bid;  }else{ echo $command->bot_id; } ?>">


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
                    <div class="card bg-white">
                        <a href="<?= APP_URL; ?>/p/bots/settings/commands/<?php echo e($command->bot_id); ?>" class="btn bg-gradient-primary" > <i class="fa fa-arrow-left"></i>  Voltar</a>
                    </div>
                </div>

            </div>


            <div class="row">

                <div class="col-md-12">
                    <div class="card bg-white">
                        <div class="card-body">

                            <div class="row">


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Comando</label>
                                        <input placeholder="/comando" id="command_command" type="text"
                                            class="form-control" value="<?php if(!$new) { echo $command->command; } ?>" >
                                        <small style="font-size: 11px;">32 caracteres. Pode conter apenas letras
                                            minúsculas do inglês, dígitos e sublinhados.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Descrição</label>
                                        <input type="text" id="command_description" placeholder="Descrição do comando"
                                            class="form-control" value="<?php if(!$new) { echo $command->description; } ?>">
                                        <small style="font-size: 11px;">Descrição do comando; 1-256 caracteres.</small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Visível no menu?</label>
                                        <select name="" id="command_is_menu" class="form-control">
                                            <option <?php if(!$new) { if($command->is_menu){ echo 'selected'; } } ?> value="1">Sim</option>
                                            <option <?php if(!$new) { if(!$command->is_menu){ echo 'selected'; } } ?> value="0" >Não</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Tipo de resposta</label>
                                        <select onchange="selectedTypeCommand();" name="" id="command_type" class="form-control">
                                            <option <?php if(!$new) { if($command->type == 'message'){ echo 'selected'; } } ?> value="message">Apenas texto</option>
                                            <option <?php if(!$new) { if($command->type == 'groups'){ echo 'selected'; } } ?> value="groups">Texto e listar Grupo(s)</option>
                                            <option <?php if(!$new) { if($command->type == 'buttons'){ echo 'selected'; } } ?> value="buttons">Texto e Botões</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Mensagem </label>
                                        <textarea rows="5" class="form-control" id="command_response"
                                            placeholder="Mensagem aqui"><?php if(!$new) { echo $command->response; } ?></textarea>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group p-5 text-center">
                                         <button onclick="saveCommandNextButtons(<?php if(!$new) { echo $command->id; }else{ echo 'new'; } ?>);" <?php if(!$new) { if($command->type != 'buttons'){ echo 'disabled'; } }else{ echo 'disabled'; } ?> id="btnSettingsButtons" class="btn bg-gradient-primary w-100" > <i class="fa-solid fa-bars"></i> Configurar botões</button>
                                        <p class="pt-2">
                                            Para configurar botões é necessário selecionar o tipo "Texto e Botões"
                                        </p>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right">
                                      <button type="button" class="btn bg-gradient-primary" id="btnAddBotCommand" onclick="addCommandBot();" >Salvar</button>
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
        src="<?= APP_URL; ?>/public/assets/js/bots.js?v=<?= filemtime(BASEDIR . '/public/assets/js/bots.js'); ?>"></script>
 

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/command_edit.blade.php ENDPATH**/ ?>