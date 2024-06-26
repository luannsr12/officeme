$(function () {

  _keyStr = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";

  website = $('meta[name="website"]').attr('content');
  page = $('#pagename').val();
  currency_type = $('meta[name="currency_type"]').attr('content');
  currency_locale = $('meta[name="currency_locale"]').attr('content');

  $(".p_" + page).addClass('active');

  if (page == "dashboard") {

    $.get(`${website}/api/statistics/dashboard/one`, function (response) {
      try {

        if (response.success) {

          let vlMonth = parseFloat(response.data.financials.n);
          let valueThisMonth = vlMonth.toLocaleString(currency_locale, { style: 'currency', currency: currency_type });


          // new customers
          $("#newsCustomers").html(response.data.news_customers.n);
          $("#newsCustomers_progress").addClass(`w-${response.data.news_customers.percent}`);
          $("#direction_percent_news_customers").html(`(<span class="font-weight-bolder">${response.data.news_customers.direction}${response.data.news_customers.diff}%</span>)`);


          // renovateds customers
          $("#renovatedsCustomers").html(response.data.renovateds_customers.n);
          $("#renovatedsCustomers_progress").addClass(`w-${response.data.renovateds_customers.percent}`);

          // value this month
          $("#valueThisMonth").html(valueThisMonth);
          $("#card_value_dash").html(valueThisMonth);
          $("#valueThisMonth_progress").addClass(`w-${response.data.financials.percent}`);



          updateChartDataOne(window.chart_one, response.data.charts.money.deposit);
          updateChartDataTwo(window.chart_two, response.data.charts.money.deposit, response.data.charts.money.withdraw);

        }

      } catch (error) {
        console.log(error);
      }
    });

  }

});

function updateChartDataOne(chart, newData) {
  chart.data.datasets[0].data = newData;
  chart.update();
}

function isJson(str) {
  try {
    JSON.parse(str);
  } catch (e) {
    return false;
  }

  return true;
}

function copyToclipboardData(text){
  if (text.length > 0) {
    if (window.clipboardData && window.clipboardData.setData) {
      // Internet Explorer-specific code path to prevent textarea being shown while dialog is visible.
      return window.clipboardData.setData("Text", text);

    }
    else if (document.queryCommandSupported && document.queryCommandSupported("copy")) {
      var textarea = document.createElement("textarea");
      textarea.textContent = text;
      textarea.style.position = "fixed";  // Prevent scrolling to bottom of page in Microsoft Edge.
      document.body.appendChild(textarea);
      textarea.select();
      try {
        return document.execCommand("copy");  // Security exception may be thrown by some browsers.
      }
      catch (ex) {
        console.warn("Copy to clipboard failed.", ex);
        return prompt("Copy to clipboard: Ctrl+C, Enter", text);
      }
      finally {
        document.body.removeChild(textarea);
      }
    }
  }
}

function setNotSave(){
  $("#is-save").val(0);
  $(".info-not-save").show();
}

function copy(id) {
  let text = $(`#${id}`).val();
  let isCopy = copyToclipboardData(text);
  if(isCopy){
    Swal.fire({ 'title': 'Copiado!', 'text': 'Copiado com sucesso! ', 'icon': 'success' });
  }
}

function utf8_encode(string) {
  string = string.replace(/\r\n/g, "\n");
  var utftext = "";

  for (var n = 0; n < string.length; n++) {

    var c = string.charCodeAt(n);

    if (c < 128) {
      utftext += String.fromCharCode(c);
    }
    else if ((c > 127) && (c < 2048)) {
      utftext += String.fromCharCode((c >> 6) | 192);
      utftext += String.fromCharCode((c & 63) | 128);
    }
    else {
      utftext += String.fromCharCode((c >> 12) | 224);
      utftext += String.fromCharCode(((c >> 6) & 63) | 128);
      utftext += String.fromCharCode((c & 63) | 128);
    }
  }
  return utftext;
}

