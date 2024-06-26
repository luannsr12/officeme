<!-- header -->
<?php echo $__env->make('inc.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<input type="hidden" value="<?php echo e($pagename); ?>" id="pagename">

<body class=" g-sidenav-show  bg-gray-100">

    <?php echo $__env->make('inc.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <main class="pt-3 main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <!-- Navbar -->
        <nav class="bg-white navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
            navbar-scroll="true">
            <div class="container-fluid py-1 px-3">
                <nav aria-label="breadcrumb ">

                    <h6 class="font-weight-bolder mb-0">
                        Movimentações financeiras
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
                                    <div class="btn-group btn-group-responsive-customers" role="group"
                                        aria-label="Button group with nested dropdown">

                                        <button onclick="openModalAdd();" type="button"
                                            class="btn-add-customer btn bg-gradient-primary">
                                            <i class="fa fa-plus"></i> Nova movimentação
                                        </button>

                                        <div class="btn-group btn-filter-customers" role="group">
                                            <button id="btnGroupDropFilter" type="button"
                                                class="btn bg-gradient-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-filter"></i> Filtrar
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDropFilter">
                                                <a data-label="Comissões" id="filter_deposit" class="dropdown-item"
                                                    href="javascript:filterFinancial('deposit', 1);"><i
                                                        class="fa fa-arrow-up"></i>
                                                        Comissões</a>

                                                <a data-label="Resgates" id="filter_withdraw" class="dropdown-item"
                                                    href="javascript:filterFinancial('withdraw', 1);"><i
                                                        class="fa fa-arrow-down"></i>
                                                    Resgates</a>

                                                <div class="dropdown-divider"></div>
                                                <a data-label="Última semana" id="filter_last_week"
                                                    class="dropdown-item"
                                                    href="javascript:filterFinancial('last_week', 2);"><i
                                                        class="fa fa-clock"></i> Última
                                                    semana</a>

                                                <a data-label="Este mês" id="filter_this_month" class="dropdown-item"
                                                    href="javascript:filterFinancial('this_month', 2);"><i
                                                        class="fa fa-calendar"></i> Este
                                                    mês</a>

                                                <a class="dropdown-item" href="javascript:filterCustomDate();"><i
                                                        class="fa-solid fa-filter-circle-dollar"></i> Personalizado</a>

                                                <div class="dropdown-divider"></div>

                                                <a class="dropdown-item" href="javascript:filterFinancial('clear');"><i
                                                        class="fa-solid fa-filter-circle-xmark"></i> Limpar filtro</a>

                                            </div>
                                        </div>

                                        <div class="btn-group btn-more-customers" role="group">
                                            <button id="btnGroupDropPlus" type="button"
                                                class="btn bg-gradient-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fa fa-plus"></i> Mais
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="btnGroupDropPlus">
                                                <a class="dropdown-item"
                                                    href="<?= APP_URL; ?>/p/export/financial/all"><i
                                                        class="fa fa-download"></i>
                                                    Exportar</a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item" href="javascript:openModalOptsFinancial();"><i
                                                        class="fa-solid fa-square-check"></i>
                                                    Com selecionados</a>
                                            </div>
                                        </div>


                                    </div>
                                </div>

                                <div class="col-md-12 mt-3" id="view_filters"> </div>

                            </div>
                        </div>
                        <div class="card-body px-0 pb-2">
                            <div class="unit ">
                                <div class="hero-callout">
                                    <div id="example_wrapper" class="p-3 dt-container">

                                        <div class="dt-layout-row dt-layout-table">
                                            <div class="dt-layout-cell ">
                                                <table id="table-financial"
                                                    class="display nowrap dataTable dtr-inline collapsed"
                                                    style="width: 100%;" aria-describedby="example_info">

                                                    <thead>
                                                        <tr class="head-t" role="row">
                                                            <th data-dt-column="0">
                                                                <input data-id='all' class='switch'
                                                                    onclick='setAllChecked();' id="check_all"
                                                                    value='all' type='checkbox' />
                                                            </th>
                                                            <th data-dt-column="1"
                                                                class="dt-orderable-asc dt-orderable-desc dt-ordering-asc"
                                                                aria-sort="ascending"
                                                                aria-label="Name: Activate to invert sorting"
                                                                tabindex="0"><span class="dt-column-title"
                                                                    role="button">Tipo</span><span
                                                                    class="dt-column-order"></span></th>

                                                            <th data-dt-column="2"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Position: Activate to sort" tabindex="0">
                                                                <span class="dt-column-title"
                                                                    role="button">Data</span><span
                                                                    class="dt-column-order"></span>


                                                            <th data-dt-column="3"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Office: Activate to sort" tabindex="0"><span
                                                                    class="dt-column-title"
                                                                    role="button">Valor</span><span
                                                                    class="dt-column-order"></span></th>

                                                            <th data-dt-column="4"
                                                                class="dt-orderable-asc dt-orderable-desc"
                                                                aria-label="Position: Activate to sort" tabindex="0">
                                                                <span class="dt-column-title"
                                                                    role="button">Detalhes</span><span
                                                                    class="dt-column-order"></span>
                                                            </th>

                                                            <th data-dt-column="5"
                                                                class="dt-orderable-asc dt-orderable-desc" rowspan="1"
                                                                colspan="1" aria-label="Age: Activate to sort"
                                                                tabindex="0"><span class="dt-column-title"
                                                                    role="button">Opções</span><span
                                                                    class="dt-column-order"></span></th>

                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                    <!-- <tfoot>
                                                        <tr role="row">
                                                            <th data-dt-column="0"><span
                                                                    class="dt-column-title">Name</span></th>
                                                            <th data-dt-column="1"><span
                                                                    class="dt-column-title">Position</span></th>
                                                            <th data-dt-column="2"><span
                                                                    class="dt-column-title">Office</span></th>
                                                            <th class="dt-body-right dt-type-numeric" data-dt-column="3"
                                                               ><span
                                                                    class="dt-column-title">Age</span></th>
                                                            <th class="dt-body-right dt-right" data-dt-column="4"
                                                               ><span
                                                                    class="dt-column-title">Start date</span></th>
                                                            <th class="dt-body-right dt-type-numeric dtr-hidden"
                                                                data-dt-column="5"
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

    <script
        src="<?= APP_URL; ?>/public/assets/js/financial.js?v=<?= filemtime(BASEDIR . '/public/assets/js/financial.js'); ?>"></script>

    <!-- Modal -->
    <div class="modal fade" id="modalAddFinancial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="title_modal_financial">Nova movimentação</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="financial_id" value="0">

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Tipo</label>
                                <select name="type" class="form-control" id="type">
                                    <option value="deposit">Comissão</option>
                                    <option value="withdraw">Resgate</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="value">Valor</label>

                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"
                                            style="border-radius: 9px 0px 0px 9px;background-color: #bbbcbf3b;">
                                            <?= CURRENCY_SIMBOL; ?>
                                        </span>
                                    </div>
                                    <input type="text" style="padding-left:10px;" class="form-control"
                                        placeholder="0,00" id="value" aria-describedby="basic-addon1">
                                </div>

                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="date">Data</label>
                                <input type="date" class="form-control" placeholder="dd/mm/yyy" id="date">
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="description">Detalhes</label>
                                <input type="text" class="form-control" placeholder="Comissão user x" id="description">
                            </div>
                        </div>


                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn bg-gradient-success" onclick="saveAddFinancial();"
                        id="btn_modal_financial">Adicionar</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modalCustomFilterDate" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Filtrar por um intervalo de datas</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row" style="display: flex;justify-content: center;align-items: baseline;">

                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="date" id="first_date" placeholder="dd/mm/yyyy" class="form-control">
                            </div>
                        </div>
                        <div class="col-md-2 text-center">
                            Até
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="date" id="after_date" max="<?= date('Y-m-d'); ?>" placeholder="dd/mm/yyyy" class="form-control">
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="button" id="btn_filter_dates" onclick="setDateFilter(3);" class="btn bg-gradient-primary">Aplicar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalDetailsFinancial" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detalhes da movimentação</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-12">
                            <p id="details_mov"></p>
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
    <div class="modal fade" id="modalOptsMultiple" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Oque deseja fazer com selecionados?</h5>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6">
                            <button class="w-100 btn bg-gradient-danger" onclick="removeSelecteds();"> <i
                                    class="fa fa-trash"></i> Remover selecionados</button>
                        </div>

                        <div class="col-md-6">
                            <button class="w-100 btn bg-gradient-info" onclick="exportsSelecteds();"> <i
                                    class="fa fa-download"></i> Exportar selecionados</button>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</body>

</html><?php /**PATH C:\wamp64\www\workspace\jobs\balancebet\public\views/financial.blade.php ENDPATH**/ ?>