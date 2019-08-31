function suppression (id) {
    if (confirm("Voulez-vous vraiment supprimer cet auteur ?")) {
        $.ajax({
            url: '/gestionAuteurs_del', // La ressource ciblée
            type: 'GET', // Le type de la requête HTTP.
            data: {id: id},
            success: function () {
                location.reload();
            }
        });
    }
}

function modif (id) {
    var libelle = $( "#lib"+id ).val();
    $.ajax({
        url : '/gestionAuteurs_edit', // La ressource ciblée
        type : 'GET', // Le type de la requête HTTP.
        data : { id : id , libelle : libelle },
        success : function(){
            lock(id);
        }
    });
}

function unlock (id) {
    $("#lib"+id).attr("disabled",false);
    $("#btn_valid"+id).show();
    $("#btn_cancel"+id).show();
    $("#btn_update"+id).hide();
    $("#btn_del"+id).hide();
}
function lock (id) {
    $("#lib"+id).attr("disabled",true);
    $("#btn_valid"+id).hide();
    $("#btn_cancel"+id).hide();
    $("#btn_update"+id).show();
    $("#btn_del"+id).show();
}
