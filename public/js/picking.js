function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    function selectTipo(){
        let tipo = $("#tipo").val()
        if (tipo == "Sku"){
            $('.sku').show();
            $('.tonos').hide();
            $('.referencia').hide();
            $('.tono').hide();
            $("#tonos").val("")
            $("#registrar").hide();
            $("#referencia").val("");
            $("#tono").val("");
        }
        if (tipo == "Referencia"){
            $('.tonos').show();
            $('.sku').hide();
            $("#registrar").hide();
            $("#sku").val("");
        }
    }
    function selectTono(){
        let tonos = $("#tonos").val()
        
        if (tonos == "Con Tono"){
            $('.referencia').show();
            $('.tono').show();
            $("#registrar").hide();
            $("#registrar").hide();
            $("#referencia").val("");
            $("#tono").val("");
        }
        if (tonos == "Sin Tono"){
            $('.tonos').show();
            $('.referencia').show();
            $('.tono').hide();
            $("#registrar").hide();
            $("#referencia").val("");
            $("#tono").val("");
        }
    }
        $(document).ready(function(){
            var referencia;
            document.getElementById("ingreso_codigo").setAttribute('disabled', "true");
            $('.sku').hide();
            $('.tonos').hide();
            $('.referencia').hide();
            $('.tono').hide();
            $("#registrar").hide();
            
            $('#items').DataTable({})
            $("#codigos").html("");
    
            $("#ingreso_codigo").keyup(function(e) {
                var URLdominio = getAbsolutePath();
                var url = URLdominio + "picking_consulta";
                if(e.which == 13){
                    var bol = new Boolean(false);
                    var newbol = new Boolean(true);

                    if($("#tipo").val() == "Sku"){
                        var refe_ing = $("#ingreso_codigo").val();
                        if(referencia == refe_ing.toUpperCase()){
                            bol = new Boolean(true);
                        }
                    }
                    
                    
                    if($("#tipo").val() == "Referencia"){
                        
                        if($("#tonos").val() == "Sin Tono"){
                            var cadena = $("#ingreso_codigo").val().split("");
                            var refe_ing = "";
                            for (let i=0; i < cadena.length; i++) {
                                if(cadena[i]!="-"){
                                    refe_ing = refe_ing+""+cadena[i];
                                }else if(cadena[i]=="-"){
                                    break;
                                }
                            }
                            refe_ing = refe_ing.toUpperCase();
                            if(referencia == refe_ing){
                                bol = new Boolean(true);
                            }
                        }
                        
                        if($("#tonos").val() == "Con Tono"){
                            var cadena = $("#ingreso_codigo").val().split("");
                            var refe_ing = "";
                            var x = 0;
                            for (let i=0; i < cadena.length; i++) {
                                if(cadena[i]=="-"){
                                    x++;
                                    if(x==2){
                                        break;
                                    }
                                }
                                if(x<2){
                                    refe_ing = refe_ing+""+cadena[i];
                                }
                            }
                            if(referencia == refe_ing.toUpperCase()){
                                bol = new Boolean(true);
                            }
                        }
                    }

                    if(bol == true){
                        valoresIniciales(bol, newbol)
                    }else if(newbol == true){
                        var refe_ing = $("#ingreso_codigo").val();
                        $.ajax({
                                url: url,
                                type: 'GET',
                                data: {
                                    refe_ing:refe_ing,
                                },
                                dataType: 'json',
                                success: function(response){ 
                                    if(response==1){
                                        valoresIniciales(bol, newbol)
                                    }else if(response == 2){
                                        Swal.fire(
                                            '¡Oops!',
                                            'El valor ingresado no coincide con el valor inicial.',
                                            'error'
                                        )
                                        $("#ingreso_codigo").val("");
                                    }
                                },
                            })
                    }else if(bol == false){
                        Swal.fire(
                            '¡Oops!',
                            'El valor ingresado no coincide con el valor inicial.',
                            'error'
                        )
                        $("#ingreso_codigo").val("");
                    }
                }
            })
            
            $("#sku").keyup(function() {
                if($("#tipo").val()=="Sku"){
                    referencia = $("#sku").val();
                    if($("#sku").val()!=""){
                    $("#registrar").show();
                    }else{
                    $("#registrar").hide();
                    }
                }
            })
            
            $("#referencia").keyup(function() {
                if($("#tipo").val()=="Referencia"){
                    if($("#tonos").val()=="Sin Tono"){
                        referencia = $("#referencia").val();
                        if($("#referencia").val()!=""){
                            $("#registrar").show();
                        }else{
                            $("#registrar").hide();
                        }
                    }else{
                        referencia = $("#referencia").val()+"-"+$("#tono").val();
                        if($("#referencia").val()!="" && $("#tono").val()!=""){
                            $("#registrar").show();
                        }else{
                            $("#registrar").hide();
                        }
                    }
                }
            })
            
            $("#tono").keyup(function() {
                if($("#tipo").val()=="Referencia"){
                    referencia = $("#referencia").val()+"-"+$("#tono").val();
                    if($("#tono").val()!="" && $("#referencia").val()!=""){
                        $("#registrar").show();
                    }else{
                        $("#registrar").hide();
                    }
                }
            })
            
            
            
            $("#registrar").click(function(){
                $(".tipo").hide();
                $('.sku').hide();
                $('.tonos').hide();
                $('.referencia').hide();
                $('.tono').hide();
                $("#registrar").hide();
                document.getElementById("ingreso_codigo").removeAttribute("disabled");
                document.getElementById("span").innerHTML = referencia.toUpperCase();
                referencia = referencia.toUpperCase();
                Swal.fire({
                  icon: 'success',
                  title: referencia.toUpperCase() ,
                  text: '¡Se guardó la referencia! Ahora solo podrá ingresar de esa referencia.',
                })
            })
    
    
            $("#guardar").click(function(){
                Swal.fire({
                  title: '¿Está seguro?',
                  text: "¡Se guardaran los datos y no podrá modificarlos!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: '¡Si, Guardar!'
                }).then((result) => {
                  if (result.isConfirmed) {    
                        const resume_table = document.getElementById("cod_ing");
                        const tableRows = document.querySelectorAll('#cod_ing tr.fila');
                        const itemsArray = [];
                        for(let i=0; i<tableRows.length; i++) {
                            let row = tableRows[i];
                            let status = row.querySelector('.referencia');
                                itemsArray.push(status.innerText);
                        }
                        var table = $('#items').DataTable();
                        var data = table.rows().data();
                        const tableDinamicArray = [];
                        
                        for(let i=0; i<data.length; i++) {
                            tableDinamicArray.push(data[i]);
                        }
                        console.log(tableDinamicArray)
        
                        var URLdominio = getAbsolutePath();
                        var url = URLdominio + "picking_store";
                        let userid = document.querySelector('meta[name="user-id"]').content;
                        $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            itemsArray:itemsArray,
                            tableDinamicArray:tableDinamicArray,
                            userid:userid
                        },
                        dataType: 'json',
                        success: function(data){  
                            if(data==1){
                                Swal.fire({
                                icon: 'success',
                                title: '¡Buen Trabajo!',
                                text: 'Se guardaron los datos Correctamente.',
                                })
                                location.reload();
                            }
                        },
                        });
                  }
                })
            })
    
            $(document).on('click', '.borrar', function(event) {
                
                Swal.fire({
                  title: '¿Está Seguro?',
                  text: "¡Se eliminará este item!",
                  icon: 'warning',
                  showCancelButton: true,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'Si, ¡Eliminar!'
                }).then((result) => {
                  if (result.isConfirmed) {
                    event.preventDefault();
                    $(this).closest('tr').remove();
                    resetTable()
                    Swal.fire(
                      '¡Eliminado!',
                      'El item se eliminó.',
                      'success'
                    )
                  }
                })
            });

            function resetTable(){
                $('#items').DataTable().destroy().draw();
                const resume_table = document.getElementById("cod_ing");
                const tableRows = document.querySelectorAll('#cod_ing tr.fila');
                const itemsArray = [];
                for(let i=0; i<tableRows.length; i++) {
                    const row = tableRows[i];
                    const status = row.querySelector('.referencia');
                        itemsArray.push(status.innerText);
                }
                let unico = [...new Set(itemsArray)];
                unico = unico.sort();
                var newArray = [];
                let sum = 0;
                for(let i=0;i<unico.length;i++){
                    for(let j=0;j<itemsArray.length;j++){
                        if(itemsArray[j]==unico[i]){
                            sum++;
                        }
                    }
                    newArray.push([unico[i],sum]);
                    sum=0;
                }
                
                $(document).ready(function(){
                    var dataTable = $('#items').DataTable({})
                    $('#items').css({"text-align": "center",});
                })
                
                $("#body").html("");
                let total = 0;
                      for(var i=0; i<newArray.length; i++){
                        total = total + newArray[i][1];
                        var tr = `<tr>
                          <td>`+newArray[i][0]+`</td>
                          <td>`+newArray[i][1]+`</td>
                        </tr>`;
                        $("#body").append(tr)
                      }
                      document.getElementById("total").innerHTML = total;
            }
    
            function valoresIniciales(bol, newbol){
                $('#items').DataTable().destroy().draw();
                var cod;
                if(bol == true){
                    cod = $("#ingreso_codigo").val().toUpperCase();
                }else if(newbol == true){
                    cod = referencia + " " + $("#ingreso_codigo").val().toUpperCase();
                }

                if(cod != ""){  
                    var tr = `<tr class="fila">
                        <td class="referencia">`+cod+`</td>
                        <td><a type="button" class="borrar" style="cursor: pointer;"><span class="badge badge-danger"><i class="fa fa-solid fa-trash"></i></span></a></td></tr>`;
                        $("#codigos").append(tr)
                }
                $("#ingreso_codigo").val("")
    
                const resume_table = document.getElementById("cod_ing");
                const tableRows = document.querySelectorAll('#cod_ing tr.fila');
                const itemsArray = [];
                for(let i=0; i<tableRows.length; i++) {
                    const row = tableRows[i];
                    const status = row.querySelector('.referencia');
                        itemsArray.push(status.innerText);
                }
                let unico = [...new Set(itemsArray)];
                unico = unico.sort();
                var newArray = [];
                let sum = 0;
                for(let i=0;i<unico.length;i++){
                    for(let j=0;j<itemsArray.length;j++){
                        if(itemsArray[j]==unico[i]){
                            sum++;
                        }
                    }
                    newArray.push([unico[i],sum]);
                    sum=0;
                }
                
                $(document).ready(function(){
                    var dataTable = $('#items').DataTable({})
                    $('#items').css({"text-align": "center",});
                })
                
                $("#body").html("");
                let total = 0;
                      for(var i=0; i<newArray.length; i++){
                        total = total + newArray[i][1];
                        var tr = `<tr>
                          <td>`+newArray[i][0]+`</td>
                          <td>`+newArray[i][1]+`</td>
                        </tr>`;
                        $("#body").append(tr)
                      }
                      document.getElementById("total").innerHTML = total;
            }
    });