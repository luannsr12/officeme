$(function(){

    if(page == 'plataforms'){
        listPlataforms();
    }
 
    if(page == 'command_buttons'){
        let cid = parseInt($("#command_id").val());
        cid > 0 ? listButtonsCommand(cid) : null;

        window.onbeforeunload = function(event) {
            let isSave = parseInt($("#is-save").val());
            isSave > 0 ? null : event.returnValue = "Você não salvou as alterações, deseja mesmo sair?";
        };

    }

    if(page == 'commands_bot'){
        let botid = $("#botid").val();
        listPlataformsCommands(botid);
    }
});

function saveButtonsAll(){

    $("#btnSaveAll").prop('disabled', true);
    $("#btnSaveAll").html('<i class="fa fa-spin fa-spinner" ></i> Salvando');

    let cid = parseInt($("#command_id").val());
    try {

        let buttons = getDataEncodedJsonButtons();

        if(buttons == '[]'){
            Swal.fire({ 'title': 'Oops!', 'text': 'Você não criou nenhum, botão', 'icon': 'warning' });
            $("#btnSaveAll").prop('disabled', false);
            $("#btnSaveAll").html('<i class="fa fa-save" ></i> Salvar');
            return false;
        }
        
        $.post(`${website}/api/plataforms/edit/buttons/command/${cid}`,{buttons}, function(response){

            $("#btnSaveAll").prop('disabled', false);
            $("#btnSaveAll").html('<i class="fa fa-save" ></i> Salvar');

            if(response.success){
                $("#is-save").val(1);
                $(".info-not-save").hide();
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }

        });

    } catch (error) {
        Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
        $("#btnSaveAll").prop('disabled', false);
        $("#btnSaveAll").html('<i class="fa fa-save" ></i> Salvar');
    }
}

function saveCommandNextButtons(cid){
     if(cid == 'new'){
        $("#btnSettingsButtons").prop('disabled', true);
        $("#btnSettingsButtons").html('<i class="fa fa-spin fa-spinner"></i> Aguarde');
        addCommandBot(true);
    }else{
        location.href=`${website}/p/plataforms/buttons/command/${cid}`;
    }
}

function saveButtonByCommand(){
    let index = $("#index_button").val();
    let text  = $("#button_text").val();
    let event = $("#event_button").val();
    let make  = {};

    if(event == "request"){
        let apiurl  = $("#event_request_api_value").val();
        let headers = $("#event_request_headers_value").val();

        if(apiurl == ""){
            Swal.fire({ 'title': 'Oops!', 'text': 'Informe uma URL da API', 'icon': 'error' });
            return false;
        }

        if(headers.length > 0){
            if(isJson(headers)){
                make.headers = JSON.parse(headers);
            }else{
                Swal.fire({ 'title': 'Oops!', 'text': 'O campos Headers, deve ser um JSON válido', 'icon': 'error' });
                return false;
            }
        }

        make.api = apiurl;
    }else if(event == "link"){

        let link      = $("#event_link_value").val();
        let text_link = $("#event_link_text_value").val();

        if(link == "" || text_link == ""){
            Swal.fire({ 'title': 'Oops!', 'text': 'Preencha todos os campos', 'icon': 'error' });
            return false;
        }
       
        make.link = link;
        make.text_link = text_link;

    }else{
        let value_event = $('#event_'+event+'_value').val();
        if(value_event == ""){
            Swal.fire({ 'title': 'Oops!', 'text': 'Preencha todos os campos.', 'icon': 'error' });
            return false;
        }else{
            make.value = value_event;
        }
    }


    let event_button = {
        index,
        text,
        event,
        make
    };

    console.log(event_button);
    $("#button_"+event_button.index).html(`${event_button.text} <span>Clique sobre o botão para configurar</span>`);
    
   event_button = JSON.stringify(event_button);
   event_button = base64_encode(event_button);

   $("#button_"+index).attr("data-encoded", event_button);

   $("#modalSettingButton").modal('toggle');
   setNotSave();
}

