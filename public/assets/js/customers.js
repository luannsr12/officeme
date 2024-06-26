$(document).ready(function () {


    website = $('meta[name="website"]').attr('content');
    page = $('#pagename').val();

    filters_type_name = {1: 'filter', 2: 'condition', 3: 'extra'};

    // if(getCookie('order_id_clients') === null){
    //     orderTable = [7 , "asc"];
    // }else{
    //     orderTable = [8 , "desc"]; 
    // }

    orderTable = [7, "asc"];

    $('#table-customers')
        .addClass('nowrap')
        .dataTable({
            ajax: {
                url: website + '/api/customers/list?filter=actives',
                type: 'GET'
            },
            "order": [orderTable],
            "language": {
                "emptyTable": "Nenhum usuário encontrado",
                "info": "Monstrando _START_ até _END_ de _TOTAL_ usuários",
                "infoEmpty": "Monstrando 0 até 0 de 0 clientes",
                "processing": " <i class='fa fa-spin fa-spinner' ></i> Carregando",
                "lengthMenu": "Mostrar _MENU_ usuários",
                "search": "Pesquisar: ",
                "searchPlaceholder": "Nome, email ou whatsapp",
                "paginate": {
                    "next": "&gt;",
                    "previous": "&lt;"
                }
            },
            "fnInitComplete": function (oSettings, json) {
                $("#dt-search-0").on('focus', function(){
                    let lenFilter = $("#view_filters").html();
                    lenFilter.length > 0 ? null : $('#table-customers').DataTable().ajax.url(website + '/api/customers/list');
                });
            
                $("#dt-search-0").on('focusout', function(){
                    let lenFilter = $("#view_filters").html();
                    lenFilter.length > 0 ? null : $('#table-customers').DataTable().ajax.url(website + '/api/customers/list?filter=actives');
                    if($("#dt-search-0").val() == ""){
                        lenFilter.length > 0 ? null : $('#table-customers').DataTable().ajax.url(website + '/api/customers/list?filter=actives').load();
                    }
                });
 
 
            },
            columns: [
                { data: "id" },
                { data: "nome" },
                { data: "email" },
                { data: "whatsapp" },
                { data: "plano" },
                { data: "opc" }
            ],
            processing: true,
            serverSide: true,
            responsive: {
                details: {
                    type: 'column',
                    target: 1 // Coluna desejada (índice baseado em zero)
                }
            },
            columnDefs: [
                { orderable: false, targets: [4, 5] },
                { "width": "5%", "targets": 0 },
                { targets: [6, 7], visible: false },
                { "sClass": "d-relative", "aTargets": [1] },
                { "sClass": "btns_sends_zap", "aTargets": [7] },
            ]
        });


});



// function filterCustomers(filter) {
//     let labelFilter = $("#filter_" + filter).data("label");
//     $(".filter_type_uniq").remove();
//     let urlTable = $('#table-customers').DataTable().ajax.url();
//     urlTable   = removeParamURL(urlTable, `filter`);
//     let newUrl = addParamURL(urlTable, `filter=${filter}`);
//     $('#table-customers').DataTable().ajax.url(newUrl).load();
//     $("#view_filters").append(`<span class="span_filter filter_type_uniq badge bg-gradient-secondary" > " ${labelFilter} " <span> <i onclick="resetFilter();" class="fa fa-times-circle"></i> </span> </span>`);

// }

function filterCustomers(filter, type = 1) {

    if(filter == "clear"){
        $("#view_filters").html('');
        $('#table-customers').DataTable().ajax.url(website + '/api/customers/list').load();
        return true;
    }

    let newUrl = website + '/api/customers/list';
    let urlTable = $('#table-customers').DataTable().ajax.url();
    let labelFilter = $("#filter_" + filter).data("label");
    let typeFilter = filters_type_name[parseInt(type)];
    $(`.filter_type_${type}`).remove();

    urlTable = removeParamURL(urlTable, typeFilter);
    newUrl   = addParamURL(urlTable, `${typeFilter}=${filter}`);
        
    $("#view_filters").append(`<span class="span_filter filter_type_${type} badge bg-gradient-secondary" > " ${labelFilter} " <span> <i onclick="removeFilter(${type});" class="fa fa-times-circle"></i> </span> </span>`);

    $('#table-customers').DataTable().ajax.url(newUrl).load();
 
}

