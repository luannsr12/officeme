$(document).ready(function () {

    website = $('meta[name="website"]').attr('content');
    currency_type = $('meta[name="currency_type"]').attr('content');
    currency_locale = $('meta[name="currency_locale"]').attr('content');
    page = $('#pagename').val();

    $('#value').mask('#.##0,00', { reverse: true });
    $('#date').val(toDateInputValue(new Date()));

    filters_type_name = {1: 'filter', 2: 'period', 3: 'byDates'};

    orderTable = [5, "desc"];

    $('#table-financial')
        .addClass('nowrap')
        .dataTable({
            ajax: {
                url: website + '/api/financial/list',
                type: 'GET'
            },
            "order": [orderTable],
            "language": {
                "emptyTable": "Nenhuma movimentação encontrada",
                "info": "Monstrando _START_ até _END_ de _TOTAL_ movimentações",
                "infoEmpty": "Monstrando 0 até 0 de 0 movimentações",
                "processing": " <i class='fa fa-spin fa-spinner' ></i> Carregando",
                "lengthMenu": "Mostrar _MENU_ movimentações",
                "search": "Pesquisar: ",
                "searchPlaceholder": "Valor, data, descrição...",
                "paginate": {
                    "next": "&gt;",
                    "previous": "&lt;"
                }
            },

            columns: [
                { data: "multiple" },
                { data: "type" },
                { data: "date" },
                { data: "value" },
                { data: "description" },
                { data: "opc" },
                { data: "id" }
            ],
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    type: 'column',
                    target: 1
                }
            },
            columnDefs: [
                {
                    "defaultContent": "-",
                    "targets": "_all"
                },
                { orderable: false, targets: [0] },
                { targets: [6], visible: false },
                { "width": "1%", "targets": 0 },
                { "width": "13%", "targets": [1, 2, 3] },
                { type: 'date', targets: [2] },
                {
                    targets: [2],
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            var dataObj = new Date(data);
                            var dia = String(dataObj.getDate()).padStart(2, '0');
                            var mes = String(dataObj.getMonth() + 1).padStart(2, '0');
                            var ano = dataObj.getFullYear();
                            return '<span><i class="fa fa-calendar" ></i> ' + dia + '/' + mes + '/' + ano + '</span>';
                        }
                        return data;
                    }
                },
                {
                    targets: [3],
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            var vl = parseFloat(data).toLocaleString(currency_locale, { style: 'currency', currency: currency_type });
                            return '<span>' + vl + '<span>';
                        }
                    }
                },
                {
                    targets: [4],
                    render: function (data, type, row) {
                        if (type === 'display' || type === 'filter') {
                            let lChar = 50;

                            if (window.innerWidth < 590) {
                                lChar = 10;
                            }

                            if (data.length > lChar) {
                                return '<a style="color:#67748e;" href="javascript:viewDetailsFinancial(\'' + data + '\');" >' + data.substring(0, lChar) + '... <span style="font-size:9px;" >[ver mais]</span> </a>';
                            } else {
                                return data;
                            }
                        }

                    }
                }
            ]
        });


});

function filterCustomDate(){
    $("#modalCustomFilterDate").modal('show');
}

