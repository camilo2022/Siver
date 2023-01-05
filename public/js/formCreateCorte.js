{
      function getAbsolutePath() {
            var loc = window.location;
            var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
            return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
          }


      $(document).ready(function(){

      $("#agregarTela").click(function() {
            var URLdominio = getAbsolutePath();
            var url = URLdominio + "telaCreateC";

            var codigoT = $("#codtela").val();
            var nombreT = $("#nametela").val();
            if(codigoT == "" || nombreT == ""){
                  swal("¡Hay campos vacios!", "Debe ingresar un codigo y nombre.", "warning"); 
            }else{
            $.ajax({
                  url: url,
                  type: 'GET',
                  data: {
                        codigo: codigoT,
                        tela: nombreT
                  },
                  dataType: 'json',
                  success: function(data){     
                        swal("¡Bien!", "Datos guardados con Exito", "success");
                        $("#tela")
                        .append(
                        $("<option></option>")
                        .attr("value", data['id'])
                        .text(data['tela'])
                              )     
                        },
                  error: function(jqXHR,error, errorThrown){
                        swal("¡Error!", "No se guardaron los datos Ingresados.", "error");
                        }
                  });
                  $("#codtela").val("");
                  $("#nametela").val("");
            }
      });

      $('#submitCrearCorte').click(function(){
            if( $("#coleccion").val() == "" ){
                swal("¡Error!", "El campo Coleccion es requerido", "error");
            }else if( $("#ncorte").val() == "" ){
                swal("¡Error!", "El campo N°Corte es requerido", "error");
            }else if( $("#referencia").val() == "" ){
                swal("¡Error!", "El campo Referencia es requerido", "error");
            }else if( $("#letra").val() == "" ){
                swal("¡Error!", "El campo Letra es requerido", "error");
            }else if( document.forms["CrearCorte"]["tela"].selectedIndex == "" ){
                swal("¡Error!", "Seleccione una Tela", "error");
            }else if( $("#ancho").val() == "" ){
                swal("¡Error!", "El campo Ancho es requerido", "error");
            }else if( $("#fecha").val() == "" ){
                swal("¡Error!", "El campo Fecha es requerido", "error");
            }else if( $("#ribete").val() == "" ){
                swal("¡Error!", "El campo Ribete es requerido", "error");
            }else if( $("#trazo_pasadores").val() == "" ){
                swal("¡Error!", "El campo Trazo Pasadores es requerido", "error");
            }else if( $("#trazo_aletillones").val() == "" ){
                swal("¡Error!", "El campo Trazo Aletillones es requerido", "error");
            }else if( document.forms["CrearCorte"]["foto_D"].value == "" ){
                swal("¡Error!", "El campo Foto Delantera es requerido", "error");
            }else if( document.forms["CrearCorte"]["foto_T"].value == "" ){
                swal("¡Error!", "El campo Foto Trasera es requerido", "error");
            }else if( $("#rollos").val() == "" ){
                swal("¡Error!", "Seleccione los rollos a utilizar", "error");
            }else{
            swal("¡Bien!", "Datos guardados con Exito", "success");           
                $('#CrearCorte').submit();
            }
      });

      setTimeout(function () {
            $(".loader-page").css({visibility:"hidden",opacity:"0"})
      }, 1000);

      function valoresIniciales(){
            sumCantidad();
            sumCantidadesTallas();
            sumCantidad2(); 
            restaCantidadTotales();
            metrosReales();
            promedioYcantCM2();
            largoTelaBTelaD();
            if(isNaN(document.getElementById('cantcm2').innerHTML)){
                  document.getElementById('cantcm2').innerHTML = 0;
            }
      };
      valoresIniciales();

      $(".cant").keyup(function() {
            sumCantidad();
            sumCantidadesTallas();
            restaCantidadTotales();
            metrosReales();
            promedioYcantCM2();
            largoTelaBTelaD();
            for(let i=1;i<=21;i++){
            let can = "cantidad".concat(i);
            $("#"+can).blur(function(){
                  if($("#"+can).val()==""){
                        $("#"+can).val(0)
                  }
                  valoresIniciales();
                  });
            }
      });

      $(".total2").keyup(function() {
            sumCantidad2();
            restaCantidadTotales();   
            promedioYcantCM2();
            for(let i=4;i<=24;i+=2){
            let talN = "tallaN".concat(i);
            $("#"+talN).blur(function(){
                  if($("#"+talN).val()==""){
                        $("#"+talN).val(0);
                  }
            });
            }
      });

      $("#ancho").keyup(function() {
            promedioYcantCM2();
      });

      function sumCantidad(){
            var total = 0; 
            $(".cant").each(function() { 
              if (isNaN(parseFloat($(this).val()))) {
                total += 0;
              } else {
                total += parseFloat($(this).val());
              }
            });
            $("#spTotal").val(total);
      };

      function sumCantidad2(){
            var sumTotal2 = 0; 
            $(".total2").each(function() { 
              if (isNaN(parseFloat($(this).val()))) {
                sumTotal2 += 0;
              } else {
                sumTotal2 += parseFloat($(this).val());
              }
            });
            //alert(total);
            document.getElementById('Total2').innerHTML = sumTotal2;
      };

      function restaCantidadTotales(){
            let dif4 = $("#tallaN4").val() - $("#n4").val();
            $("#difN4").val(dif4);

            let dif6 = $("#tallaN6").val() - $("#n6").val();
            $("#difN6").val(dif6);

            let dif8 = $("#tallaN8").val() - $("#n8").val();
            $("#difN8").val(dif8);

            let dif10 = $("#tallaN10").val() - $("#n10").val();
            $("#difN10").val(dif10);

            let dif12 = $("#tallaN12").val() - $("#n12").val();
            $("#difN12").val(dif12);

            let dif14 = $("#tallaN14").val() - $("#n14").val();
            $("#difN14").val(dif14);

            let dif16 = $("#tallaN16").val() - $("#n16").val();
            $("#difN16").val(dif16);

            let dif18 = $("#tallaN18").val() - $("#n18").val();
            $("#difN18").val(dif18);

            let dif20 = $("#tallaN20").val() - $("#n20").val();
            $("#difN20").val(dif20);

            let dif22 = $("#tallaN22").val() - $("#n22").val();
            $("#difN22").val(dif22);

            let dif24 = $("#tallaN24").val() - $("#n24").val();
            $("#difN24").val(dif24);

            let difTotal3 =  document.getElementById('Total2').innerHTML - document.getElementById('Total1').innerHTML;
            document.getElementById('difTotal3').innerHTML = difTotal3;
      };

      function sumCantidadesTallas(){
            let cant4=0;let cant6=0;let cant8=0;let cant10=0;let cant12=0;let cant14=0;let cant16=0;let cant18=0;let cant20=0;let cant22=0;let cant24=0;
            for(let i=1;i<=21;i++){
                  var tal = "talla".concat(i);
                  var can = "cantidad".concat(i);
                  
                  if($("#"+tal).val() == 4){
                        cant4 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 6){
                        cant6 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 8){
                        cant8 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 10){
                        cant10 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 12){
                        cant12 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 14){
                        cant14 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 16){
                        cant16 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 18){
                        cant18 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 20){
                        cant20 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 22){
                        cant22 += parseInt($("#"+can).val());
                  }else if($("#"+tal).val() == 24){
                        cant24 += parseInt($("#"+can).val());
                  }

                  $("#n4").val(cant4);
                  $("#n6").val(cant6);
                  $("#n8").val(cant8);
                  $("#n10").val(cant10);
                  $("#n12").val(cant12);
                  $("#n14").val(cant14);
                  $("#n16").val(cant16);
                  $("#n18").val(cant18);
                  $("#n20").val(cant20);
                  $("#n22").val(cant22);
                  $("#n24").val(cant24);
                  let sumTotal1=cant4+cant6+cant8+cant10+cant12+cant14+cant16+cant18+cant20+cant22+cant24;
                  document.getElementById('Total1').innerHTML = sumTotal1;

                  let difTotal3 =  document.getElementById('Total2').innerHTML - document.getElementById('Total1').innerHTML;
                  document.getElementById('difTotal3').innerHTML = difTotal3;
            }
      };

      function metrosReales(){
            let mtrs = 0;
            let largo = 0;
            let cantidad = 0;
            for(let i=1;i<=21;i++){
                  var lar = "largo".concat(i);
                  var can = "cantidad".concat(i);

                        if( $("#"+lar).val() != largo || $("#"+can).val() != cantidad ){

                        mtrs += $("#"+lar).val() * $("#"+can).val();
                        }
                  largo = $("#"+lar).val();
                  cantidad = $("#"+can).val();
            }
            mtrs += $("#ribete").val() * $("#tendidos_1").val();
            $("#metros").val(mtrs.toFixed(3));
      };

      function promedioYcantCM2(){
            let prom = $("#metros").val() / $("#spTotal").val();
            $("#promedio").val(prom.toFixed(3));
            let cantcm2 = $("#ancho").val() * 10000 * prom;
            document.getElementById('cantcm2').innerHTML = Math.round(cantcm2);
      };

      $(".telas").keyup(function(){
            largoTelaBTelaD();
      });
      
      function largoTelaBTelaD(){
            let mtrsTB = $("#largot2_tela_bolsillo").val() * $("#tendida2_tela_bolsillo").val();
           $("#metroTB").val(mtrsTB);

           let mtrsTD = $("#largot2_tela_dos").val() * $("#tendida2_tela_dos").val();
           $("#metroTD").val(mtrsTD);

           let promTB = mtrsTB / $("#spTotal").val();
            $("#promedioTB").val(promTB.toFixed(3));

            let promTD = mtrsTD / $("#spTotal").val();
            $("#promedioTD").val(promTD.toFixed(3));
      };

      $("#referencia").keyup(function() {
            let ref = $('#referencia').val();
            ref = ref.substr(0,3).toUpperCase();
            if(ref[0] == "1"){
        $("#marca").val('ZARETH PREMIUM');
        }else if(ref[0] == "2"){
        $("#marca").val('STARA GIRLS');
        }else if(ref[0] == '3'){
	  $("#marca").val('STARA');
        }else if(ref[0] == '4'){
	  $("#marca").val('ZARETH TEENS');
        }else if(ref[0] == '5'){
        $("#marca").val('BLESS');
        }else if(ref[0] == '6'){
        $("#marca").val('BLESS 23 JUNIOR');
        }else if(ref[0] == '7'){
        $("#marca").val('ZARETH');
        }else if(ref[0] == '8'){
        $("#marca").val('BLESS 23');
        }else if(ref[0] == '9'){
        $("#marca").val('SHIREL');
        }else if(ref[0] == 'H'){
        $("#marca").val('STARA MEN');
        }else if(ref[0] == 'E'){
        $("#marca").val('ZARETH EXPORTACION');
        }else if(ref[0] == 'S'){
            if(ref[0] == 'S' && ref[1] == 'T' && ref[2] == 'G'){
            $("#marca").val('STARA BLUSAS');
            }else{
		$("#marca").val('SIN DEFINIR');
            }
        }else if(ref[0] == 'L'){
            if(ref[0] == 'L' && ref[1] == 'R'){
		$("#marca").val('LOA RIGIDO');
            }else if(ref[0] == 'L' && ref[1] == 'S'){
		$("#marca").val('LOA STRECH');
            }else{
		$("#marca").val('LOA');
            }
        }else if(ref[0] == 'M'){
	    $("#marca").val('MICHELL V');
        }else if(ref[0] == 'F'){
            if(ref[0] == 'F' && ref[1] == 'V'){
		$("#marca").val('FIANCHI VIP');
            }else if(ref[0] == 'F' && ref[1] == 'R'){
		$("#marca").val('FARFALLA');
            }else{
		$("#marca").val('FLOW');
            } 
        }else if(ref[0] == 'B'){
            if(ref[0] == 'B' && ref[1] == 'Z'){
		$("#marca").val('ESTILOS BZ');
            }else{
		$("#marca").val('ZARETH CURVE PLUS');
            } 
        }else if(ref[0] == 'D'){
	  $("#marca").val('DHARA');
        }else if(ref[0] == 'Z'){
	  $("#marca").val('OZONO');
        }else if(ref[0] == 'K'){
	  $("#marca").val('STARA KIDS');
        }else if(ref[0] == 'C'){
            if(ref[0] == 'C' && ref[1] == 'R'){
		$("#marca").val('CALIFORNIA');
            }else if(ref[0] == 'C' && ref[1] == 'M'){
		$("#marca").val('CALIFORNIA MEN');
            }else if(ref[0] == 'C' && ref[1] == 'K'){
		$("#marca").val('CALIFORNIA KIDS');
            }else if(ref[0] == 'C' && ref[1] == 'T'){
		$("#marca").val('CALIFORNIA TEENS');
            }else if(ref[0] == 'C' && ref[1] == 'V'){
		$("#marca").val('CURVE LOS ANGELES');
            }else{
		$("#marca").val('CLASIC SHIREL');
            }
        }else if(ref[0] == 'P'){
	    $("#marca").val('ZARETH PREMIUM');
        }else if(ref[0] == 'O'){
	    $("#marca").val('BLESS ORIGINAL');
        }else if(ref[0] == 'A'){
		$("#marca").val('ALFA LEGACY');
        }else if(ref[0] == 'N'){
            if(ref[0] == 'N' && ref[1] == 'K'){
		$("#marca").val('NEON KIDS');
            }else if(ref[0] == 'N' && ref[1] == 'B'){
		$("#marca").val('NEON CAMISA NIﾃ前');
            }else{
		$("#marca").val('NEON PANTALON');
            }
        }else if(ref[0] == 'Y'){
            if(ref[0] == 'Y' && ref[1] == 'D'){
		$("#marca").val('NEW YORK');
            }else if(ref[0] == 'Y' && ref[1] == 'B'){
		$("#marca").val('NEW YORK PLUS');
            }else if(ref[0] == 'Y' && ref[1] == 'G'){
		$("#marca").val('NEW YORK PLUS');
            }else if(ref[0] == 'Y' && ref[1] == 'M'){
		$("#marca").val('NEW YORK MEN');
            }else if(ref[0] == 'Y' && ref[1] == 'K'){
		$("#marca").val('NEW YORK KIDS');
            }else if(ref[0] == 'Y' && ref[1] == 'T'){
		$("#marca").val('NEW YORK TEENS');
            }else{
		$("#marca").val('NEW YORK');
            }
        }else if($('#referencia').val()==""){
            $("#marca").val('');
      }
      });

      $(".largo").keyup(function(){
            sumCantidad();
            sumCantidadesTallas();
            restaCantidadTotales();
            metrosReales();
            promedioYcantCM2();
            largoTelaBTelaD();
            for(let i=1;i<=21;i++){
                  let lar = "largo".concat(i);
                  let tal = "talla".concat(i);
                  let can = "cantidad".concat(i);
                  let inf = "info".concat(i);
                  $("#"+lar).blur(function(){
                        if($("#"+lar).val()==""){
                              $("#"+lar).val(0);
                              $("#"+tal).val(0);
                              $("#"+can).val(0);
                              $("#"+inf).val("");
                        }
                        valoresIniciales();
                        });
                  }
      });

      $(".talla").keyup(function(){
            for(let i=1;i<=21;i++){
                  let tal = "talla".concat(i);
                  valoresIniciales();
                  $("#"+tal).blur(function(){
                        if($("#"+tal).val()==""){
                              $("#"+tal).val(0)
                        }
                        });
                  }
      });

      });

      }{
        const $seleccionArchivos = document.querySelector("#foto_D"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacionD");

        // Escuchar cuando cambie
        $seleccionArchivos.addEventListener("change", () => {
        // Los archivos seleccionados, pueden ser muchos o uno
        const archivos = $seleccionArchivos.files;
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        // Ahora tomamos el primer archivo, el cual vamos a previsualizar
        const primerArchivo = archivos[0];
        // Lo convertimos a un objeto de tipo objectURL
        const objectURL = URL.createObjectURL(primerArchivo);
        // Y a la fuente de la imagen le ponemos el objectURL
        $imagenPrevisualizacion.src = objectURL;
        });
      }{
        const $seleccionArchivos = document.querySelector("#foto_T"),
        $imagenPrevisualizacion = document.querySelector("#imagenPrevisualizacionT");

        // Escuchar cuando cambie
        $seleccionArchivos.addEventListener("change", () => {
        // Los archivos seleccionados, pueden ser muchos o uno
        const archivos = $seleccionArchivos.files;
        // Si no hay archivos salimos de la función y quitamos la imagen
        if (!archivos || !archivos.length) {
            $imagenPrevisualizacion.src = "";
            return;
        }
        // Ahora tomamos el primer archivo, el cual vamos a previsualizar
        const primerArchivo = archivos[0];
        // Lo convertimos a un objeto de tipo objectURL
        const objectURL = URL.createObjectURL(primerArchivo);
        // Y a la fuente de la imagen le ponemos el objectURL
        $imagenPrevisualizacion.src = objectURL;
        });
      };