function removeFilter(type){
    let urlTable = $('#table-customers').DataTable().ajax.url();
    let typeFilter = filters_type_name[parseInt(type)];
    $(`.filter_type_${type}`).remove();
    newUrl = removeParamURL(urlTable, typeFilter);

    let lenFilter = $("#view_filters").html();
    if(lenFilter.length > 0){
        $('#table-customers').DataTable().ajax.url(newUrl).load();
    }else{
        newUrl   = addParamURL(urlTable, `filter=actives`);
        $('#table-customers').DataTable().ajax.url(newUrl).load();
    }

 }

// function resetFilter() {
//     let urlTable = $('#table-customers').DataTable().ajax.url();
//     let newUrl = removeParamURL(urlTable, `filter`);
//     newUrl = addParamURL(urlTable, `filter=actives`);
    
//     $(".filter_type_uniq").remove();

//     let lenFilter = $("#view_filters").html();
//     lenFilter.length > 0


//     $('#table-customers').DataTable().ajax.url(newUrl).load();

// }

function filterByServer() {
    $('#list_servers_modal').html('');
    getServers();
    setTimeout( () => {
        window.servers_rows > 0 ? $("#modalListServers").modal('show') : null;
    }, 200);
    
}

function filterServer(server_id, server_name){
    $("#modalListServers").modal('toggle');

    let urlTable  = '';
    let lenFilter = $("#view_filters").html();
    
    if(lenFilter.length > 0){
        urlTable = $('#table-customers').DataTable().ajax.url();
    }else{
       urlTable = website + '/api/customers/list';
    }

    let newUrl = addParamURL(urlTable, `server=${server_id}`);

    $('#table-customers').DataTable().ajax.url(newUrl).load();
    $("#view_filters").append(`<span id="filter_span_server" class="span_filter badge bg-gradient-secondary" > " ${server_name} " <span> <i onclick="removeServerFilter();" class="fa fa-times-circle"></i> </span> </span>`);

 
}

function removeServerFilter(){
    let urlTable = $('#table-customers').DataTable().ajax.url();
    let newUrl = removeParamURL(urlTable, `server`);

    $("#filter_span_server").remove();

    let lenFilter = $("#view_filters").html();
    if(lenFilter.length > 0){
        $('#table-customers').DataTable().ajax.url(newUrl).load();
    }else{
        newUrl   = addParamURL(newUrl, `filter=actives`);
        $('#table-customers').DataTable().ajax.url(newUrl).load();
    }

}

function getServers() {

    window.servers_rows = 0;

    $.get(website + '/api/servers/all', function (response) {

        try {

            if (response.success) {

                if (response.rows > 0) {

                    window.servers_rows = response.rows;

                    $.each(response.data, function (index, h) {

                        let html = ` <div class="col-md-12">
                                        <div data-id="${h.id}" onclick="filterServer(${h.id}, '${h.name}');" style="background-color:${h.color};" class="card card_list_server">
                                            <div class="card-body pb-1 pt-1">
                                                <h5> <i class="fa fa-server"></i> ${h.name}</h5>
                                            </div>
                                        </div>
                                    </div>`;

                        $('#list_servers_modal').append(html);

                    });

                }else{
                    Swal.fire({ 'title': 'Oops!', 'text': 'Você não possui nenhum servidor cadastrado no momento.', 'icon': 'warning' });
                }


            } else {
                Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
                return false;
            }

        } catch (error) {
            Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
            return false;
        }

    });
}