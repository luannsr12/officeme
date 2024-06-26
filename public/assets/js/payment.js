
$(function(){

    window.onbeforeunload = function(event) {
        let isSave = parseInt($("#is-save").val());
        isSave > 0 ? null : event.returnValue = "Você não salvou as alterações, deseja mesmo sair?";
    };
    changeSplitEnable(false);
});

function changeSplitEnable(isNotSave = true){
    let isSplit = parseInt($("#split_enable").val());
    if(isSplit > 0){
        // enable
        $(".hide-enable-split").show();
        $(".hide-enable-split input").prop('disabled', false);
        $(".hide-enable-split button").prop('disabled', false);
        $(".hide-enable-split select").prop('disabled', false);
    }else{
        // disabled
        $(".hide-enable-split").hide();
        $(".hide-enable-split input").prop('disabled', true);
        $(".hide-enable-split button").prop('disabled', true);
        $(".hide-enable-split select").prop('disabled', true);
    }

    isNotSave ? setNotSave() : null;
}


function changeEnableGateway(){
    let isEnable = parseInt($("#enable_gateway").val());
    if(isEnable > 0){
        $(".status_gateway").html(`<span class="badge bg-gradient-success" >Ligado</span>`);
        $(".hide-not-enable-gateway").show();
    }else{
        $(".status_gateway").html(`<span class="badge bg-gradient-danger" >Desligado</span>`);
        $("#split_enable").val('0');
        $(".hide-not-enable-gateway").hide();
    }

    changeSplitEnable();
    setNotSave();
}

function changeEnablePix(){
    let isPix = parseInt($("#enable_pix").val());
    if(isPix > 0){
        // enable
        $(".input-text-pix").prop('disabled', false);
    }else{
        // disabled
        $(".input-text-pix").prop('disabled', true);
    }

    setNotSave();
}

function changeEnableCreditCard(){
    let isCreditCard = parseInt($("#enable_credit_card").val());
    if(isCreditCard > 0){
        // enable
        $(".input-text-credit-card").prop('disabled', false);
    }else{
        // disabled
        $(".input-text-credit-card").prop('disabled', true);
    }

    setNotSave();
}


function capturePaymentSettings() {
    const paymentSettingsElements = document.querySelectorAll('.payment-setting');
    const paymentSettings = {};

    paymentSettingsElements.forEach(element => {
        const name = element.name;
        const value = element.type === 'checkbox' ? element.checked : element.value;

        // Use regex to parse the name attribute
        const nameParts = name.match(/([^\[\]]+)/g);
        let currentLevel = paymentSettings;

        nameParts.forEach((part, index) => {
            if (index === nameParts.length - 1) {
                 currentLevel[part] = (value === 'true' || value === 'false') ? (value === 'true') : value;
             } else {
                if (!currentLevel[part]) {
                    currentLevel[part] = {};
                }
                currentLevel = currentLevel[part];
            }
        });
    });

    // Add additional dynamic values like the PIN number and its expiration
    Object.keys(paymentSettings).forEach(key => {
        if (!paymentSettings[key].split) {
            paymentSettings[key].split = {};
        }
        if (!paymentSettings[key].split.pin) {
            paymentSettings[key].split.pin = {};
        }

        paymentSettings[key].split.pin.number = Math.floor(Math.random() * (999999 - 10000 + 1)) + 10000;
        paymentSettings[key].split.pin.expire = Math.floor(Date.now() / 1000) + 3600; // timestamp 1 hora à frente
    });

    console.log(paymentSettings);
    return paymentSettings;
}


function saveGateway(){

    $("#btnSavePaymentSettings").prop('disabled', true);
    $("#btnSavePaymentSettings").html(' <i class="fa fa-spin fa-spinner" ></i> Aguarde');

    try {

        let botid = $("#botid").val();
        let payment_settings = JSON.stringify(capturePaymentSettings());

        if(payment_settings == '{}' || payment_settings == '[]'){
            $("#btnSavePaymentSettings").prop('disabled', false);
            $("#btnSavePaymentSettings").html('Salvar');
            Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
            return false;
        }

        $.post(`${website}/api/payment/setting/edit/${botid}`, {payment_settings} , function(response){

            $("#btnSavePaymentSettings").prop('disabled', false);
            $("#btnSavePaymentSettings").html('Salvar');

            if(response.success){
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
                $("#is-save").val(1);
                $(".info-not-save").hide();
            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }
        });
        
    } catch (error) {
        console.log(error);
        $("#btnSavePaymentSettings").prop('disabled', false);
        $("#btnSavePaymentSettings").html('Salvar');
        Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
    }
}

function generateLinkSplit(){
    let isSplit = parseInt($("#split_enable").val());
    if(isSplit > 0){

        let botid = $("#botid").val();
        let gateway =$("#gateway").val();

        try {

            $.post(`${website}/api/payment/split/generate/link/${botid}`, {gateway}, function(response){
                if(response.success){
                    Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
                    $("#link_split").val(response.link);
                }else{
                    Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
                }
            });
            
        } catch (error) {
            console.log(error);
            Swal.fire({ 'title': 'Error!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
        }

    }else{
        Swal.fire({ 'title': 'Oops!', 'text': 'Você deve primeiro ativar o split.', 'icon': 'warning' });
    }
}