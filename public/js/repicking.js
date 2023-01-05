function getAbsolutePath() {
    var loc = window.location;
    var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
    return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    
        $(document).ready(function(){
            var referencia = document.getElementById("referencia").innerHTML;
            var tipo = document.getElementById("tipo").innerHTML;
            $('#items').DataTable({})
            
            $("#ingreso_codigo").keyup(function(e) {
                var URLdominio = getAbsolutePath();
                let id = $("#id").val();
                var url = URLdominio +"picking_consulta";
                if(e.which == 13){
                    var bol = new Boolean(false);
                    var newbol = new Boolean(true);

                        if(tipo == "SKU"){
                            var refe_ing = $("#ingreso_codigo").val();
                            var arraySku = referencia.split(",");
                            for (let i = 0; i < arraySku.length; i++) {
                                if(arraySku[i].trim() == refe_ing.toUpperCase().trim()){
                                    bol = new Boolean(true);
                                }
                            }
                            
                        }
                        
                        if(tipo == "REF"){
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
                        
                        if(tipo == "REF-T"){
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
                                        var arraySku = referencia.split(",");
                                        if(tipo!="SKU"){
                                            valoresIniciales(bol, newbol)
                                        }else{
                                            Swal.fire({
                                                title: '¡Seleccione al Sku que corresponde!',
                                                input: 'select',
                                                inputOptions: {
                                                  Seleccione: arraySku
                                                },
                                                didOpen: () => {
                                                    Swal.getInput().addEventListener('change', () => {
                                                       Swal.getInput().value
                                                    })
                                                }
                                              }).then((result) => {
                                                let value = result.value;
                                                if(value!=undefined){
                                                    valoresIniciales(bol, newbol, value)
                                                }
                                              })
                                        }
                                    }else if(response == 2){
                                        Swal.fire(
                                            '¡Oops!',
                                            'El valor ingresado no coincide con el valor inicial.',
                                            'error'
                                        )
                                        $("#ingreso_codigo").val("");
                                    }
                                },
                                error: function(jqXHR,error, errorThrown){
                                    Swal.fire("¡Oops!", "Ocurrió un error.", "error");
                                }
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
                        //console.log(tableDinamicArray)        
                        var URLdominio = getAbsolutePath();
                        let id = $("#id").val();
                        var url = "http://127.0.0.1:8000/bodega_repicking/picking_store";
                        console.log()
                        let token = $("meta[name='csrf-token']").attr("content");
                        var dataSend = {
                            id: id,
                            itemsArray:itemsArray,
                            tableDinamicArray:tableDinamicArray,
                            _token:token
                        };
                        //let userid = document.querySelector('meta[name="user-id"]').content;
                        $.ajax({
                            url: url,
                            type: 'POST',
                            data: dataSend,
                        dataType: 'json',
                            success: function(data){  
                                /*if(data[0]==1 && data[1]=='Terminacion'){
                                    Swal.fire({
                                    icon: 'success',
                                    title: '¡Buen Trabajo!',
                                    text: 'Se guardaron los datos Correctamente.',
                                    }).then(() => {
                                        window.location = "http://127.0.0.1:8000/terminacion_picking/list";
                                    })   
                                }*/
                                if(data[0]==1 && data[1]=='Bodega'){
                                    Swal.fire({
                                    icon: 'success',
                                    title: '¡Buen Trabajo!',
                                    text: 'Se guardaron los datos Correctamente.',
                                    }).then(() => {
                                        window.location = "http://127.0.0.1:8000/bodega_picking/list/gestion";
                                    })   
                                }
                                if(data[0]==2 && data[1]=='Bodega'){
                                    Swal.fire({
                                    icon: 'warning',
                                    title: '¡Buen Trabajo!',
                                    text: 'Se guardaron los datos Correctamente, pero los datos no concuerdan. Pongase en contacto con el administrador.',
                                    }).then(() => {
                                        window.location = "http://127.0.0.1:8000/bodega_picking/list/gestion";
                                    })
                                }
                            },
                        })
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

            function consultaCantidad(cod, sum_cant){
                var URLdominio = getAbsolutePath();
                let id = $("#id").val();
                var url = URLdominio +"consulta_cantidad";
                $.ajax({
                    url: url,
                    type: 'GET',
                    data: {
                        sum_cant:sum_cant,
                        cod:cod,
                        id:id
                    },
                    dataType: 'json',
                    success: function(response){ 
                        if(response == 2){
                            Swal.fire("¡Ojo!", "Ese articulo no aparece en el registro inicial.", "warning");
                        }
                        if(response[0] == 1){
                            Swal.fire("¡POR FAVOR VERIFIQUE!", "La cantidad registrada para el item "+response[1]+" es de "+response[3]+" y lleva "+response[2]+" en el recuento.", "warning");
                        }
                    }
                })
            }

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
    
            function valoresIniciales(bol, newbol, sku){
                $('#items').DataTable().destroy().draw();
                var cod;
                if(bol == true){
                    cod = $("#ingreso_codigo").val().toUpperCase();
                }else if(newbol == true){
                    if(tipo!="SKU"){
                        cod = referencia + " " + $("#ingreso_codigo").val().toUpperCase();
                    }else{
                        var arraySku = referencia.split(",");
                        cod = arraySku[sku] + " " + $("#ingreso_codigo").val().toUpperCase();
                    }
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
                let sum_cant = 0;
                      for(var i=0; i<newArray.length; i++){
                        if(newArray[i][0]==cod){
                            sum_cant += newArray[i][1];
                        }
                        total = total + newArray[i][1];
                        var tr = `<tr>
                          <td>`+newArray[i][0]+`</td>
                          <td>`+newArray[i][1]+`</td>
                        </tr>`;
                        $("#body").append(tr)
                      }
                      document.getElementById("total").innerHTML = total;
                      consultaCantidad(cod,sum_cant);
            }
    });