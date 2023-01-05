function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
  }
$(document).ready(function(){

$("#agregar_refe").click(function() {
    var URLdominio = getAbsolutePath();
    var url = URLdominio + "referencias_store";
    var refe = $("#refe").val();
    var lote = $("#lote").val();
    var cant_lote = $("#cant_lote").val();
    var tc_refe = $("#tc_refe").val();
    if(refe == "" || lote == "" || cant_lote == "" || tc_refe==""){
          swal("¡Hay campos vacios!", "Debe ingresar una Referencia, lote, cantidad y tiempo de ciclo del lote.", "warning"); 
    }else{
    $.ajax({
          url: url,
          type: 'GET',
          data: {
            refe: refe,
            lote: lote,
            cant_lote: cant_lote,
            tc_refe: tc_refe
          },
          dataType: 'json',
          success: function(data){  
            if(data==1){
                swal("¡Error!", "El lote de Referencia ya Existe.", "error");
            }else{
                swal("¡Bien!", "Datos guardados con Exito", "success"); 
                $("#id_refe").val(data[0]['id']);
                $("#referencia").val(data[0]['lote_referencia']);
            }
        }
          });
          $("#refe").val("");
          $("#lote").val("");
          $("#cant_lote").val("");
          $("#cant_conf").val("");
          $("#cant_term_des").val("");
          $("#cant_term_tac").val("");
          $("#cant_term_pla").val("");
          $("#cant_term_mes").val("");
          $("#tc_refe").val("");
    }
});
});       ;