function setDateFilter(type){
    $("#btn_filter_dates").prop('disabled', true);
    $("#btn_filter_dates").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');

    try {

        let first_date = $("#first_date").val(); // formatDateView(data, true);
        let after_date = $("#after_date").val();

        if(first_date == "" || after_date == ""){
            Swal.fire({ 'title': 'Oops!', 'text': 'Informe as datas para filtrar.', 'icon': 'warning' });
            $("#btn_filter_dates").prop('disabled', false);
            $("#btn_filter_dates").html('Aplicar');
            return false;
        }

        let labelFilter = formatDateView(first_date, true) + ' até ' + formatDateView(after_date, true);
        let datesFilter = `${first_date},${after_date}`;

        $(`.filter_type_2`).remove();
        $(`.filter_type_${type}`).remove();
        
        let typeFilter = filters_type_name[parseInt(type)];

        let newUrl   = website + '/api/financial/list';
        let urlTable = $('#table-financial').DataTable().ajax.url();
        urlTable = removeParamURL(urlTable, 'period');
        urlTable = removeParamURL(urlTable, typeFilter);
        newUrl   = addParamURL(urlTable, `${typeFilter}=${datesFilter}`);
            
        $("#view_filters").append(`<span class="span_filter filter_type_${type} badge bg-gradient-secondary" > " ${labelFilter} " <span> <i onclick="removeFilter(${type});" class="fa fa-times-circle"></i> </span> </span>`);
        $('#table-financial').DataTable().ajax.url(newUrl).load();


        $("#btn_filter_dates").prop('disabled', false);
        $("#btn_filter_dates").html('Aplicar');
        $("#modalCustomFilterDate").modal('toggle');
        
    } catch (error) {
        Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        $("#btn_filter_dates").prop('disabled', false);
        $("#btn_filter_dates").html('Aplicar');
        return false;
    }
    
}

function filterFinancial(filter, type = 1) {

    if(filter == "clear"){
        $("#view_filters").html('');
        $('#table-financial').DataTable().ajax.url(website + '/api/financial/list').load();
        return true;
    }

    let newUrl = website + '/api/financial/list';
    let urlTable = $('#table-financial').DataTable().ajax.url();
    let labelFilter = $("#filter_" + filter).data("label");
    let typeFilter = filters_type_name[parseInt(type)];
    $(`.filter_type_${type}`).remove();

    urlTable = removeParamURL(urlTable, typeFilter);
    newUrl   = addParamURL(urlTable, `${typeFilter}=${filter}`);
        
    $("#view_filters").append(`<span class="span_filter filter_type_${type} badge bg-gradient-secondary" > " ${labelFilter} " <span> <i onclick="removeFilter(${type});" class="fa fa-times-circle"></i> </span> </span>`);

    $('#table-financial').DataTable().ajax.url(newUrl).load();
 
}

function removeFilter(type){
    let urlTable = $('#table-financial').DataTable().ajax.url();
    let typeFilter = filters_type_name[parseInt(type)];
    $(`.filter_type_${type}`).remove();
    newUrl = removeParamURL(urlTable, typeFilter);
    $('#table-financial').DataTable().ajax.url(newUrl).load();
 }

function exportsSelecteds() {
    let rows = $("#rows_selected").val();

    if (rows == "{}" || rows == "") {
        Swal.fire({ 'title': 'Oops!', 'text': 'Você deve selecionar os items que deseja exportart.', 'icon': 'warning' });
        return false;
    }

    let ids = btoa(rows);
    encoded = ids.replace(/=+$/, '');

    $('.switch').prop('checked', false);
    $("#rows_selected").val("{}");
    verifyCheckBoxSelected();

    location.href = `${website}/p/export/financial/${encoded}`;

}

function removeFinancial(fid) {
    Swal.fire({
        title: "Deletar movimentação!",
        text: "Deseja realmente deletar essa movimentação?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "<i class='fa fa-warning' ></i> Continuar",
        confirmButtonColor: "#dc3741",
        focusConfirm: false,
        cancelButtonText: "Cancelar",
        didDestroy: (t) => {
            $("button").prop('disabled', false);
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.showLoading();
            nextRemoveFinancial(fid);
        }
    });
}

function nextRemoveFinancialMultiple() {
    try {

        let rows = $("#rows_selected").val();

        if (rows == "{}" || rows == "") {
            Swal.fire({ 'title': 'Oops', 'text': 'Você deve selecionar os items que deseja remover.', 'icon': 'error' });
            return false;
        }

        const data = { ids: JSON.parse(rows) };

        $.post(website + `/api/financial/multiple/remove`, { data }, function (response) {

            if (response.success) {
                $('#table-financial').DataTable().ajax.reload();
                $("#modalOptsMultiple").modal('toggle');
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
            } else {
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                return false;
            }

        });

    } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Error', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        return false;
    }
}

