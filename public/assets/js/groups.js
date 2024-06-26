$(function(){

    listBotsGroups();

});


$("#btnUpdateGroup").on('click', function(e){

    $("#btnUpdateGroup").prop('disabled', true);
    $("#btnUpdateGroup").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');
      
    try {

      let id = $("#group_id").val();

        $.post(`${website}/api/groups/update/info`, {id}, function(response){

            $("#btnUpdateGroup").prop('disabled', false);
            $("#btnUpdateGroup").html('Atualizar');        

            if(response.success){
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
               
                $("#group_name").val(response.data.name);
                $("#group_description").val(response.data.description);
                $("#group_invite_link").val(response.data.invite_link);
            
            }else{
                Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'error' });
            }
        });
        
    } catch (error) {
        Swal.fire({ 'title': 'Oops!', 'text': 'Desculpe, tente novamente mais tarde', 'icon': 'error' });
        $("#btnUpdateGroup").prop('disabled', false);
        $("#btnUpdateGroup").html('Atualizar');    
        return false;
    }

});

function updateProfilePic(id){

  $("#btnUpdatePic").prop('disabled', true);
  $("#btnUpdatePic").html('<i class="fa fa-spin fa-spinner" ></i> Aguarde');

  try {

      $.post(`${website}/api/groups/update/photo-profile`, {id}, function(response){

          $("#btnUpdatePic").prop('disabled', false);
          $("#btnUpdatePic").html('Atualizar');        

          if(response.success){
              Swal.fire({ 'title': response.title, 'text': response.message, 'icon': 'success' });
              $("#pic_group").attr('src', response.profile_pic);
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

function openCardGroups(id){
    let isOpen = parseInt($(".accordion-" + id).data('open'));
    isOpen > 0 ? ($(".accordion-" + id).data('open', 0), $(".arrow_card_" + id).removeClass('fa-caret-up'), $(".arrow_card_" + id).addClass('fa-caret-down')) : 
    ($(".accordion-" + id).data('open', 1), $(".arrow_card_" + id).removeClass('fa-caret-down'), $(".arrow_card_" + id).addClass('fa-caret-up'));
    getGroupsByBot(id);
}

function getGroupsByBot(bid){
  $.get(`${website}/api/groups/list/${bid}`, function (response) {
    try {

      if(parseInt(response.rows) > 0 ){

        $(`.body-accordion-${bid} #body-seacrh`).hide();
        $(`.body-accordion-${bid} #body-view`).show();

        $(`.body-accordion-${bid} #body-view`).html('');

        $.each(response.data, function (index, groups) {
    
            let card = `
              <div class="col-lg-2 col-6 col-md-6">
                  <div class="card">
                      <div class="p-2 pb-0 mb-0 m-0 text-center card-head">
                          <h5>${groups.name}</h5>
                          <p>Membors: ${groups.members}</p>
                      </div>
                      <div class="pt-0 mt-0 text-center card-body">
                          <img width="100%" src="${groups.profile_pic}" alt="..." class="img-thumbnail">
                          <a href="${website}/p/groups/settings/${groups.id}" class="w-100 mt-2 btn bg-gradient-primary" > <i class="fa fa-cogs"></i> Configurar</a> 
                      </div>
                  </div>
              </div>`;
            
            $(`.body-accordion-${bid} #body-view`).append(card);
    
          });
      }else{
        $(`.body-accordion-${bid} #body-seacrh`).hide();
        $(`.body-accordion-${bid} #body-empty`).show();
      }


    } catch (error) {
      console.log(error);
    }
  });
}

 function listBotsGroups(){
    $.get(`${website}/api/bots/list`, function (response) {
        try {
    
          $("#list-groups-bot").html('');

          if(parseInt(response.rows) > 0 ){

            $.each(response.data, function (index, bots) {
        
                let card = `
                <div class="col-lg-12 col-12 col-md-12">
                  <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="card bg-white accordion-item">
                      <h1 data-open="0" onclick="openCardGroups(${bots.id});" class="accordion-${bots.id} card-head accordion-header" id="flush-Head${bots.username}">
                        <button style="font-size: 25px;font-weight: 600;position: relative;" class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                          data-bs-target="#flush-${bots.username}" aria-expanded="false" aria-controls="flush-collapseOne">
                            &nbsp; <i class="fa-solid fa-robot " ></i> &nbsp; (@${bots.username})
                            <i style="position: absolute;right: 25px;" class="arrow_card_${bots.id} fa-solid fa-caret-down" ></i>
                        </button>
                      </h1>
                      <div id="flush-${bots.username}" class="card-body body-accordion-${bots.id} accordion-collapse collapse" aria-labelledby="flush-Head${bots.username}"
                        data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body row" id="body-view" style="display:none;" ></div>
                        <div class="accordion-body row text-center" id="body-seacrh" > <h2 class="text-secondary" ><i class="fa fa-spinner fa-spin" ></i></h2> <p>Buscando grupos</p> </div>
                        <div class="accordion-body row text-center" id="body-empty" style="display:none;" > <h2 class="text-secondary" >Você não possui grupos para este bot.</h2> <p>Adicione o bot ao grupo desejado e ele será importado para o sistema de forma automática.</p> </div>
                      </div>
                    </div>
                  
                  </div>
                </div>`;
                $("#list-groups-bot").append(card);
        
              });
          }

    
        } catch (error) {
          console.log(error);
        }
      });

}