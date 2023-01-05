
function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
  }
  function ShowSelected(){
    $("#cantidad").val(0);
  }
    $(document).ready(function(){
    $("#agregar_no_prg").click(function() {
        var URLdominio = getAbsolutePath();
        var url = URLdominio + "parada_no_prg_store";

        var no_prg = $("#no_prg").val();
        if(no_prg == ""){
            swal("¡Hay campos vacios!", "Debe ingresar una Parada no Programada.", "warning"); 
        }else{
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                no_prg: no_prg,
            },
            dataType: 'json',
            success: function(data){     
                    swal("¡Bien!", "Datos guardados con Exito", "success");
                    $("#tipo_pno_prgm")
                    .append(
                    $("<option></option>")
                    .attr("value", data[0]['id'])
                    .text(data[0]['tipo_parada_noprg'])
                    )     
                    },
            error: function(jqXHR,error, errorThrown){
                    swal("¡Error!", "No se guardaron los datos Ingresados.", "error");
                    }
            });
            $("#no_prg").val("");
        }
    });

    $("#agregar_prg").click(function() {
        var URLdominio = getAbsolutePath();
        var url = URLdominio + "parada_prg_store";
        var prg = $("#prg").val();
        var tprg = $("#tprg").val();
        if(prg == "" || tprg == ""){
            swal("¡Hay campos vacios!", "Debe ingresar una Parada Programada y el Tiempo.", "warning"); 
        }else{
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                prg: prg,
                tprg: tprg,
            },
            dataType: 'json',
            success: function(data){     
                    swal("¡Bien!", "Datos guardados con Exito", "success");
                    $("#tipo_p_prgm")
                    .append(
                    $("<option></option>")
                    .attr("value", data[0]['id'])
                    .text(data[0]['tipo_parada_prg'])
                    )     
                    },
            error: function(jqXHR,error, errorThrown){
                    swal("¡Error!", "No se guardaron los datos Ingresados.", "error");
                    }
            });
            $("#prg").val("");
            $("#tprg").val("");
        }
    });

    $("#tiempo_r").keyup(function() {
    var time = $("#tiempo_r").val()
    if(time>1 || time<0){
        swal({
        title: "¡Cuidado!",
        text: "El rango de tiempo debe ser entre 0 y 1.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        $("#tiempo_r").val(0)
    }
    })

    $("#modulo").click(function(){
        $("#cantidad").val("")
    })

    $("#cantidad").keyup(function(){
        const boton = document.getElementById("submitEditar");
        boton.setAttribute('disabled', "true");
    })

    $("#cantidad").blur(function(){
    var URLdominio = getAbsolutePath();
    var id = $("#id").val();
    var url = URLdominio + id + "/consulta_lote";
    var cantidad = $("#cantidad").val();
    var id_refe = document.getElementById("referencia").value;
    var modulo = $("#modulo").val();
    if(cantidad!="" && id_refe==""){
        swal("¡Complete los siguientes datos para realizar la consulta!", "Modulo y Referencia.", "warning");
        $("#cantidad").val("");
    }else if(cantidad!="" && id_refe!=""){
        $.ajax({
            url: url,
            type: 'GET',
            data: {
                id: id,
                cantidad: cantidad,
                id_refe: id_refe,
                modulo: modulo,
            },
            dataType: 'json',
            success: function(data){    
                    if(data[0]==1){
                        swal("¡Bien!", "Ingresada: "+data[1]+". Disponible: "+ data[2]+". Nueva: "+ data[3] , "success")
                    }else if(data[0]==2){
                        swal("¡Error!", "Ingresada: "+data[1]+". Disponible: "+ data[2]+". Nueva: "+ data[3] , "error")
                        $("#cantidad").val("");
                    }
                    },
            });
    }
    const boton = document.getElementById("submitEditar");
    boton.removeAttribute('disabled')
    });


    $('#submitEditar').click(function(){
    var URLdominio = getAbsolutePath();
    var id = $("#id").val();
    var url = URLdominio + id + "/ensamble_update";
    var fecha = $("#fecha").val();
    var turno = $("#turno").val();
    var modulo = $("#modulo").val();
    var id_empl = document.getElementById("empleado").value;
    var id_refe = document.getElementById("referencia").value;
    var tallas = $("#tallas").val();
    var tc = $("#tc").val();
    var tipo = $("#tipo").val();
    var hora = $("#hora").val();
    var cantidad = $("#cantidad").val();
    var tiempo_r = $("#tiempo_r").val();
    var n_operarios = $("#n_operarios").val();
    var tipo_p_prgm = $("#tipo_p_prgm").val();
    var tipo_pno_prgm = $("#tipo_pno_prgm").val();
    var tiempo_pno_prgm = $("#tiempo_pno_prgm").val();

    if($("#fecha").val() == ""){
        swal("¡Error!", "El campo Fecha es requerido.", "error");
    }else if($("#tc").val() == ""){
        swal("¡Error!", "El campo Tiempo de Ciclo es requerido.", "error");
    }else if($("#tiempo_r").val() == ""){
        swal("¡Error!", "El campo Tiempo Requerido en Horas es requerido.", "error");
    }else{
        $.ajax({
        url: url,
        type: 'GET',
        data: {
            id: id,
            fecha:fecha,
            turno:turno,
            modulo:modulo,
            id_empl: id_empl,
            id_refe:id_refe,
            tallas:tallas,
            tc:tc,
            tipo:tipo,
            hora:hora,
            cantidad:cantidad,
            tiempo_r:tiempo_r,
            n_operarios:n_operarios,
            tipo_p_prgm:tipo_p_prgm,
            tipo_pno_prgm:tipo_pno_prgm,
            tiempo_pno_prgm:tiempo_pno_prgm
        },
        dataType: 'json',
        success: function(data){  
            if(data==1){
                window.location = "https://siversoftware.zarethpremium.com/ensamble/list/hoy";
            }  
            if(data==2){
                swal("¡Oops!", "La suma de tiempo requerido en horas sobrepasa el limite.", "error");
            }  
                },
        });
    }

    })

});;