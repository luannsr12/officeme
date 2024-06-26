<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" value="<?php echo e($pagename); ?>" id="pagename">
<input type="hidden" value="0" id="filtered">

<body class=" g-sidenav-show  bg-gray-100">

    <?php echo $__env->make('inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="pt-3 main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="bg-white navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb ">

                    <h6 class="font-weight-bolder mb-0">
                        Clientes
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

            <div class="row my-4">
                <div class="col-lg-12 col-md-12 mb-md-0 mb-4">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="btn-group btn-group-responsive-customers" role="group" aria-label="Button group with nested dropdown">
                                       
                                    <button type="button" class="btn-add-customer btn bg-gradient-primary">
                                           <i class="fa fa-user-plus"></i> Novo cliente
                                        </button>

                                        <div class="btn-group btn-filter-customers" role="group">
                                            <button id="btnGroupDropFilter" type="button"
                                                class="btn bg-gradient-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-filter"></i> Filtrar
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDropFilter">
                                                <a class="dropdown-item" data-label="Ativos" id="filter_actives" href="javascript:filterCustomers('actives', 1);"><i class="fa fa-calendar-check"></i> Ativos</a>
                                                <a class="dropdown-item" data-label="Desativados" id="filter_disabled" href="javascript:filterCustomers('disabled', 1);"><i class="fa fa-ban"></i> Desativados</a>
                                                <a class="dropdown-item" data-label="Inadimplentes" id="filter_defaulters" href="javascript:filterCustomers('defaulters', 1);"><i class="fa fa-calendar-times"></i> Inadimplentes</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" data-label="Novos" id="filter_new" href="javascript:filterCustomers('new', 2);"><i class="fa fa-check-circle"></i> Novos</a>
                                                <a class="dropdown-item" data-label="Com alerta" id="filter_with_alert" href="javascript:filterCustomers('with_alert', 3);"><i class="fa fa-info-circle"></i> Com alerta</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:filterByServer('with_alert');"><i class="fa fa-server"></i> Por servidor</a>
                                            </div>
                                        </div>

                                        <div class="btn-group btn-more-customers" role="group">
                                            <button id="btnGroupDropPlus" type="button"
                                                class="btn bg-gradient-primary dropdown-toggle" data-bs-toggle="dropdown"
                                                aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-plus"></i> Mais
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDropPlus">
                                                <a class="dropdown-item" href="#"><i class="fa fa-upload"></i> Importar</a>
                                                <a class="dropdown-item" href="#"><i class="fa fa-download"></i> Exportar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="#"><i class="fa fa-user"></i> Área do cliente</a>
                                                <a class="dropdown-item" href="#"><i class="fa-solid fa-paper-plane"></i> Reenviar cobranças</a>
                                            </div>
                                        </div>

                                    
                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" id="view_filters" ></div>


                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="unit ">
                                <div class="hero-callout">
                                    <div id="example_wrapper" class="p-3 dt-container">

                                        <div class="dt-layout-row dt-layout-table">
                                            <div class="dt-layout-cell ">
                                                <table id="table-customers"
                                                    class="display nowrap dataTable dtr-inline collapsed"
                                                    style="width: 100%;" aria-describedby="example_info">

                                                    <thead>
                                                        <tr class="head-t" role="row">
                                                           <th >
                                                           <input data-id='all' id="check_all" class='switch' onclick='setAllChecked();' value='all'  type='checkbox' />

                                                           </th>
                                                            <th data-dt-column="0" rowspan="1" colspan="1"
                                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                                aria-sort="ascending"
                                                                aria-label="Name: Activate to invert sorting"
                                                                tabindex="0"><span class="dt-column-title"
                                                                    role="button">Nome</span><span
                                                                    class="dt-column-order"></span></th>
                                                            <th data-dt-column="1" rowspan="1" colspan="1"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Position: Activate to sort" tabindex="0">
                                                                <span class="dt-column-title"
                                                                    role="button">Vencimento</span><span
                                                                    class="dt-column-order"></span>
                                                            </th>
                                                            <th data-dt-column="2" rowspan="1" colspan="1"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                                    class="dt-column-title"
                                                                    role="button">Email</span><span
                                                                    class="dt-column-order"></span></th>
                                                            <th data-dt-column="3"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Age: Activate to sort" tabindex="0"><span
                                                                    class="dt-column-title"
                                                                    role="button">Whatsapp</span><span
                                                                    class="dt-column-order"></span></th>
                                                            <th data-dt-column="4"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Start date: Activate to sort" tabindex="0">
                                                                <span class="dt-column-title" role="button">Plano</span><span class="dt-column-order"></span>
                                                            </th>
                                                            <th data-dt-column="5"
                                                                class="dt-orderable-asc dt-orderable-desc dtr-hidden"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Salary: Activate to sort" tabindex="0"
                                                                style="display: none;"><span class="dt-column-title"
                                                                    role="button">Opções</span><span
                                                                    class="dt-column-order"></span></th>

                                                                    <th data-dt-column="5"
                                                                class="dt-orderable-asc dt-orderable-desc dtr-hidden"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Salary: Activate to sort" tabindex="0" ><span class="dt-column-title"
                                                                    role="button">Enviar Mensagem</span><span
                                                                    class="dt-column-order"></span></th>

                                                                    <th data-dt-column="5"
                                                                class="dt-orderable-asc dt-orderable-desc dtr-hidden"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Salary: Activate to sort" tabindex="0"
                                                                style="display: none;"><span class="dt-column-title"
                                                                    role="button">Data Convert</span><span
                                                                    class="dt-column-order"></span></th>

                                                                     <th data-dt-column="5"
                                                                class="dt-orderable-asc dt-orderable-desc dtr-hidden"
                                                                rowspan="1" colspan="1"
                                                                aria-label="Salary: Activate to sort" tabindex="0"
                                                                style="display: none;"><span class="dt-column-title"
                                                                    role="button">ID</span><span
                                                                    class="dt-column-order"></span></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                       
                                                    </tbody>
                                                    <!-- <tfoot>
                                                        <tr role="row">
                                                            <th data-dt-column="0" rowspan="1" colspan="1"><span
                                                                    class="dt-column-title">Name</span></th>
                                                            <th data-dt-column="1" rowspan="1" colspan="1"><span
                                                                    class="dt-column-title">Position</span></th>
                                                            <th data-dt-column="2" rowspan="1" colspan="1"><span
                                                                    class="dt-column-title">Office</span></th>
                                                            <th class="dt-body-right dt-type-numeric" data-dt-column="3"
                                                                rowspan="1" colspan="1"><span
                                                                    class="dt-column-title">Age</span></th>
                                                            <th class="dt-body-right dt-right" data-dt-column="4"
                                                                rowspan="1" colspan="1"><span
                                                                    class="dt-column-title">Start date</span></th>
                                                            <th class="dt-body-right dt-type-numeric dtr-hidden"
                                                                data-dt-column="5" rowspan="1" colspan="1"
                                                                style="display: none;"><span
                                                                    class="dt-column-title">Salary</span></th>
                                                        </tr>
                                                    </tfoot> -->
                                                </table>
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
    </main>
 

    <!-- footer -->
    <?php echo $__env->make('inc.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script src="<?= APP_URL; ?>/public/assets/js/customers.js?v=<?= filemtime(BASEDIR . '/public/assets/js/customers.js'); ?>"></script>

    <!-- Modal -->
    <div class="modal fade" id="modalViewReply" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                                                            <img src="https://t4.ftcdn.net/jpg/00/64/67/63/360_F_64676383_LdbmhiNM6Ypzb3FM4PPuFP9rHe7ri8Ju.webp"
                                                                alt="Avatar">
                                                        </div>
                                                        <div class="name">
                                                            <span id="destiny_view">Seu Whatsapp</span>
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
                                                                    <span class="time"></span><span class="tick"><svg
                                                                            xmlns="http://www.w3.org/2000/svg"
                                                                            width="16" height="15" id="msg-dblcheck-ack"
                                                                            x="2063" y="2076">
                                                                            <path
                                                                                d="M15.01 3.316l-.478-.372a.365.365 0 0 0-.51.063L8.666 9.88a.32.32 0 0 1-.484.032l-.358-.325a.32.32 0 0 0-.484.032l-.378.48a.418.418 0 0 0 .036.54l1.32 1.267a.32.32 0 0 0 .484-.034l6.272-8.048a.366.366 0 0 0-.064-.512zm-4.1 0l-.478-.372a.365.365 0 0 0-.51.063L4.566 9.88a.32.32 0 0 1-.484.032L1.892 7.77a.366.366 0 0 0-.516.005l-.423.433a.364.364 0 0 0 .006.514l3.255 3.185a.32.32 0 0 0 .484-.033l6.272-8.048a.365.365 0 0 0-.063-.51z"
                                                                                fill="#4fc3f7" />
                                                                        </svg></span>
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
    <div class="modal fade" id="modalViewCampaigns" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Todas as campanhas desta lista</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="list_id_campaigns" value="0">

                    <div id="listCampaignsModal" class="container">

                    </div>

                    <div class="pagination mt-3" style="justify-content: right;"></div>
                    <div style="float: right;" class="mt-2 total_items_pagination"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" class="btn bg-gradient-success" onclick="createCampaignModal();">Criar nova
                        campanha</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalListServers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Selecione o servidor</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                <div class="row" id="list_servers_modal">
                   
                </div>
 
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>


</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\gestorlite\public\views/customers.blade.php ENDPATH**/ ?>