function showTypeSetting(){
    let type_event = $("#event_button").val();
    $(".type_event_button").hide();
    if(type_event == ""){
        return true;
    }

    $("#event_setting_"+type_event).show();
}

function selectedTypeCommand(){
    let type = $("#command_type").val();
    if(type == "buttons"){
        $("#btnSettingsButtons").prop('disabled', false);
    }else{
        $("#btnSettingsButtons").prop('disabled', true);
    }
}

function openSettingButton(index){
    
     let data_button = $("#button_"+index).attr("data-encoded");
     data_button = base64_decode(data_button);
     if(isJson(data_button)){
        data_button = JSON.parse(data_button);
        $("#button_text").val(data_button.text);
        $("#index_button").val(index);
        $("#event_button").val(data_button.event);
        showTypeSetting();

        if(data_button.event == "request"){
            $("#event_request_api_value").val(data_button.make.api);
            if(typeof data_button.make.headers !== "undefined"){
                $("#event_request_headers_value").val(JSON.stringify(data_button.make.headers));
            }
        }else if(data_button.event == "link"){
            $("#event_link_value").val(data_button.make.link);
            $("#event_link_text_value").val(data_button.make.text_link);
        }else{
            $('#event_'+data_button.event+'_value').val(data_button.make.value);
        }

     }

    $("#modalSettingButton").modal('show');
}

function removeButton(){
    let index = $("#index_button").val();
    $("#button_"+index).remove();
    reorganizeIndexesButtons();
    $("#modalSettingButton").modal('toggle');
}

function reorganizeIndexesButtons(){
    const buttons = document.querySelectorAll('.baloon-buttons .is-button');
    buttons.forEach((button, index) => {

        encoded = button.getAttribute('data-encoded');

        encodedV = base64_decode(encoded);

        if(isJson(encodedV)){

            encodedParse   = JSON.parse(encodedV);
            encodedParse.index = index;
            nEncoded     = base64_encode(JSON.stringify(encodedParse));

            button.setAttribute('data-index', index);
            button.setAttribute('id', `button_${index}`);
            button.setAttribute('data-encoded', nEncoded);
            button.setAttribute('onclick', `openSettingButton(${index});`);
        }

    });
}

function getDataEncodedJsonButtons() {
    const buttons = document.querySelectorAll('.is-button');
    const buttons_end = [];

    buttons.forEach(button => {
        const index = button.getAttribute('data-index');
        let encoded = button.getAttribute('data-encoded');

        encoded = base64_decode(encoded);

        if(isJson(encoded)){

            encoded = JSON.parse(encoded);

            buttons_end.push({ 
                index: parseInt(index, 10), 
                name: 'button_' + parseInt(index, 10),
                setting: encoded
            });

        }

    });

    return JSON.stringify(buttons_end, null, 2);
}

function addButtonHtml(e){
    const baloonButtons = document.querySelector('.baloon-buttons');
    const isButtons = baloonButtons.querySelectorAll('.is-button');
    const newIndex = isButtons.length; // O próximo índice é o tamanho atual dos is-buttons

    let encoded = {
        index: newIndex,
        text: `Botão ${newIndex}`,
        event: 'text',
        make: { value: 'Hi!' }
    }

    encoded = base64_encode(JSON.stringify(encoded));

    // Cria o novo elemento div
    const newButton = document.createElement('div');
    newButton.classList.add('is-button');
    newButton.setAttribute('data-index', newIndex);
    newButton.setAttribute('id', `button_${newIndex}`);
    newButton.setAttribute('data-encoded', encoded);
    newButton.setAttribute('onclick', `openSettingButton(${newIndex});`);
    newButton.innerHTML = `
        Botão ${newIndex}
        <span>Clique sobre o botão para configurar</span>
    `;

    // Insere o novo botão antes do botão "Novo Botão"
    const newButtonContainer = baloonButtons.querySelector('.new-button');
    baloonButtons.insertBefore(newButton, newButtonContainer);
    setNotSave();
};
 