function utf8_decode(utftext) {
  var string = "";
  var i = 0;
  var c = c1 = c2 = 0;

  while (i < utftext.length) {

    c = utftext.charCodeAt(i);

    if (c < 128) {
      string += String.fromCharCode(c);
      i++;
    }
    else if ((c > 191) && (c < 224)) {
      c2 = utftext.charCodeAt(i + 1);
      string += String.fromCharCode(((c & 31) << 6) | (c2 & 63));
      i += 2;
    }
    else {
      c2 = utftext.charCodeAt(i + 1);
      c3 = utftext.charCodeAt(i + 2);
      string += String.fromCharCode(((c & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    }
  }
  return string;
}


function base64_encode(input) {
  var output = "";
  var chr1, chr2, chr3, enc1, enc2, enc3, enc4;
  var i = 0;

  input = utf8_encode(input);

  while (i < input.length) {

    chr1 = input.charCodeAt(i++);
    chr2 = input.charCodeAt(i++);
    chr3 = input.charCodeAt(i++);

    enc1 = chr1 >> 2;
    enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
    enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
    enc4 = chr3 & 63;

    if (isNaN(chr2)) {
      enc3 = enc4 = 64;
    } else if (isNaN(chr3)) {
      enc4 = 64;
    }

    output = output +
      _keyStr.charAt(enc1) + _keyStr.charAt(enc2) +
      _keyStr.charAt(enc3) + _keyStr.charAt(enc4);
  }
  return output;
}


function base64_decode(input) {
  var output = "";
  var chr1, chr2, chr3;
  var enc1, enc2, enc3, enc4;
  var i = 0;

  input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

  while (i < input.length) {

    enc1 = _keyStr.indexOf(input.charAt(i++));
    enc2 = _keyStr.indexOf(input.charAt(i++));
    enc3 = _keyStr.indexOf(input.charAt(i++));
    enc4 = _keyStr.indexOf(input.charAt(i++));

    chr1 = (enc1 << 2) | (enc2 >> 4);
    chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
    chr3 = ((enc3 & 3) << 6) | enc4;

    output = output + String.fromCharCode(chr1);

    if (enc3 != 64) {
      output = output + String.fromCharCode(chr2);
    }
    if (enc4 != 64) {
      output = output + String.fromCharCode(chr3);
    }
  }

  output = utf8_decode(output);

  return output;
}

function updateChartDataTwo(chart, data_deposit, data_withdraw) {
  chart.data.datasets[0].data = data_deposit;
  chart.data.datasets[1].data = data_withdraw;
  chart.update();
}

function setAllChecked() {

  if ($('#check_all').is(':checked')) {

    $('.switch').prop('checked', true);

    var ids = {};
    $('.switch').each(function () {
      if ($(this).is(':checked')) {
        var id = $(this).data('id');
        ids[id] = id;
      }
    });
    var json = JSON.stringify(ids);
    $("#rows_selected").val(json);

  } else {
    $('.switch').prop('checked', false);
    $("#rows_selected").val("{}");
  }

  verifyCheckBoxSelected();

}


function addToObject(obj, key, value, index) {

  // Create a temp object and index variable
  var temp = {};
  var i = 0;

  // Loop through the original object
  for (var prop in obj) {
    if (obj.hasOwnProperty(prop)) {

      // If the indexes match, add the new item
      if (i === index && key && value) {
        temp[key] = value;
      }

      // Add the current item in the loop to the temp obj
      temp[prop] = obj[prop];

      // Increase the count
      i++;

    }
  }

  if (!index && key && value) {
    temp[key] = value;
  }
  return temp;

}

function setRows(idrow, event) {
  verifyCheckBoxSelected();

  var checkRow = $("#rowid_" + idrow).is(':checked');

  if (checkRow) {

    var rows_selected = $("#rows_selected").val();
    if (rows_selected != "") {

      var objRows = JSON.parse(rows_selected);
      objRows = addToObject(objRows, idrow, idrow);
      var jsonInsert = JSON.stringify(objRows);
      $("#rows_selected").val(jsonInsert);

    } else {
      // primeira row
      var objRows = new Object();
      objRows[idrow] = idrow;
      var jsonInsert = JSON.stringify(objRows);
      $("#rows_selected").val(jsonInsert);

      console.log(objRows);
    }

  } else {

    var rows_selected = $("#rows_selected").val();
    var objRows = JSON.parse(rows_selected);

    delete objRows[idrow];

    var jsonInsert = JSON.stringify(objRows);
    $("#rows_selected").val(jsonInsert);

    console.log(objRows);

  }

  var rows_selected = $("#rows_selected").val();

  if (rows_selected == "{}") {
    $("#checkbox_option").css({ opacity: 0 });
    $("#block_spacing").show();
  } else {
    $("#checkbox_option").css({ opacity: 1 });
    $("#block_spacing").hide();
  }

  event.stopPropagation();

}

function verifyCheckBoxSelected() {
  // Seleciona todos os checkboxes com a classe 'switch'
  const checkboxes = document.querySelectorAll('.switch');

  // Loop através de cada checkbox
  checkboxes.forEach(function (checkbox) {
    // Verifica se o checkbox está marcado
    if (checkbox.checked) {
      // Verifica se a classe 'head-t' está presente no elemento pai 'tr'
      if (!checkbox.closest('tr').classList.contains('head-t')) {
        // Se não tiver a classe 'head-t', adiciona a classe 'checkbox-selected' ao elemento pai 'tr'
        checkbox.closest('tr').classList.add('checkbox-selected');
      }
    } else {
      // Remove a classe 'checkbox-selected' do elemento pai 'tr'
      checkbox.closest('tr').classList.remove('checkbox-selected');
    }
  });
}


$(".view-balance").on('click', function (e) {
  let view = $(this).data('view');
  b = $(".balance_view");
  view == '0' ? ($(this).addClass("fa-eye"), $(this).removeClass("fa-eye-slash"), $(this).data('view', '1'), b.html(b.data("value"))) : ($(this).removeClass("fa-eye"), $(this).addClass("fa-eye-slash"), $(this).data('view', '0'), b.html("*****"));


});



$("#btnSaveProfile").on('click', function (e) {
  try {

    let username = $("#profile_username").val();
    let password = $("#profile_password").val();

    if (username == "") {
      Swal.fire({ 'title': 'Preencha todos os campos', 'text': 'Você deve preenchar todos os campos para prosseguir.', 'icon': 'error' });
      return false;
    }

    $.post(`${website}/api/settings/profile/save`, { username, password }, function (res) {

      if (res.success) {
        Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
        return true;
      } else {
        Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        return true;
      }

    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
  }
});

function logoutWpp() {
  $(".logoutWpp").html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
  $.post(`${website}/api/whatsapp/logout`, function (res) {

    $(".logoutWpp").html('Desconectar <i class="fa fa-power-off"></i>');

    try {

      if (res.success) {

        if (res.disconnected) {

          Swal.fire({ 'title': 'Dispositivo desconectado!', 'text': 'Você desconectou o aparelho de nossa aplicação.', 'icon': 'success' });

          $("#statusWpp").removeClass("bg-gradient-success");
          $("#statusWpp").addClass("bg-gradient-danger");
          $("#statusWpp").html("Desconectado");
          $(".logoutWpp").hide();
          $(".btnLoadQr").prop("disabled", false);

        } else {
          Swal.fire({ 'title': 'Não desconectado!', 'text': 'Desculpe, não foi possível desconectar o aparelho neste momento.', 'icon': 'error' });
        }

      } else {
        Swal.fire({ 'title': 'Erro na API', 'text': res.message, 'icon': 'error' });
      }

    } catch (error) {
      console.log(error);
      Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}

$(".logoutWpp").on('click', function () {
  Swal.fire({
    title: "Desconectar-se do Whatsapp.",
    text: "Deseja realmente desconectar seu aparelho?",
    icon: "question",
    showCancelButton: true,
    confirmButtonText: "<i class='fa fa-warning' ></i> Continuar",
    confirmButtonColor: "#dc3741",
    cancelButtonText: "Cancelar",
    didDestroy: (t) => {
      $("button").prop('disabled', false);
    },
  }).then((result) => {

    if (result.isConfirmed) {
      logoutWpp();
    }

    Swal.close();

  });
});

function loadQrcode(device) {

  $(".btnLoadQr").prop("disabled", true);
  $("#statusWpp").html("Buscando Qrcode <i class='fa fa-spinner fa-spin' ></i>");
  $("#statusWpp").removeClass("bg-gradient-danger");
  $("#statusWpp").addClass("bg-gradient-secondary");

  let isDevice = parseInt(device);
  $.post(`${website}/api/whatsapp/loadqr`, { isDevice }, function (res) {
    try {

      if (res.success) {

        if (res.connected) {
          Swal.fire({ 'title': 'Dispositivo conectado!', 'text': 'Identificamos que você já se conectou ao Whatsapp.', 'icon': 'success' });
        } else {

          if (res.qrocde != "") {

            Swal.fire({
              title: "<strong>Conecte-se ao Whatsapp</strong>",
              icon: "",
              html: `
                    <div class="container w-90" >
                      <div class="row" >
                          <div class="col-md-12 text-center" >
                                <img src="${res.qrocde}" class="qrcodewpp img-thumbnail w-100" />
                          </div>
                      </div>
                     </div>
                  `,
              allowOutsideClick: false,
              showCloseButton: false,
              showConfirmButton: false,
              showCancelButton: false,
            }).then((result) => {

            });

            let getQr = setInterval(() => {
              $.get(`${website}/api/whatsapp/qrcode`, function (response) {
                if (response.success) {
                  if (response.qrocde != "") {
                    $(".qrcodewpp").attr('src', response.qrocde);
                  }
                } else {
                  Swal.fire({ 'title': 'Erro na API', 'text': res.message, 'icon': 'error' });
                  $(".btnLoadQr").prop("disabled", false);
                  clearInterval(getQr);
                }
              });
            }, 60000);


            let getStatus = setInterval(() => {
              $.get(`${website}/api/whatsapp/status`, function (response_data) {
                if (response_data.connected) {
                  Swal.fire({ 'title': 'Dispositivo conectado!', 'text': 'Você acabou de se conectar ao Whatsapp!', 'icon': 'success' });
                  $("#statusWpp").removeClass("bg-gradient-danger");
                  $("#statusWpp").addClass("bg-gradient-success");
                  $("#statusWpp").html("Conectado");
                  $(".logoutWpp").show();
                  $(".btnLoadQr").prop("disabled", true);
                  clearInterval(getQr);
                  clearInterval(getStatus);
                }
              });
            }, 5000);

          } else {
            Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
            $(".btnLoadQr").prop("disabled", false);
          }

        }

      } else {
        Swal.fire({ 'title': 'Erro na API', 'text': res.message, 'icon': 'error' });
        $(".btnLoadQr").prop("disabled", false);
      }

    } catch (error) {
      console.log(error);
      Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}

function btnOptionsList(idList) {
  $(".btnOptionsList").prop('disabled', true);
  Swal.fire({
    title: "Opções para esta lista",
    showDenyButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "<i class='fa fa-edit' ></i> Editar",
    denyButtonText: " <i class='fa fa-trash' ></i> Deletar",
    cancelButtonText: "Cancelar",
    didDestroy: (toast) => {
      $("button").prop('disabled', false);
    },
  }).then((result) => {
    if (result.isConfirmed) {
      openEditList(idList);
    } else if (result.isDenied) {
      openDeleteList(idList);
    } else if (result.isDismissed) {
      $("button").prop('disabled', false);
    }
  });
}

function openEditList(id) {
  try {

    $.get(`${website}/api/list/get/${id}`, function (res) {

      if (res.success) {

        $("#btnAddList").html('Salvar');
        $("#id_list").val(res.data.id);
        $("#name_list").val(res.data.name);
        $("#contacts_list").val(res.data.contacts);
        $("#message_list").val(res.data.message);
        $(".emoji-wysiwyg-editor").html(res.data.message);
        $("#modalAddList").modal('show');

      } else {
        Swal.fire({ 'title': 'Lista não localizada', 'text': 'Desculpe, não localizamos a lista indicada.', 'icon': 'error' });
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
  }
}

function setListsOption(id_opt, isID = false) {

  $("#" + id_opt).html("");

  $.get(`${website}/api/lists`, function (res) {
    try {

      $("#" + id_opt).append('<option value="0" >Selecionar lista</option>');

      $.each(res, function (index, list) {

        let isSel = isID && isID != null ? (isID == list.id) ? "selected" : "" : "";

        let opt = `<option ${isSel} value="${list.id}" >${list.name}</option>`;
        $("#" + id_opt).append(opt);

      });

    } catch (error) {
      console.log(error);
    }
  });
}

function confirmRemoveHour(i) {
  Swal.fire({
    title: "Deletar hora!",
    text: "Deseja realmente remover a hora desse envio?",
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
      removeHour(i);
    }
  });

}


function removeHour(i) {

  try {
    let hoursMoment = window.hours_settings;
    if (i > -1 && i < hoursMoment.length) {
      hoursMoment.splice(i, 1);
    }

    let newJsonHours = JSON.stringify(hoursMoment);

    $.post(`${website}/api/hours/edit`, { hours: newJsonHours }, function (res) {

      try {

        if (res.success) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
          listHours();
        } else {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
      }

    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
  }

}

function saveHoursF() {

  try {

    let isSave = window.saveHours;

    if (isSave == 0) {

      window.saveHours = 1;

      setTimeout(() => {

        var inputs = document.getElementsByClassName("iptnHours");
        var data = [];
        for (var i = 0; i < inputs.length; i++) {
          var hour = inputs[i].value;
          data.push({ "hour": hour });
        }

        window.hours_settings = data;

        let newJsonHours = JSON.stringify(data);

        $.post(`${website}/api/hours/edit`, { hours: newJsonHours }, function (res) {

          window.saveHours = 0;

          try {

            if (res.success) {

              $(".response_edit_hours").html(" <i class='fa fa-check' ></i> Salvamento automático!");
              setTimeout(() => {
                $(".response_edit_hours").html("");
              }, 2000);

            } else {

              $(".response_edit_hours_error").html(" <i class='fa fa-close' ></i> " + res.message);
              setTimeout(() => {
                $(".response_edit_hours_error").html("");
              }, 2000);

            }

          } catch (error) {
            console.log(error);
          }
        });
      }, 2000);
    }

  } catch (error) {
    console.log(error);
  }

}

function btnAddHourIptn() {

  try {

    let nextIndex = (window.hours_settings.length + 1);
    window.hours_settings.length = nextIndex;

    html = `<div class="timeline-block mb-3">
    <span class="timeline-step">
      <i class="fa fa-clock text-success text-gradient"></i>
    </span>
    <div class="timeline-content">
      <div class="w-80 input-group">
          <input onkeypress="saveHoursF();" value="" style="padding-right: 10px;border-top-right-radius: 0!important;border-bottom-right-radius: 0!important;" type="time" class="iptnHours form-control form-control-sm" placeholder="0:00" aria-label="Example text with button addon" aria-describedby="button-addon4">
          <button onclick="confirmRemoveHour(${nextIndex})" class="btn btn-sm btn-outline-primary mb-0" type="button" id="button-addon1">
              <i style="font-size:20px;" class="fa fa-trash"></i>
          </button>
        </div>
      </div>
  </div>`;

    $('#listHours').append(html);

  } catch (error) {
    console.log(error);
  }

}

function saveQtdperH(e) {

  $(".response_edit_hours_error").html("");

  try {

    let qtd_per_hour = parseInt($("#qtd_per_hour").val());

    if (qtd_per_hour < 1) {
      $(".response_edit_hours_error").html("A quantidade deve ser maior que zero");
      setTimeout(() => { $(".response_edit_hours_error").html(""); }, 2000);
      return false;
    }

    $.post(`${website}/api/hours/edit/qtd`, { qtd: qtd_per_hour }, function (res) {
      try {

        if (res.success) {

          $(".response_edit_hours").html(" <i class='fa fa-check' ></i> Salvamento automático!");

          setTimeout(() => {
            $(".response_edit_hours").html("");
          }, 2000);

        } else {
          $(".response_edit_hours_error").html(" <i class='fa fa-close' ></i> " + res.message);
          setTimeout(() => {
            $(".response_edit_hours_error").html("");
          }, 2000);
        }

      } catch (error) {
        console.log(error);
      }
    });

  } catch (error) {
    console.log(error);
  }



}


function formatDateView(data, removeSec) {

  const secMin = data.split(' ');
  const partesData = secMin[0].split('-');

  let dataFormatada = partesData[2] + '/' + partesData[1] + '/' + partesData[0];
  removeSec ? null : dataFormatada + ' ' + secMin;

  return dataFormatada;

}

function isParamURL(url) {
  const parametrosURL = new URLSearchParams(url);
  return parametrosURL.toString() !== '';
}

function addParamURL(url, parametro) {
  const separador = url.includes('?') ? '&' : '?';
  return url + separador + parametro;
}

function removeParamURL(url, parametro) {
  const regex = new RegExp(`([?&])${parametro}=[^&]*(&|$)`, 'i');
  return url.replace(regex, '$1').replace(/&$/, '');
}

function listHours() {
  $('#listHours').html("");
  $.get(`${website}/api/hours/getall`, function (res) {
    try {

      window.hours_settings = res.data;

      $.each(res.data, function (index, h) {

        let html = `<div class="timeline-block mb-3">
        <span class="timeline-step">
          <i class="fa fa-clock text-success text-gradient"></i>
        </span>
        <div class="timeline-content">
          <div class="w-80 input-group">
              <input onkeypress="saveHoursF();" value="${h.hour}" style="padding-right: 10px;border-top-right-radius: 0!important;border-bottom-right-radius: 0!important;" type="time" class="iptnHours form-control form-control-sm" placeholder="0:00" aria-label="Example text with button addon" aria-describedby="button-addon4">
              <button onclick="confirmRemoveHour(${index})" class="btn btn-sm btn-outline-primary mb-0" type="button" id="button-addon1">
                  <i style="font-size:20px;" class="fa fa-trash"></i>
              </button>
            </div>
          </div>
      </div>`;

        $('#listHours').append(html);


      });

    } catch (error) {

      console.log(error);
    }
  });
}

function viewMessageModal(cid, mid) {
  $.get(`${website}/api/messages/get/${cid}/${mid}`, function (res) {
    try {

      if (res.success) {

        let message_sent = res.sent ? res.sent : "";
        let message_reply = res.reply ? res.reply : "";

        $(".message.sent").html(message_sent);
        $(".message.received").html(message_reply);
        $("#destiny_view").html(res.number_format);

        $("#modalViewReply").modal('show');

      } else {
        Swal.fire({ 'title': 'Erro', 'text': res.message, 'icon': 'error' });
      }

    } catch (error) {
      Swal.fire({ 'title': 'Erro interno', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}

function getMessagesCampaign(id, page) {
  $('#listMessagesCampaigns').html("");
  $.get(`${website}/api/campaigns/messages/${id}/${page}`, function (res) {
    try {

      if (res.success) {
        if (res.data != 0) {

          $.each(res.data, function (index, me) {

            let seller_info = me.seller != null ? me.seller : { "id": 0, "name": "<i style='font-size:10px;color:gray;' >Não há</i>", "whatsapp": "", "list_id": 0 };

            let html = `
            <td>
            <div class="d-flex px-2 py-1">
              <div class="d-flex flex-column justify-content-center">
                <h6 class="mb-0 text-sm"> <i class="fa fa-whatsapp" ></i> ${me.destiny}</h6>
              </div>
            </div>
          </td>
          <td>
             <span class="responsive-text-fill" >${me.shipping_time}</span>
          </td>
          
          <td class="align-middle text-center">
              ${me.reply_time}
          </td>
          <td class="align-middle text-center">
                

               <span  class="btn-tooltip" data-toggle="tooltip" data-bs-placement="top" title="${seller_info.whatsapp}" data-container="body" data-animation="true"> 
                 ${seller_info.name}
              </span>

          </td>
          <td class="align-middle text-center text-sm">
            <span style="cursor:pointer;" class="badge bg-gradient-${me.status.color} btn-tooltip" data-toggle="tooltip" data-bs-placement="top" title="${me.message_info}" data-container="body" data-animation="true"> 
               ${me.status.text}
            </span>
          </td>

          <td class="align-middle text-center text-sm">
          <button onclick="viewMessageModal(${id}, ${me.id})" class="btn btn-sm p-1 bg-gradient-info" > 
              Mensagens <i class="fa fa-comments" ></i>
          </button>
        </td>

            `;

            let listItem = $('<tr>').html(html);
            $('#listMessagesCampaigns').append(listItem);

          });

          displayPaginationButtons(res.pagination, "messagesCampaign");

          $('[data-toggle="tooltip"]').tooltip();

        }

      }


    } catch (error) {

      console.log(error);
    }
  });
}

function listLists() {
  $('#listsResponse').html("");
  $.get(`${website}/api/lists`, function (res) {
    try {

      $.each(res, function (index, list) {

        let html = `
        <td>
        <div class="d-flex px-2 py-1">
          <div class="d-flex flex-column justify-content-center">
            <h6 class="mb-0 text-sm">${list.name}</h6>
          </div>
        </div>
      </td>
      <td>
         <span class="responsive-text-fill" >( ${list.nContacts} ) Contatos</span>
      </td>
      <td class="align-middle text-center text-sm">
        <span class="badge bg-${list.sColor}"> 
           ${list.nCampaigns}
        </span>
      </td>
      <td class="align-middle text-center">
        <button onclick="btnOptionsList(${list.id})" class="btnOptionsList btn btn-sm btn-info" >Opções</button>
        <button onclick="campaignsView('${list.id}')" id="btnViewC_${list.id}" class="text-white btn btn-sm bg-success" >
           <i class="fa fa-send" ></i> Campanhas
        </button>
      </td>
        `;

        let listItem = $('<tr>').html(html);
        $('#listsResponse').append(listItem);

      });

    } catch (error) {

      console.log(error);
    }
  });
}

function viewStaticsCampaign(cid) {

  $(".bodyCampaigns").not(".body_campaign_" + cid).hide();
  $(".row_campaign").not(".row_campaign_" + cid).addClass("opacity_campaign");

  $(".row_campaign.row_campaign_" + cid).removeClass("opacity_campaign");

  if ($("#bodyCampaign_" + cid).attr("data-open") != '1') {
    $("#bodyCampaign_" + cid).slideDown("slow");
    $("#bodyCampaign_" + cid).attr("data-open", '1');
  } else {
    $("#bodyCampaign_" + cid).slideUp("slow");
    $("#bodyCampaign_" + cid).attr("data-open", '0');
    $(".row_campaign").removeClass("opacity_campaign");
  }

}

function createCampaignModal() {
  $("#modalViewCampaigns").modal('toggle');
  let lid = $("#list_id_campaigns").val();
  modalCreateNewCampaign(lid);
}

function stopCampaign(cid, lid) {
  $(".btnStartCampaign").prop('disabled', true);
  $.post(`${website}/api/campaigns/stop/${cid}`, function (res) {
    try {

      if (res.success) {
        campaignsView(lid);
      } else {
        Swal.fire({ 'title': 'Erro', 'text': res.message, 'icon': 'error' });
      }

    } catch (error) {
      Swal.fire({ 'title': 'Erro', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}


function startCampaign(cid, lid) {
  $(".btnStartCampaign").prop('disabled', true);
  $.post(`${website}/api/campaigns/start/${cid}`, function (res) {
    try {

      if (res.success) {
        campaignsView(lid);
      } else {
        Swal.fire({ 'title': 'Erro', 'text': res.message, 'icon': 'error' });
      }

    } catch (error) {
      Swal.fire({ 'title': 'Erro', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}


function enableCampaign(cid, lid) {
  $(".btnStartCampaign").prop('disabled', true);
  $.post(`${website}/api/campaigns/enable/${cid}`, function (res) {
    try {

      if (res.success) {
        campaignsView(lid);
      } else {
        Swal.fire({ 'title': 'Erro', 'text': res.message, 'icon': 'error' });
      }

    } catch (error) {
      Swal.fire({ 'title': 'Erro', 'text': 'Desculpe, tente novamente mais tarde.', 'icon': 'error' });
    }
  });
}


function modalViewCampaigns(data, lid) {

  try {

    $("#listCampaignsModal").html("");

    $.each(data, function (index, campaign) {

      let colorProgressBarFirst = "info";

      if (campaign.percents.sent >= 100) {
        colorProgressBarFirst = "success";
      }

      let statics_bar = ``;
      let btnAction = ``;
      let classFinish = ``;

      if (campaign.original_status == "created") {

        statics_bar = `<span style="font-size: 11px;" class="badge btnStartCampaign p-1 bg-gradient-info" > Aguardando ser habiltiada <i class="fa fa-clock" ></i> </span>`;
        btnAction = `<button onclick="enableCampaign(${campaign.id}, ${lid})" style="cursor:pointer;" class="btn btn-sm bg-gradient-success" >Habilitar campanha <i style="font-size: 13px;margin-left: 2px;" class="fa fa-check-square"></i></button>`

      } else if (campaign.original_status == "started") {
        statics_bar = `<span style="font-size: 11px;" class="badge p-1 bg-gradient-secondary" > Iniciando campanha ... </span>`;
      } else if (campaign.original_status == "paused") {

        statics_bar = `<span style="font-size: 11px;" class="badge p-1 bg-gradient-warning" > Campanha pausda!</span> ${campaign.percents.sent}% Concluído `;
        btnAction = `<button onclick="startCampaign(${campaign.id}, ${lid})" style="cursor:pointer;" class="btn btn-sm bg-gradient-warning" >Reiniciar campanha <i class="fa fa-play" ></i></button>`

      } else if (campaign.original_status == "processing") {
        statics_bar = `<span style="font-size: 11px;" class="badge p-1 bg-gradient-secondary" >Campanha em andamento <i class="fa fa-spinner fa-spin" ></i></span> ${campaign.percents.sent}% Concluído `;

        btnAction = `<button onclick="stopCampaign(${campaign.id}, ${lid})" style="cursor:pointer;" class="btn btn-sm bg-gradient-danger" >Pausar campanha <i class="fa fa-stop" ></i></button>`

      } else if (campaign.original_status == "error") {
        statics_bar = `<span style="font-size: 11px;" class="badge p-1 bg-gradient-danger" >Campanha encerrada por erro <i class="fa fa-warning" ></i></span> ${campaign.percents.sent}% Concluído <br /> <small>${campaign.message_info}</small>`;
        classFinish = "campaign_finish";
      } else if (campaign.original_status == "finished") {
        statics_bar = `<span style="font-size: 11px;" class="badge p-1 bg-gradient-success" >Campanha finalizada! <i class="fa fa-check-circle-o" ></i></span> ${campaign.percents.sent}% Concluído `;
        classFinish = "campaign_finish";
      }

      let html = ` <div class="${classFinish} row row_campaign row_campaign_${campaign.id} mb-2 p-3" style="background-color: #f3f3f3e3;border-radius: 10px;border: 1px solid #141727;" > 

                     <div class="col-md-12" >

                     <div class="row" >
                      <div class="col-md-12" >
                          <div class="row" >
                            <div class="col-md-8" >
                              <h5>Campanha: #${campaign.id} </h5>
                            </div>
                            <div class="col-md-4" >
                              ${btnAction}
                            </div>
                          </div>
                          <div class="progress mb-2">
                            <div class="progress-bar bg-gradient-${colorProgressBarFirst}" role="progressbar" aria-valuenow="${campaign.percents.sent}" aria-valuemin="0" aria-valuemax="100" style="width: ${campaign.percents.sent}%;"></div>
                          </div>
                          <p>
                            ${statics_bar} 
                            <span class="p-1" style="float: right;margin-top: 6px;" > 
                                  <a href="javascript:viewStaticsCampaign(${campaign.id});" class="text-dark" >
                                     <i class="fa fa-line-chart" ></i>                                  
                                     Ver estatísticas
                                  </a> 
                            </span>
                          </p>
                      </div>
                     </div>
                     <div id="bodyCampaign_${campaign.id}" data-open="0" style="display:none;background-color: #edededdb;border-radius: 10px;" class="p-3 mb-4 mt-2 row bodyCampaigns body_campaign_${campaign.id}" >
                          <div class="col-md-4" > 
                             <p>
                               Status:  <br />  
                               <span class="badge bg-gradient-${campaign.front_status.color}" > <i class="fa ${campaign.front_status.icon}" ></i> ${campaign.front_status.text}</span> 
                             </p>
                          </div> 

                         
                          <div class="col-md-4" > 
                            <p>
                              Criada em: <br /> <span class="badge bg-gradient-dark" ><i class="fa fa-calendar" ></i> ${campaign.created_at}</span>
                            </p>
                          </div>

                          <div class="col-md-4" > 
                            <p>
                              Última atualização:  <br /> <span class="badge bg-gradient-dark" ><i class="fa fa-calendar" ></i> ${campaign.updated_at}</span>
                            </p>
                          </div>

                          <div class="col-md-12 mt-2" > 
                             <b>Mensagens: </b>
                          </div>

                          <hr style="border-top: 2px solid #14172773 !important;" class="my-3"/>


                          <!-- progressabar -->
                           <div class="col-md-6" >
                              <div class="progress-wrapper">
                                <div class="progress-info">
                                  <div class="progress-percentage">
                                    <span class="text-sm font-weight-bold"><i class="fa fa-send" ></i> Enviadas ${campaign.percents.sent}%</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-gradient-info" role="progressbar" aria-valuenow="${campaign.percents.sent}" aria-valuemin="0" aria-valuemax="100" style="width: ${campaign.percents.sent}%;"></div>
                                </div>
                                <small>${campaign.messages.sent} mensagens enviadas</small>
                              </div>
                          </div>
                          <!-- end progressabar -->


                          <!-- progressabar -->
                          <div class="col-md-6" >
                              <div class="progress-wrapper">
                                <div class="progress-info">
                                  <div class="progress-percentage">
                                    <span class="text-sm font-weight-bold"><i class="fa fa-check-circle-o" ></i> Entregues ${campaign.percents.delivered}%</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-gradient-success" role="progressbar" aria-valuenow="${campaign.percents.delivered}" aria-valuemin="0" aria-valuemax="100" style="width: ${campaign.percents.delivered}%;"></div>
                                </div>
                                <small>${campaign.messages.delivered} mensagens entregues</small>
                              </div>
                          </div>
                          <!-- end progressabar -->


                          <!-- progressabar -->
                          <div class="col-md-6" >
                              <div class="progress-wrapper">
                                <div class="progress-info">
                                  <div class="progress-percentage">
                                    <span class="text-sm font-weight-bold"><i class="fa fa-bug" ></i> Erros ${campaign.percents.error}%</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-gradient-danger" role="progressbar" aria-valuenow="${campaign.percents.error}" aria-valuemin="0" aria-valuemax="100" style="width: ${campaign.percents.error}%;"></div>
                                </div>
                                <small>${campaign.messages.error} mensagens com erros</small>
                              </div>
                          </div>
                          <!-- end progressabar -->

                          <!-- progressabar -->
                          <div class="col-md-6" >
                              <div class="progress-wrapper">
                                <div class="progress-info">
                                  <div class="progress-percentage">
                                    <span class="text-sm font-weight-bold"><i class="fa fa-reply" ></i> Respondidas ${campaign.percents.replys}%</span>
                                  </div>
                                </div>
                                <div class="progress">
                                  <div class="progress-bar bg-gradient-warning" role="progressbar" aria-valuenow="${campaign.percents.replys}" aria-valuemin="0" aria-valuemax="100" style="width: ${campaign.percents.replys}%;"></div>
                                </div>
                                <small>${campaign.messages.replys} mensagens respondidas</small>
                              </div>
                          </div>
                          <!-- end progressabar -->


                          <div class="col-md-12 mt-2" > 
                              <a href="${website}/campaign/statistic/${campaign.id}" class="mt-3 btn bg-gradient-secondary btn-sm" >Ver Mais</a>
                          </div>

    
                        </div>
                        
                     </div>

                </div>`;

      $('#listCampaignsModal').append(html);

    });

    $("#list_id_campaigns").val(lid);
    $("#modalViewCampaigns").modal('show');

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }

}

function addCampaignNow(lid) {
  try {

    $.post(`${website}/api/campaigns/add`, { lid }, function (res) {

      try {

        if (res.success) {

          Swal.fire({ 'title': res.title, 'icon': 'success', 'text': res.message });
          setTimeout(() => {
            Swal.close();
            campaignsView(lid);
          }, 1000);

        } else {
          Swal.fire({ 'title': res.title, 'icon': 'error', 'text': res.message });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
      }

    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }
}

function modalCreateNewCampaign(lid) {
  try {

    $.get(`${website}/api/list/get/${lid}`, function (res) {

      try {

        if (res.success) {

          Swal.fire({
            title: res.title,
            html: `<div class="row" >

                  <div style="text-align: left;" class="col-12" >
                      <h5><span style="font-weight: 300;" >Nome da lista:</span> ${res.data.name}</h5>
                  </div>

                  <div style="text-align: left;" class="col-12" >
                      <h5><span style="font-weight: 300;" >Contatos na lista:</span> ${res.data.nContacts}</h5>
                  </div>

                  <div style="text-align: left;" class="col-12" >
                      <h5><span style="font-weight: 300;" >Campanhas ativas:</span> ${res.data.campaigns_actives}</h5>
                  </div>

                  <div style="text-align: left;" class="col-12" >
                      <h5><span style="font-weight: 300;" >Vendedores alocados:</span> ${res.data.sellers}</h5>
                  </div>

              </div>`,
            showDenyButton: false,
            showCancelButton: true,
            focusConfirm: false,
            confirmButtonText: "<i class='fa fa-send' ></i> Criar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#82d616",
            didDestroy: (t) => {
              $("button").prop('disabled', false);
            },
          }).then((result) => {
            if (result.isConfirmed) {
              addCampaignNow(lid);
              Swal.close();
            }
          });


        } else {
          Swal.fire({ 'title': res.title, 'icon': 'error', 'text': res.message });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
      }

    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }
}


function createPaginationButton(pageNumber) {
  var button = document.createElement('button');
  button.textContent = pageNumber;
  button.addEventListener('click', function () {
    // Lógica para lidar com o clique no botão de página
    // Aqui você pode fazer uma solicitação AJAX para carregar os dados da página selecionada
  });
  return button;
}

function displayPaginationButtons(pagination, type = "campaigns") {
  var currentPage = Math.round(pagination.currentPage);
  var buttons = pagination.buttons;
  var totalPages = Math.round(buttons[buttons.length - 1]);
  var paginationContainer = document.querySelector('.pagination');
  paginationContainer.innerHTML = '';

  var MAX_ITEMS = 3;
  var MAX_LEFT = (MAX_ITEMS - 1) / 2;
  var ellipsis = '<li class="page-item disabled"><span class="page-link">...</span></li>';

  $(".total_items_pagination").html(`<small style="font-size: 11px;" >(${pagination.total_items}) Items - (${totalPages}) paginas - Pagina atual (${currentPage})</small>`);

  var first = Math.max(currentPage - MAX_LEFT, 1);
  var endPage = Math.min(totalPages, currentPage + 2);

  var paginationHTML = [];
  var lastPages = [];

  // Previous page
  if (currentPage > 1 && currentPage >= (MAX_ITEMS - 1)) {
    paginationHTML.push('<li class="page-item"><a onclick="nextPage(1, \'' + type + '\');" class="page-link"><i class="fa fa-angle-double-left"></i></a></li>');
    lastPages.push(1);
  }

  // Before page
  var beforePage = currentPage > 1 ? (currentPage - 1) : false;
  if (beforePage) {
    paginationHTML.push('<li class="page-item"><a onclick="nextPage(' + Math.round(beforePage) + ', \'' + type + '\');" class="page-link"><i class="fa fa-angle-left"></i></a></li>');
    lastPages.push(Math.round(beforePage));
  } else {
    paginationHTML.push('<li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-left"></i></span></li>');
  }

  // Loop through pages
  for (var i = 0; i < Math.min(MAX_ITEMS, totalPages); i++) {
    var page = i + first;



    if (page <= totalPages) {
      if (page === currentPage) {
        paginationHTML.push('<li class="page-item active text-white"><a onclick="nextPage(' + Math.round(page) + ', \'' + type + '\');" style="border: none;" class="page-link  bg-success text-white">' + Math.round(page) + '</a></li>');
        lastPages.push(Math.round(page));
      } else {
        paginationHTML.push('<li class="page-item"><a onclick="nextPage(' + Math.round(page) + ', \'' + type + '\');" class="page-link">' + Math.round(page) + '</a></li>');
        lastPages.push(Math.round(page));
      }
    }

  }

  // Next page
  var nextPage = currentPage + 1;
  if (endPage === currentPage) {
    lastPages.push(Math.round(endPage));
    paginationHTML.push('<li class="page-item disabled"><span class="page-link"><i class="fa fa-angle-right"></i></span></li>');
  } else {
    lastPages.push(Math.round(nextPage));
    paginationHTML.push('<li class="page-item"><a onclick="nextPage(' + Math.round(nextPage) + ', \'' + type + '\');" class="page-link"><i class="fa fa-angle-right"></i></a></li>');
  }

  // Last page
  if (!lastPages.includes(totalPages)) {
    paginationHTML.push('<li class="page-item"><a onclick="nextPage(' + Math.round(totalPages) + ', \'' + type + '\');" class="page-link"><i class="fa fa-angle-double-right"></i></a></li>');
  }

  paginationContainer.innerHTML = paginationHTML.join('');
}

function nextPage(page, type = "campaigns") {
  if (type == "campaigns") {
    campaignsView(3, page);
  } else if (type == "messagesCampaign") {
    let campaign_id = $('#campaign_id').val();
    getMessagesCampaign(campaign_id, page);
  }
}

function campaignsView(lid, page = 1) {

  try {

    $("#btnViewC_" + lid).prop('disabled', true);
    $("#btnViewC_" + lid).html('<i class="fa fa-spinner fa-spin" ></i> Aguarde');

    $.get(`${website}/api/campaigns/list/${lid}/${page}`, function (res) {

      $("#btnViewC_" + lid).prop('disabled', false);
      $("#btnViewC_" + lid).html('<i class="fa fa-send" ></i> Campanhas ');

      try {

        if (res.success) {
          modalViewCampaigns(res.data, lid);
          displayPaginationButtons(res.pagination);
        } else {

          if (res.create) {

            Swal.fire({
              title: res.title,
              text: res.message,
              showDenyButton: false,
              showCancelButton: true,
              focusConfirm: false,
              confirmButtonText: "<i class='fa fa-plus'></i> Criar campanha",
              cancelButtonText: "Cancelar",
              confirmButtonColor: "#82d616",
              didDestroy: (t) => {
                $("button").prop('disabled', false);
              },
            }).then((result) => {
              if (result.isConfirmed) {
                modalCreateNewCampaign(lid);
                Swal.close();
              }
            });

          } else {
            Swal.fire({ 'title': res.title, 'icon': 'error', 'text': res.message });
          }

        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
      }

    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }

}

function listSales() {
  $('#listSales').html("");
  $.get(`${website}/api/sales/list`, function (res) {
    try {

      $.each(res, function (index, sale) {

        let bgColor = "transparente";
        let style = "background-color: #a9a7a7;";

        if (sale.list_id) {
          bgColor = "dark";
          style = "";
        }

        let listId = sale.list_id != null ? sale.list_id : 0;

        let html = `
          <a class="nav-link bg-gradient-${bgColor}" style="${style}" href="javascript:openOptionsSales(${sale.id}, '${sale.name}', '${sale.whatsapp}', ${listId});">
            <div class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
              <i style="font-size:14px;" class="text-dark fa fa-user"></i>
            </div>
            <span class="text-white nav-link-text ms-1">${sale.name} <br> <span style="font-size:12px;" > <i class="fa fa-whatsapp"></i> ${sale.whatsapp}</span> </span>
          </a>
        `;

        let listItem = $('<li>').addClass('nav-item').html(html);
        $('#listSales').append(listItem);

      });

    } catch (error) {
      console.log(error);
    }
  });
}


function openOptionsSales(id, name, whatsapp, listid) {
  Swal.fire({
    title: "Opções para este vendedor",
    showDenyButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: "<i class='fa fa-edit' ></i> Editar",
    denyButtonText: " <i class='fa fa-trash' ></i> Deletar",
    cancelButtonText: "Cancelar",
    didDestroy: (t) => {
      $("button").prop('disabled', false);
    },
  }).then((result) => {
    if (result.isConfirmed) {
      openEditSales(id, name, whatsapp, listid);
    } else if (result.isDenied) {
      openDeleteSale(id);
    } else if (result.isDismissed) {
      $("button").prop('disabled', false);
    }
  });
}

function openDeleteList(id) {
  Swal.fire({
    title: "Deletar Lista!",
    text: "Deseja realmente remover esta lista?",
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
      removeListHttp(id);
    }
  });
}

function openDeleteSale(id) {
  Swal.fire({
    title: "Deletar vendedor!",
    text: "Deseja realmente remover este vendedor?",
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
      removeSaleHttp(id);
    }
  });
}



function openEditSales(id, name, whatsapp, listid) {

  window.id_sales_open = id;

  Swal.fire({
    title: "<strong>Editar vendedor</strong>",
    icon: "",
    html: `
          <div class="container w-90" >
            <div class="row" >
                <div class="col-md-12" >
                    <div class="form-group" >
                        <label style="float: left;" >Nome do vendedor</label>
                        <input type="text" placeholder="Nome" value="${name}" id="name_sales_edit" class="form-control" /> 
                    </div>
                    <div class="form-group" >
                        <label style="float: left;" >Whatsapp do vendedor</label>
                        <input type="text" placeholder="" value="${whatsapp}" id="phone_sales_edit" class="w-100 form-control" /> 
                    </div>
                    <div class="form-group" >
                        <label style="float: left;" >Selecionar Lista</label>
                        <select class="form-control w-100" id="listBySale" ></select>
                    </div>
                </div>
            </div>
           </div>
        `,
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: `
          <i class="fa fa-save"></i> Salvar
        `,
    cancelButtonText: `
          Cancelar
        `,
    didOpen: (toast) => {
      setListsOption("listBySale", listid);
    },
    didDestroy: (t) => {
      $("button").prop('disabled', false);
    },
  }).then((result) => {

    itiEdit.destroy();
    if (result.isConfirmed) {
      Swal.showLoading();
      editSaleHttp();
    }



  });


  const input = document.querySelector("#phone_sales_edit");
  itiEdit = window.intlTelInput(input, {
    separateDialCode: true,
    initialCountry: "br",
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/utils.js",
    preferredCountries: ["br", "pt", "us", "gb"]
  });

  $('#').mask('(00) 0000-00009');
  $('#phone_sales_edit').blur(function (event) {
    if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
      $(this).mask('(00) 00000-0009');
    } else {
      $(this).mask('(00) 0000-00009');
    }
  });

}


function addSales() {
  Swal.fire({
    title: "<strong>Adicionar vendedor</strong>",
    icon: "",
    html: `
          <div class="container w-90" >
            <div class="row" >
                <div class="col-md-12" >
                    <div class="form-group" >
                        <label style="float: left;" >Nome do vendedor</label>
                        <input type="text" placeholder="Nome" id="name_sales" class="form-control" /> 
                    </div>
                    <div class="form-group" >
                        <label style="float: left;" >Whatsapp do vendedor</label>
                        <input type="text" placeholder="" id="phone_sales" class="w-100 form-control" /> 
                    </div>
                    <div class="form-group" >
                      <label style="float: left;" >Selecionar Lista</label>
                      <select class="form-control w-100" id="listBySaleAdd" ></select>
                    </div>
                </div>
            </div>
           </div>
        `,
    showCloseButton: true,
    showCancelButton: true,
    focusConfirm: false,
    confirmButtonText: `<i class="fa fa-save"></i> Salvar `,
    cancelButtonText: ` Cancelar`,
    didOpen: (toast) => {
      setListsOption("listBySaleAdd", 0);
    },
    didDestroy: (t) => {
      $("button").prop('disabled', false);
    },
  }).then((result) => {

    iti.destroy();
    if (result.isConfirmed) {
      addSaleHttp();
    }

  });


  const input = document.querySelector("#phone_sales");
  iti = window.intlTelInput(input, {
    separateDialCode: true,
    initialCountry: "br",
    utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@19.5.7/build/js/utils.js",
    preferredCountries: ["br", "pt", "us", "gb"]
  });

  $('#').mask('(00) 0000-00009');
  $('#phone_sales').blur(function (event) {
    if ($(this).val().length == 15) { // Celular com 9 dígitos + 2 dígitos DDD e 4 da máscara
      $(this).mask('(00) 00000-0009');
    } else {
      $(this).mask('(00) 0000-00009');
    }
  });
}

function removeListHttp(id) {
  try {

    $.post(`${website}/api/list/delete/${id}`, function (res) {
      try {

        if (res.success === true) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
          listSales();
          listLists();
        } else {
          console.log(res.message);
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'text': 'Erro interno no servidor', 'icon': 'error' });
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }

}

function removeSaleHttp(id) {
  try {

    $.post(`${website}/api/sales/delete/${id}`, function (res) {
      try {

        if (res.success === true) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
          listSales();
        } else {
          console.log(res.message);
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'text': 'Erro interno no servidor', 'icon': 'error' });
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }
}

function addListHttp() {
  let id = parseInt($("#id_list").val());
  let name = $("#name_list").val();
  let contacts = $("#contacts_list").val();
  let message = $("#message_list").val();

  if (name == "" || contacts == "" || message == "") {
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Preencha todos os campos' });
    loadbtn("#btnAddList", (id > 0 ? "Salvar" : "Adicionar"), true);
    return false;
  }

  let urlEndpoint = id > 0 ? `${website}/api/list/edit` : `${website}/api/list/add`;

  try {

    let data = new Object();
    data.id = id;
    data.name = name;
    data.contacts = contacts;
    data.message = message;

    data = JSON.stringify(data);

    $.post(`${urlEndpoint}`, { data }, function (res) {

      $("#btnAddList").html('Adicionar');

      try {

        if (res.success === true) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });

          listLists();

          loadbtn("#btnAddList", "Adicionar", true);

          $("#id_list").val('0');
          $("#name_list").val('');
          $("#contacts_list").val('');
          $("#message_list").val('');

          $("#modalAddList").modal('toggle');

        } else {
          console.log(res.message);
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
          loadbtn("#btnAddList", "Adicionar", true);
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'text': 'Erro interno no servidor', 'icon': 'error' });
        loadbtn("#btnAddList", "Adicionar", true);
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
    loadbtn("#btnAddList", "Adicionar", true);
  }
}

function addSaleHttp() {
  let name = $("#name_sales").val();
  let list_id = $("#listBySaleAdd").val();
  let phone = iti.getNumber(intlTelInputUtils.numberFormat.E164);
  if (name == "" || phone == "") {
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Preencha todos os campos' });
    return false;
  }

  try {

    let data = new Object();
    data.name = name;
    data.list_id = list_id;
    data.whatsapp = phone;
    data = JSON.stringify(data);

    $.post(`${website}/api/sales/add`, { data }, function (res) {
      try {

        if (res.success === true) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
          listSales();
        } else {
          console.log(res.message);
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'text': 'Erro interno no servidor', 'icon': 'error' });
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }

}

function editSaleHttp() {
  let name = $("#name_sales_edit").val();
  let list_id = $("#listBySale").val();
  let phone = itiEdit.getNumber(intlTelInputUtils.numberFormat.E164);
  if (name == "" || phone == "") {
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Preencha todos os campos' });
    return false;
  }

  try {

    let id = window.id_sales_open;

    let data = new Object();
    data.name = name;
    data.list_id = list_id;
    data.whatsapp = phone;
    data = JSON.stringify(data);

    $.post(`${website}/api/sales/edit/${id}`, { data }, function (res) {
      try {

        if (res.success === true) {
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'success' });
          listSales();
        } else {
          console.log(res.message);
          Swal.fire({ 'title': res.title, 'text': res.message, 'icon': 'error' });
        }

      } catch (error) {
        console.log(error);
        Swal.fire({ 'title': 'Erro!', 'text': 'Erro interno no servidor', 'icon': 'error' });
      }
    });

  } catch (error) {
    console.log(error);
    Swal.fire({ 'title': 'Erro!', 'icon': 'error', 'text': 'Erro interno no servidor' });
  }

}

function login() {
  try {
    let username = $("#username").val();
    let password = $("#password").val();
    if (username == "" || password == "") {
      return { 'success': false, 'message': 'Preencha todos os campos' };
    }

    let data = new Object();
    data.username = username;
    data.password = password;
    data = JSON.stringify(data);

    let log = false;

    $.post(`${website}/api/auth`, { data }, function (res) {
      try {

        if (res.success) {
          location.href = `${website}/p/dashboard`;
          log = true;
        } else {

          Swal.fire({
            position: "center",
            icon: "info", //error
            title: res.message,
            showConfirmButton: false,
            timer: 1500
          });

          loadbtn("#btnLogin", "Entrar", true);
        }

      } catch (error) {
        console.log(error);
        return { 'success': false, 'message': 'Erro interno no servidor' };
      }
    });


  } catch (error) {
    console.log(error);
    return { 'success': false, 'message': 'Erro interno no servidor' };
  }

  if (!log) {
    return { 'success': false, 'message': '' };
  }

}

function loadbtn(id, text = "", enable = false) {
  if (enable) {
    $(id).prop('disabled', false);
    $(id).html(text);
  } else {
    $(id).prop('disabled', true);
    $(id).html('Aguarde <i class="fa fa-spinner fa-spin" ></i>');
  }
}

$("#btnLogin").on('click', function (e) {

  let logged = login();
  if (!logged.success) {
    Swal.fire({
      position: "center",
      icon: "info", //error
      title: logged.message,
      showConfirmButton: false,
      timer: 1500
    });

    loadbtn("#btnLogin", "Entrar", true);
  }
});