function nextRemoveFinancial(fid) {
    try {

        $.post(website + `/api/financial/remove/${fid}`, function (response) {

            if (response.success) {
                $('#table-financial').DataTable().ajax.reload();
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
            } else {
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                return false;
            }

        });

    } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Error', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        return false;
    }
}

function modalEditFinancial(fid) {
    try {

        $.get(website + `/api/financial/get/${fid}`, function (response) {

            if (response.success) {

                $("#financial_id").val(fid);
                $("#type").val(response.data.type);
                $("#value").val(response.data.value);
                $("#date").val(response.data.created_at);
                $("#description").val(response.data.description);

                $('#title_modal_financial').html('Editar movimentação');
                $('#btn_modal_financial').html('Salvar');

                $("#modalAddFinancial").modal('show');

            } else {
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                return false;
            }

        });

    } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Error', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        return false;
    }
}

function removeSelecteds() {
    Swal.fire({
        title: "Deseja realmente continuar?",
        text: "Você está prestes a deletar items selecionados.",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "<i class='fa fa-warning' ></i> Continuar",
        confirmButtonColor: "#dc3741",
        focusConfirm: false,
        cancelButtonText: "Cancelar",
        didDestroy: (t) => {
            $("button").prop('disabled', false);
        },
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.showLoading();
            nextRemoveFinancialMultiple();
        }
    });
}

function openModalOptsFinancial() {
    let rows = $("#rows_selected").val();
    if (rows == "{}") {
        Swal.fire({ 'title': 'Oops!', 'text': 'Selecione ao menos um registro.', 'icon': 'warning' });
    } else {
        $("#modalOptsMultiple").modal('show');
    }

}

function viewDetailsFinancial(details) {
    $("#details_mov").html(details);
    $("#modalDetailsFinancial").modal('show');
}

function openModalAdd() {
    $('#title_modal_financial').html('Nova movimentação');
    $('#btn_modal_financial').html('Adicionar');
    $('#date').val(toDateInputValue(new Date()));
    $('#modalAddFinancial').modal('show');
}

function toDateInputValue(dateObject) {
    const local = new Date(dateObject);
    local.setMinutes(dateObject.getMinutes() - dateObject.getTimezoneOffset());
    return local.toJSON().slice(0, 10);
}

function saveAddFinancial() {
    try {

        let id = parseInt($("#financial_id").val());
        let type = $("#type").val();
        let value = parseFloat($("#value").val().replace(/\./g, '').replace(',', '.'));
        let description = $("#description").val();
        let date = $("#date").val();
        let edit = false;

        if (value < 0 || value == 0) {
            Swal.fire({ 'title': 'Campos vazios', 'text': 'Por favor, informe um valor maior que zero.', 'icon': 'error' });
            return false;
        }

        if (description.length > 255) {
            Swal.fire({ 'title': 'Muitos caracteres', 'text': 'Em detalhes use no máximo 255 caracteres.', 'icon': 'error' });
            return false;
        }

        if (type != "deposit" && type != "withdraw") {
            Swal.fire({ 'title': 'Selecione o tipo de movimentação', 'text': 'Defina o tipo de movimentação.', 'icon': 'error' });
            return false;
        }

        if (id > 0) {
            edit = true;
        }

        const url_api = website + (edit ? `/api/financial/edit/${id}` : `/api/financial/add`);
        const data = { id, type, value, description, date };

        $.post(url_api, { data }, function (response) {
            try {

                if (response.success) {

                    $('#modalAddFinancial').modal('toggle');

                    $("#financial_id").val('0');
                    $("#type").val('deposit');
                    $("#value").val('');
                    $("#description").val('');
                    $('#date').val(toDateInputValue(new Date()));

                    $('#table-financial').DataTable().ajax.reload();

                    Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
                    return false;

                } else {
                    Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                    return false;
                }

            } catch (error) {
                console.log(error);
                Swal.fire({ 'title': 'Error', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
                return false;
            }
        });


    } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Error', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        return false;
    }


}