<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" id="pagename" value="<?php echo e($pagename); ?>">
<input type="hidden" id="command_id" value="<?php echo e($command->id); ?>">

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
                <a href="<?= APP_URL; ?>/p/bots/edit/command/<?php echo e($command->id); ?>" class="btn bg-gradient-primary" > <i class="fa fa-arrow-left"></i>  Voltar</a>
          </div>
        </div>

        <div class="col-md-6 col-6">
          <div class="card bg-white">
                <button onclick="saveButtonsAll();" id="btnSaveAll" class="btn bg-gradient-dark" > <i class="fa fa-save"></i> Salvar modificações</button>
          </div>
        </div>

      </div>

      <input type="hidden" id="is-save" value="1" >

      <div class="row" id="list-groups-bot">

        <div class="col-lg-12 col-12 col-md-12 ">
          <div class="card bg-telegram-chat">
            <div class="card-body">

                <div class="row mb-3 d-flex justify-content-center" id="info_buttons">
                    <div class="col-md-8 text-left">
                        <p class="text-secondary" >Crie botões para este comando.</p>
                        <p class="info-not-save" style="display:none;" >
                            <i class="fa-solid fa-warning"></i> Atenção, você deve salvar antes de sair desta pagina.
                        </p>
                    </div>
                </div>

                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <div class="baloon-conversation"><?php echo e($command->response); ?> <span class="hour"><?= date('H:i'); ?></span>
                        </div>

                        <div class="baloon-buttons">

                            <div data-encoded="eyJpbmRleCI6MCwidGV4dCI6IkJvdMOjbyBkZSBleGVtcGxvIiwiZXZlbnQiOiJ0ZXh0IiwibWFrZSI6eyJ2YWx1ZSI6IkhpISJ9fQ==" data-index="0" data-text="Botão de exemplo" id="button_0" onclick="openSettingButton(0);" class="is-button">
                                Botão de exemplo
                                <span>Clique sobre o botão para configurar</span>
                            </div>
                            
                            <div class="new-button" onclick="addButtonHtml();">
                                <i class="fa fa-plus"></i> Novo Botão
                            </div>

                        </div>

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


    <!-- Modal -->
    <div class="modal fade" id="modalSettingButton" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Configurar botão</h5>
            <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="row">

            <input type="hidden" name="" id="index_button" value="0" >

            <div class="col-md-12">
                <div class="form-group">
                    <button onclick="removeButton();" class="btn bg-gradient-danger" > <i class="fa-solid fa-trash"></i> Remover</button>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Texto do botão</label>
                    <input type="text" id="button_text" placeholder="Texto do botão" class="form-control">
                </div>
            </div>
 
        
            <div class="col-md-6">
                <div class="form-group">
                <label for="">Evento do botão</label>
                    <select onchange="showTypeSetting();" name="" class="form-control" id="event_button" >
                        <option value=""> Selecionar evento para o botão </option>
                        <option value="link"> Abrir link </option>
                        <option value="text"> Enviar texto </option>
                        <option value="command"> Executar comando </option>
                        <option value="request"> Enviar REQUEST </option>
                    </select>
                </div>
            </div>

            <div class="col-md-12 type_event_button" style="display:none;" id="event_setting_link" >
                <div class="row">
                     <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Texto do link</label>
                            <input type="text" id="event_link_text_value" placeholder="Link a ser redirecionado" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="">Link do evento</label>
                            <input type="text" id="event_link_value" placeholder="Link a ser redirecionado" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12 type_event_button" style="display:none;" id="event_setting_text" >
                <div class="form-group">
                   <label for="">Mensagem do evento</label>
                   <textarea class="form-control" rows="4" name="" id="event_text_value" placeholder="Mensagem a ser respondida no evento" ></textarea>
                </div>
            </div>

            <div class="col-md-12 type_event_button" style="display:none;" id="event_setting_command" >
                <div class="form-group">
                   <label for="">Comando do evento</label>
                   <input type="text" id="event_command_value" placeholder="/comando" class="form-control">
                   <small>Se atende a digitar apenas comandos configurados no bot em questão.</small>
                </div>
            </div>


            <div class="col-md-12 type_event_button" style="display:none;" id="event_setting_request" >

               <div class="row">

               <div class="col-md-6">
                    <div class="form-group">
                            <p class="p_info_warning" >
                                O sistema irá enviar um <b>POST</b> para a URL indicada com os seguintes dados no corpo da requisição:
                            </p>
                        <code>
{
    <span class="string">"bot_id"</span>: <span class="number">1234567</span>,
    <span class="string">"chat_id"</span>: <span class="number">1234567</span>,
    <span class="string">"date"</span>: <span class="string">"2024-01-01 10:00:00"</span>,
    <span class="string">"event"</span>: <span class="string">"request"</span>
}
                        </code>
                    </div>
                </div>

                <div class="col-md-6">

                    <div class="form-group ">
                        <label for="">URL API</label>
                        <input type="url" id="event_request_api_value" placeholder="https://myapi.com.br/api" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="">Header Request <span style="font-size:10px;color:gray;" >(Opcional)</span> </label>
                        <textarea class="form-control" rows="4" name="" id="event_request_headers_value" placeholder='{"param":"value", "param2", "value2"}' ></textarea>
                    </div>

                </div>

                <div class="col-md-12">

                <div class="form-group">
                        <p class="p_info_warning" >
                            O sistema espera uma reposta <b>200</b> com um JSON para responder para chat.
                        </p>
                        <code>
{
    <span class="string">"bot_id"</span>: <span class="number">1234567</span>
    <span class="string">"message"</span>: <span class="string">"Hi, I received your message 😀"</span>,
    <span class="string">"command"</span>: <span class="string">"/start"</span>, <span class="comment" >/* Opcional */</span>
    <span class="string">"chat_id"</span>: <span class="number">1234567</span>
}
                        </code>

                        <p class="mt-2 p_info_warning" >
                          Repare que você informar um comando para ser executado. Caso escolha um comando, o 'message' é desconsiderado
                        </p>

                 </div>

                </div>

               

               </div>

            </div>


            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn bg-gradient-primary" id="btnAddBot" onclick="saveButtonByCommand();" >Salvar</button>
        </div>
        </div>
    </div>
    </div>

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\bottelegramphp\public\views/command_buttons.blade.php ENDPATH**/ ?>