function addCommandBot(cid = false){ 

    $("#btnaddPlataformCommand").prop('disabled', true);
    $("#btnaddPlataformCommand").html(' <i class="fa fa-spin fa-spinner" ></i> Aguarde');    

    let botid = $("#botid").val();
    let id = parseInt($("#command_id").val());
    let command = $("#command_command").val();
    let description = $("#command_description").val();
    let is_menu = $("#command_is_menu").val();
    let type = $("#command_type").val();
    let response = $("#command_response").val();

    let uri = id > 0 ? `${website}/api/plataforms/edit/commands/${id}` : `${website}/api/plataforms/add/commands/${botid}`;
    let buttonText = id > 0 ? 'Salvar' : 'Adicionar';

    $.post(uri, {
        botid,
        command,
        description,
        is_menu,
        type,
        response
    }, function(res){

        try {

            $("#btnaddPlataformCommand").prop('disabled', false);
            $("#btnaddPlataformCommand").html(buttonText);

            if(res.success){
                if(cid){
                    location.href=`${website}/p/plataforms/buttons/command/${res.command_id}`;
                }else{
                    Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
                }
                          
            }else{
                if(cid){
                    $("#btnSettingsButtons").prop('disabled', false);
                    $("#btnSettingsButtons").html('<i class="fa-solid fa-bars"></i> Configurar botões');
                }
                Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
            }
            
        } catch (error) {

            if(cid){
                $("#btnSettingsButtons").prop('disabled', false);
                $("#btnSettingsButtons").html('<i class="fa-solid fa-bars"></i> Configurar botões');
            }

            Swal.fire({ 'title': 'Oops!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
            $("#btnaddPlataformCommand").prop('disabled', false);
            $("#btnaddPlataformCommand").html(buttonText);    
        }

    });

}

function listPlataforms(){
    $.get(`${website}/api/plataforms/list`, function (response) {
        try {
    
          $("#listPlataforms").html('');
    
          $.each(response.data, function (index, plataforms) {
        
            let card = `
                <div class="col-lg-2 col-6 col-md-6">
                    <div class="card">
                        <div class="p-2 pb-0 mb-0 m-0 text-center card-head">
                            <h5>${plataforms.name}</h5>
                        </div>
                        <div class="pt-0 mt-0 text-center card-body">
                            <img width="100%" src="${plataforms.profile_pic}" alt="..." class="img-thumbnail">
                            <a href="${website}/p/plataforms/settings/${plataforms.id}" class="w-100 mt-2 btn bg-gradient-primary" > <i class="fa fa-cogs"></i> Configurar</a> 
                        </div>
                    </div>
                </div>
                `;
            $("#listPlataforms").append(card);
    
          });
    
        } catch (error) {
          console.log(error);
        }
      });

}

function modalEditCommand(cid){

    $.get(`${website}/api/plataforms/get/command/${cid}`, function (response) {
        try {

            if(response.success){

                $("#command_id").val(response.data.id);
                $("#command_command").val(response.data.command);
                $("#command_description").val(response.data.description);
                $("#command_is_menu").val(response.data.is_menu);
                $("#command_type").val(response.data.type);
                $("#command_response").val(response.data.response);

                $("#btnaddPlataformCommand").html('Salvar');

                $("#modaladdPlataformCommand").modal('show');

            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }
            
        } catch (error) {
            Swal.fire({ 'title': 'Oops!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
        }
    });

}


function listButtonsCommand(cid){
    $.get(`${website}/api/plataforms/get/buttons/command/list/${cid}`, function (response) {
        try {

            if(response.success){
                if(parseInt(response.rows) > 0){
                
                    $(".baloon-buttons").html(`<div class="new-button" onclick="addButtonHtml();" ><i class="fa fa-plus"></i> Novo Botão</div>`);

                    const baloonButtons = document.querySelector('.baloon-buttons');
                    const newButtonContainer = baloonButtons.querySelector('.new-button');
            
                    $.each(response.data, function (index, button) {

                        console.log(button);
                
                        let encoded = button;
        
                        encoded = base64_encode(JSON.stringify(encoded.setting));
        
                        // Cria o novo elemento div
                        let newButton = document.createElement('div');
                        newButton.classList.add('is-button');
                        newButton.setAttribute('data-index', button.index);
                        newButton.setAttribute('id', `button_${button.index}`);
                        newButton.setAttribute('data-encoded', encoded);
                        newButton.setAttribute('onclick', `openSettingButton(${button.index});`);
                        newButton.innerHTML = `
                            ${button.setting.text}
                            <span>Clique sobre o botão para configurar</span>
                        `;
        
                        // Insere o novo botão antes do botão "Novo Botão"
                        
                        baloonButtons.insertBefore(newButton, newButtonContainer);
            
                    });
            
                }else{
                    setNotSave();
                }
            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }
   
        } catch (error) {
            console.log(error);
            Swal.fire({ 'title': 'Erro!', 'text': 'Ocorreu um erro ao listar os botões. Tente novamente mais tarde.', 'icon': 'error' });
        }
      });

}


function listPlataformsCommands(id){
    $.get(`${website}/api/plataforms/list/commands/${id}`, function (response) {
        try {
    
          $("#listBotCommands").html('');
    
          $.each(response, function (index, command) {
        
            let card = `
                <div class="col-lg-2 col-6 col-md-2">
                    <div class="card">
                        <div class="p-2 pb-0 mb-0 m-0 card-body">
                            <div class="row" >
                                <div class="col-md-6 pl-3" >
                                  <p>
                                    <span style="font-size: 12px;">Comando:</span> <br />
                                    <b style="font-size: 20px;color:#600ef9;" >${command.command}</b>
                                  </p>
                                </div>
                                <div style="text-align: right;" class="col-md-6 text-right" >
                                  <a href="${website}/p/plataforms/edit/command/${command.id}" class=" btn bg-gradient-primary p-2" >
                                    <i class="fa fa-cog" ></i>
                                  </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                `;
            $("#listBotCommands").append(card);
    
          });
    
        } catch (error) {
          console.log(error);
        }
      });

}


function updateProfilePic(id){

    $("#btnUpdatePic").prop('disabled', true);
    $("#btnUpdatePic").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');

    try {

        $.post(`${website}/api/plataforms/update/photo-profile`, {id}, function(response){

            $("#btnUpdatePic").prop('disabled', false);
            $("#btnUpdatePic").html('Atualizar');        

            if(response.success){
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
                $("#pic_" + id).attr('src', response.profile_pic);
            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }
        });
        
    } catch (error) {
        Swal.fire({ 'title': 'Oops!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
        $("#btnUpdatePic").prop('disabled', false);
        $("#btnUpdatePic").html('Atualizar');    
        return false;
    }
}

function addPlataform(){

    $("#btnaddPlataform").prop('disabled', true);
    $("#btnaddPlataform").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');

    let id = parseInt($("#id_bot").val());
    let name = $("#bot_name").val();
    let username = $("#bot_username").val();
    let apikey = $("#bot_apikey").val();

    let uri = website + (id > 0 ? `/api/plataforms/edit/${id}` : `/api/plataforms/add`);

    if(name == "" || username == "" || apikey == ""){
        Swal.fire({ 'title': 'Oops!', 'text': 'Preencha todos os campos', 'icon': 'warning' });
        $("#btnaddPlataform").prop('disabled', false);
        $("#btnaddPlataform").html('Adicionar');
        return false;
    }

    $.post(uri, {name, username, apikey}, function(response){

        $("#btnaddPlataform").prop('disabled', false);
        $("#btnaddPlataform").html('Adicionar');

        try {

            if(response.success){

                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
                listPlataforms();
                $("#modaladdPlataform").modal('toggle');

            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                return false;
            }
            
        } catch (error) {
            Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
            return false;
        }

    });

}