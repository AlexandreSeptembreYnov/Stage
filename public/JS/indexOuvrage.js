function suppression (id) {
    if (confirm("Voulez-vous vraiment supprimer cet ouvrage ?")) {
        $.ajax({
            url: '/catalogue_del', // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            data: {id: id},
            success: function () {
                location.reload();
            }
        });
    }
}

function modif (id) {
    var titre = $( "#titre"+id ).val();
    var num = $("#num"+id).val();
    var themeId = $("#theme"+id).val();
    var auteurId = $("#auteur"+id).val();
    num = parseInt(num);
    themeId = parseInt(themeId);
    auteurId = parseInt(auteurId);
    $.ajax({
        url : '/catalogue_edit', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data : { id : id , titre : titre , num : num , auteurId : auteurId, themeId : themeId},
        success : function(){
            lock(id);
        }
    });
}

function unlock (id) {
    $("#titre"+id).attr("disabled",false);
    $("#num"+id).attr("disabled",false);
    $("#auteur"+id).attr("disabled",false);
    $("#theme"+id).attr("disabled",false);
    $("#btn_valid"+id).show();
    $("#btn_cancel"+id).show();
    $("#btn_update"+id).hide();
    $("#btn_del"+id).hide();
}
function lock (id) {
    $("#titre"+id).attr("disabled",true);
    $("#num"+id).attr("disabled",true);
    $("#auteur"+id).attr("disabled",true);
    $("#theme"+id).attr("disabled",true);
    $("#btn_valid"+id).hide();
    $("#btn_cancel"+id).hide();
    $("#btn_update"+id).show();
    $("#btn_del"+id).show();
}