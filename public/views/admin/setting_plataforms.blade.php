<!-- header -->
@include('inc.header')

<link rel="stylesheet" href="<?= APP_URL; ?>/public/assets/css/whatsapp.css">

<body class="g-sidenav-show  bg-gray-100">

    @include('inc.sidebar')

    <input type="hidden" value="{{$pagename}}" id="pagename">

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb">

                    <h6 class="font-weight-bolder mb-0">Alterar dados do perfil</h6>
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

            <div class="row bg-white p-4 mb-4">
                <div class="col-md-12">
                    <a class="btn bg-gradient-primary" href="<?= APP_URL;  ?>/p/bots/settings/commands/{{$bot->id}}" ><i class="fa-solid fa-terminal"></i> Configurar Comandos</a>
                    <a class="btn bg-gradient-primary" href="<?= APP_URL;  ?>/p/bots/settings/gateways/{{$bot->id}}" ><i class="fa-brands fa-pix"></i> Configurar Pagamentos</a>

                </div>
            </div>

            <div class="row my-4">
                <div class="col-lg-8 col-md-8 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Dados do bot</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <div class="row p-4">

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Nome</label>
                                        <input type="text" class="form-control" placeholder="Username"
                                            value="{{$bot->name}}" id="bot_name">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Username</label>
                                        <input type="text" class="form-control" placeholder="Username"
                                            value="{{$bot->username}}" id="bot_username">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Apikey</label>
                                        <input type="text" class="form-control" placeholder="Apikey"
                                            value="{{$bot->apikey}}" name="" id="bot_apikey">
                                    </div>
                                </div>

                                <div class="col-md-12 d-flex justify-content-end">
                                    <div class="form-group">
                                        <button class="btn bg-gradient-success" id="btnSaveBot">Salvar</button>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

                <div class="col-lg-4 col-md-4 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-lg-6 col-7">
                                    <h6>Imagem do perfil</h6>
                                </div>

                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">

                            <div class="row p-4">

                                <div class="col-md-6 text-center">
                                  <img width="100%" src="{{$profile_pic}}" id="pic_{{$bot->id}}" alt="..." class="mb-2 img-thumbnail">

                                   <div class="form-group">
                                        <button onclick="updateProfilePic({{$bot->id}});" id="btnUpdatePic" class="btn bg-gradient-secondary w-100"> Atualizar </button>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <p>
                                     Envie o comando /setuserpic para o bot responsável por criar outros bots <b>@BotFather</b>
                                    </p>
                                    <p>
                                        Após clique em Atualizar para atualizar a foto no sistema.
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>
    </main>


    <!-- footer -->
    @include('inc.footer')

    <script src="<?= APP_URL; ?>/public/assets/js/bots.js?v=<?= filemtime(BASEDIR . '/public/assets/js/bots.js'); ?>"></script>

   


</body>

</html>