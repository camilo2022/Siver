class Accordion {
    constructor(domNode) {
      this.rootEl = domNode;
      this.buttonEl = this.rootEl.querySelector('button[aria-expanded]');
  
      const controlsId = this.buttonEl.getAttribute('aria-controls');
      this.contentEl = document.getElementById(controlsId);
  
      this.open = this.buttonEl.getAttribute('aria-expanded') === 'true';
  
      // add event listeners
      this.buttonEl.addEventListener('click', this.onButtonClick.bind(this));
    }
    onButtonClick() {
      this.toggle(!this.open);
    }
    toggle(open) {
      // don't do anything if the open state doesn't change
      if (open === this.open) {
        return;
      }
  
      // update the internal state
      this.open = open;
  
      // handle DOM updates
      this.buttonEl.setAttribute('aria-expanded', `${open}`);
      if (open) {
        this.contentEl.removeAttribute('hidden');
      } else {
        this.contentEl.setAttribute('hidden', '');
      }
    }
    open() {
      this.toggle(true);
    }
  
    close() {
      this.toggle(false);
    }
      }
  
      const accordions = document.querySelectorAll('.accordion h3');
      accordions.forEach((accordionEl) => {
      new Accordion(accordionEl);
  });
  
  function getAbsolutePath() {
      var loc = window.location;
      var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
      return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }
    
    function ShowSelected(){
        /* Para obtener el valor */

        var URLdominio = getAbsolutePath();
            var url = URLdominio + "referencia_validar";
            var lote_refe = document.getElementById("referencia").value;    
            console.log(lote_refe)
            if(lote_refe != ""){
              $.ajax({
                  url: url,
                  type: 'GET',
                  data: {
                    lote_refe: lote_refe,
                  },
                  dataType: 'json',
                  success: function(data){  
                    if(data==1){
                        swal("¡Oops!", "El lote de Referencia no Existe.", "error");
                        $("#id_refe").val("");
                        $("#referencia").val("");
                        $("#cant_lote").val("");
                        $("#cant_rev").val("");
                    }else{
                        swal("¡Bien!", "Lote de Referencia encontrado", "success"); 
                        $("#cant_lote").val(data[0]['cantidad_lote']);
                        var cant_lote = data[0]['cantidad_lote'];
  
                        if(cant_lote>=2 && cant_lote<=8){
                          $("#cant_rev").val(3);
                        }else if(cant_lote>=9 && cant_lote<=15){
                          $("#cant_rev").val(5);
                        }else if(cant_lote>=16 && cant_lote<=25){
                          $("#cant_rev").val(8);
                        }else if(cant_lote>=26 && cant_lote<=50){
                          $("#cant_rev").val(13);
                        }else if(cant_lote>=51 && cant_lote<=90){
                          $("#cant_rev").val(20);
                        }else if(cant_lote>=91 && cant_lote<=150){
                          $("#cant_rev").val(32);
                        }else if(cant_lote>=151 && cant_lote<=280){
                          $("#cant_rev").val(50);
                        }else if(cant_lote>=281 && cant_lote<=500){
                          $("#cant_rev").val(80);
                        }else if(cant_lote>=501 && cant_lote<=1200){
                          $("#cant_rev").val(125);
                        }else if(cant_lote>=1201 && cant_lote<=3200){
                          $("#cant_rev").val(200);
                        }
                    }
                }
                  });
                }
                else{
                  $("#cant_lote").val("")
                  $("#cant_rev").val("")
                }
        }
  
      $(document).ready(function(){
         
        $('#textilera').hide();
        $('#patronaje').hide();
        $('#corte').hide();
        $('#maquinas').hide();
        $('#preparacion').hide();
        $('#patinadores').hide();
        $('#modul').hide();
        $('.mod').hide();
         
         $("#modulo").click(function() {
            if($("#modulo").val() == "Textilera"){
                $('#textilera').show();
                $('#sect1').css({"display":"block"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Patronaje"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').show();
                $('#sect2').css({"display":"block"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Corte"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').show();
                $('#sect3').css({"display":"block"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Maquinas Especiales"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').show();
                $('#sect4').css({"display":"block"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Preparacion"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').show();
                $('#sect5').css({"display":"block"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Patinadores"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').show();
                $('#sect6').css({"display":"block"});
                $('#modul').hide();
                $('#sect7').css({"display":"none"});
                $('.mod').hide();
                $('#modulos').val("");
                restaurarValores();
            }else if($("#modulo").val() == "Modulos"){
                $('#textilera').hide();
                $('#sect1').css({"display":"none"});
                $('#patronaje').hide();
                $('#sect2').css({"display":"none"});
                $('#corte').hide();
                $('#sect3').css({"display":"none"});
                $('#maquinas').hide();
                $('#sect4').css({"display":"none"});
                $('#preparacion').hide();
                $('#sect5').css({"display":"none"});
                $('#patinadores').hide();
                $('#sect6').css({"display":"none"});
                $('#modul').show();
                $('#sect7').css({"display":"block"});
                $('.mod').show();
                restaurarValores();
            }
        
        
         })
         
         function restaurarValores(){
         $("#marra").val(0);
         $("#mancha").val(0);
         $("#dos_tonos").val(0);
         $("#t_piezas").val(0);
         $("#piezas_mcor").val(0);
         $("#bota").val(0);
         $("#pretina").val(0);
         $("#presilla").val(0);
         $("#ojal").val(0);
         $("#mol").val(0);
         $("#mecotilla").val(0);
         $("#mecola").val(0);
         $("#prepa_pinza").val(0);
         $("#prepa_relojera").val(0);
         $("#prepa_parche").val(0);
         $("#prepa_cerra").val(0);
         $("#prepa_parcha").val(0);
         $("#caida_parche").val(0);
         $("#marc_parche").val(0);
         $("#marc_pinza").val(0);
         $("#marc_moda").val(0);
         $("#sumn_ins").val(0);
         $("#cierre").val(0);
         $("#cola").val(0);
         $("#cbp").val(0);
         $("#ccos").val(0);
         $("#ccot").val(0);
         $("#cpre").val(0);
         $("#cjot").val(0);
         $("#cpar").val(0);
         $("#cpin").val(0);
         $("#creb").val(0);
         $("#crib").val(0);
         $("#cvis").val(0);
         $("#embparche").val(0);
         $("#fcos").val(0);
         $("#fentp").val(0);
         $("#punta").val(0);
         $("#relojera").val(0);
         $("#roto").val(0);
         $("#tiro").val(0);
         $("#total_pno_conf").val(0);
         $("#total_arr_mod").val(0);
         }
         
        function sumPrendasnoConforme(){
            var text_marra = parseInt($("#marra").val())
            var text_mancha = parseInt($("#mancha").val())
            var text_dos_tonos = parseInt($("#dos_tonos").val())
            
            var patro_t_piezas = parseInt($("#t_piezas").val())
            
            var corte_piezas_mcor = parseInt($("#piezas_mcor").val())
            
            var maqui_bota = parseInt($("#bota").val())
            var maqui_pretina = parseInt($("#pretina").val())
            var maqui_presilla = parseInt($("#presilla").val())
            var maqui_ojal = parseInt($("#ojal").val())
            var maqui_mol = parseInt($("#mol").val())
            var maqui_cotilla = parseInt($("#mecotilla").val())
            var maqui_cola = parseInt($("#mecola").val())
            
            var prepa_pinza = parseInt($("#prepa_pinza").val());
            var prepa_relojera = parseInt($("#prepa_relojera").val());
            var prepa_parche = parseInt($("#prepa_parche").val());
            var prepa_cerra = parseInt($("#prepa_cerra").val());
            var prepa_parcha = parseInt($("#prepa_parcha").val());
            
            var patin_caida_parche = parseInt($("#caida_parche").val());
            var patin_marc_parche = parseInt($("#marc_parche").val());
            var patin_marc_pinza = parseInt($("#marc_pinza").val());
            var patin_marc_moda = parseInt($("#marc_moda").val());
            var patin_sumn_ins = parseInt($("#sumn_ins").val());
            
            var mod_cierre = parseInt($("#cierre").val())
            var mod_cola = parseInt($("#cola").val())
            var mod_cbp = parseInt($("#cbp").val())
            var mod_ccos = parseInt($("#ccos").val())
            var mod_ccot = parseInt($("#ccot").val())
            var mod_cpre = parseInt($("#cpre").val())
            var mod_cjot = parseInt($("#cjot").val())
            var mod_cpar = parseInt($("#cpar").val())
            var mod_cpin = parseInt($("#cpin").val())
            var mod_creb = parseInt($("#creb").val())
            var mod_crib = parseInt($("#crib").val())
            var mod_cvis = parseInt($("#cvis").val())
            var mod_embparche = parseInt($("#embparche").val())
            var mod_fcos = parseInt($("#fcos").val())
            var mod_fentp = parseInt($("#fentp").val())
            var mod_punta = parseInt($("#punta").val())
            var mod_relojera = parseInt($("#relojera").val())
            var mod_roto = parseInt($("#roto").val())
            var mod_tiro = parseInt($("#tiro").val())
           
            var total = (text_marra+text_mancha+text_dos_tonos)+(patro_t_piezas)+(corte_piezas_mcor)+(maqui_bota+maqui_pretina+maqui_presilla+maqui_ojal+maqui_mol+maqui_cotilla+maqui_cola)+(prepa_pinza+prepa_relojera+prepa_parche+prepa_cerra+prepa_parcha)+(patin_caida_parche+patin_marc_parche+patin_marc_pinza+patin_marc_moda+patin_sumn_ins)+(mod_cierre+mod_cola+mod_cbp+mod_ccos+mod_ccot+mod_cpre+mod_cjot+mod_cpar+mod_cpin+mod_creb+mod_crib+mod_cvis+mod_embparche+mod_fcos+mod_fentp+mod_punta+mod_relojera+mod_roto+mod_tiro);
            $("#total_pno_conf").val(total);
        }
  
        function sumArreglosModulos(){
            var mod_cierre = parseInt($("#cierre").val())
            var mod_cola = parseInt($("#cola").val())
            var mod_cbp = parseInt($("#cbp").val())
            var mod_ccos = parseInt($("#ccos").val())
            var mod_ccot = parseInt($("#ccot").val())
            var mod_cpre = parseInt($("#cpre").val())
            var mod_cjot = parseInt($("#cjot").val())
            var mod_cpar = parseInt($("#cpar").val())
            var mod_cpin = parseInt($("#cpin").val())
            var mod_creb = parseInt($("#creb").val())
            var mod_crib = parseInt($("#crib").val())
            var mod_cvis = parseInt($("#cvis").val())
            var mod_embparche = parseInt($("#embparche").val())
            var mod_fcos = parseInt($("#fcos").val())
            var mod_fentp = parseInt($("#fentp").val())
            var mod_punta = parseInt($("#punta").val())
            var mod_relojera = parseInt($("#relojera").val())
            var mod_roto = parseInt($("#roto").val())
            var mod_tiro = parseInt($("#tiro").val())
  
            var total = mod_cierre+mod_cola+mod_cbp+mod_ccos+mod_ccot+mod_cpre+mod_cjot+mod_cpar+mod_cpin+mod_creb+mod_crib+mod_cvis+mod_embparche+mod_fcos+mod_fentp+mod_punta+mod_relojera+mod_roto+mod_tiro;
            $("#total_arr_mod").val(total);
        }
  
        {
          $("#marra").keyup(function(){
              var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#marra").val(0)
            }else{
            sumPrendasnoConforme()
            $("#marra").blur(function(){
            if($("#marra").val()=="" || $("#marra").val()==null || $("#marra").val()==undefined){
              $("#marra").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#mancha").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#mancha").val(0)
            }else{
            sumPrendasnoConforme()
            $("#mancha").blur(function(){
            if($("#mancha").val()=="" || $("#mancha").val()==null || $("#mancha").val()==undefined){
              $("#mancha").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#dos_tonos").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#dos_tonos").val(0)
            }else{
            sumPrendasnoConforme()
            $("#dos_tonos").blur(function(){
            if($("#dos_tonos").val()=="" || $("#dos_tonos").val()==null || $("#dos_tonos").val()==undefined){
              $("#dos_tonos").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#t_piezas").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#t_piezas").val(0)
            }else{
            sumPrendasnoConforme()
            $("#t_piezas").blur(function(){
            if($("#t_piezas").val()=="" || $("#t_piezas").val()==null || $("#t_piezas").val()==undefined){
              $("#t_piezas").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#piezas_mcor").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#piezas_mcor").val(0)
            }else{
            sumPrendasnoConforme()
            $("#piezas_mcor").blur(function(){
            if($("#piezas_mcor").val()=="" || $("#piezas_mcor").val()==null || $("#piezas_mcor").val()==undefined){
              $("#piezas_mcor").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#bota").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#bota").val(0)
            }else{
            sumPrendasnoConforme()
            $("#bota").blur(function(){
            if($("#bota").val()=="" || $("#bota").val()==null || $("#bota").val()==undefined){
              $("#bota").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#pretina").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#pretina").val(0)
            }else{
            sumPrendasnoConforme()
            $("#pretina").blur(function(){
            if($("#pretina").val()=="" || $("#pretina").val()==null || $("#pretina").val()==undefined){
              $("#pretina").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#presilla").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#presilla").val(0)
            }else{
            sumPrendasnoConforme()
            $("#presilla").blur(function(){
            if($("#presilla").val()=="" || $("#presilla").val()==null || $("#presilla").val()==undefined){
              $("#presilla").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#ojal").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#ojal").val(0)
            }else{
            sumPrendasnoConforme()
            $("#ojal").blur(function(){
            if($("#ojal").val()=="" || $("#ojal").val()==null || $("#ojal").val()==undefined){
              $("#ojal").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#mol").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#mol").val(0)
            }else{
            sumPrendasnoConforme()
            $("#mol").blur(function(){
            if($("#mol").val()=="" || $("#mol").val()==null || $("#mol").val()==undefined){
              $("#mol").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#mecotilla").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#mecotilla").val(0)
            }else{
            sumPrendasnoConforme()
            $("#mecotilla").blur(function(){
            if($("#mecotilla").val()=="" || $("#mecotilla").val()==null || $("#mecotilla").val()==undefined){
              $("#mecotilla").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#mecola").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#mecola").val(0)
            }else{
            sumPrendasnoConforme()
            $("#mecola").blur(function(){
            if($("#mecola").val()=="" || $("#mecola").val()==null || $("#mecola").val()==undefined){
              $("#mecola").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#prepa_pinza").keyup(function(){
           var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#prepa_pinza").val(0)
            }else{
            sumPrendasnoConforme()
            $("#prepa_pinza").blur(function(){
            if($("#prepa_pinza").val()=="" || $("#prepa_pinza").val()==null || $("#prepa_pinza").val()==undefined){
              $("#prepa_pinza").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#prepa_relojera").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#prepa_relojera").val(0)
            }else{
            sumPrendasnoConforme()
            $("#prepa_relojera").blur(function(){
            if($("#prepa_relojera").val()=="" || $("#prepa_relojera").val()==null || $("#prepa_relojera").val()==undefined){
              $("#prepa_relojera").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#prepa_parche").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#prepa_parche").val(0)
            }else{
            sumPrendasnoConforme()
            $("#prepa_parche").blur(function(){
            if($("#prepa_parche").val()=="" || $("#prepa_parche").val()==null || $("#prepa_parche").val()==undefined){
              $("#prepa_parche").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#prepa_cerra").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#prepa_cerra").val(0)
            }else{
            sumPrendasnoConforme()
            $("#prepa_cerra").blur(function(){
            if($("#prepa_cerra").val()=="" || $("#prepa_cerra").val()==null || $("#prepa_cerra").val()==undefined){
              $("#prepa_cerra").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#prepa_parcha").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#prepa_parcha").val(0)
            }else{
            sumPrendasnoConforme()
            $("#prepa_parcha").blur(function(){
            if($("#prepa_parcha").val()=="" || $("#prepa_parcha").val()==null || $("#prepa_parcha").val()==undefined){
              $("#prepa_parcha").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#caida_parche").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#caida_parche").val(0)
            }else{
            sumPrendasnoConforme()
            $("#caida_parche").blur(function(){
            if($("#caida_parche").val()=="" || $("#caida_parche").val()==null || $("#caida_parche").val()==undefined){
              $("#caida_parche").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#marc_parche").keyup(function(){
           var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#marc_parche").val(0)
            }else{
            sumPrendasnoConforme()
            $("#marc_parche").blur(function(){
            if($("#marc_parche").val()=="" || $("#marc_parche").val()==null || $("#marc_parche").val()==undefined){
              $("#marc_parche").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#marc_pinza").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#marc_pinza").val(0)
            }else{
            sumPrendasnoConforme()
            $("#marc_pinza").blur(function(){
            if($("#marc_pinza").val()=="" || $("#marc_pinza").val()==null || $("#marc_pinza").val()==undefined){
              $("#marc_pinza").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#marc_moda").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#marc_moda").val(0)
            }else{
            sumPrendasnoConforme()
            $("#marc_moda").blur(function(){
            if($("#marc_moda").val()=="" || $("#marc_moda").val()==null || $("#marc_moda").val()==undefined){
              $("#marc_moda").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
          
          $("#sumn_ins").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#sumn_ins").val(0)
            }else{
            sumPrendasnoConforme()
            $("#sumn_ins").blur(function(){
            if($("#sumn_ins").val()=="" || $("#sumn_ins").val()==null || $("#sumn_ins").val()==undefined){
              $("#sumn_ins").val(0)
              sumPrendasnoConforme()
            }
            });
            }
          });
  
          $("#cierre").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cierre").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cierre").blur(function(){
            if($("#cierre").val()=="" || $("#cierre").val()==null || $("#cierre").val()==undefined){
              $("#cierre").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cola").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cola").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cola").blur(function(){
            if($("#cola").val()=="" || $("#cola").val()==null || $("#cola").val()==undefined){
              $("#cola").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cbp").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cbp").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cbp").blur(function(){
            if($("#cbp").val()=="" || $("#cbp").val()==null || $("#cbp").val()==undefined){
              $("#cbp").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#ccos").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#ccos").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#ccos").blur(function(){
            if($("#ccos").val()=="" || $("#ccos").val()==null || $("#ccos").val()==undefined){
              $("#ccos").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#ccot").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#ccot").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#ccot").blur(function(){
            if($("#ccot").val()=="" || $("#ccot").val()==null || $("#ccot").val()==undefined){
              $("#ccot").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cpre").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cpre").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cpre").blur(function(){
            if($("#cpre").val()=="" || $("#cpre").val()==null || $("#cpre").val()==undefined){
              $("#cpre").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cjot").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cjot").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cjot").blur(function(){
            if($("#cjot").val()=="" || $("#cjot").val()==null || $("#cjot").val()==undefined){
              $("#cjot").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cpar").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cpar").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cpar").blur(function(){
            if($("#cpar").val()=="" || $("#cpar").val()==null || $("#cpar").val()==undefined){
              $("#cpar").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cpin").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cpin").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cpin").blur(function(){
            if($("#cpin").val()=="" || $("#cpin").val()==null || $("#cpin").val()==undefined){
              $("#cpin").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#creb").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#creb").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#creb").blur(function(){
            if($("#creb").val()=="" || $("#creb").val()==null || $("#creb").val()==undefined){
              $("#creb").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#crib").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#crib").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#crib").blur(function(){
            if($("#crib").val()=="" || $("#crib").val()==null || $("#crib").val()==undefined){
              $("#crib").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#cvis").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#cvis").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#cvis").blur(function(){
            if($("#cvis").val()=="" || $("#cvis").val()==null || $("#cvis").val()==undefined){
              $("#cvis").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#embparche").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#embparche").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#embparche").blur(function(){
            if($("#embparche").val()=="" || $("#embparche").val()==null || $("#embparche").val()==undefined){
              $("#embparche").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#fcos").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#fcos").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#fcos").blur(function(){
            if($("#fcos").val()=="" || $("#fcos").val()==null || $("#fcos").val()==undefined){
              $("#fcos").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#fentp").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#fentp").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#fentp").blur(function(){
            if($("#fentp").val()=="" || $("#fentp").val()==null || $("#fentp").val()==undefined){
              $("#fentp").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#punta").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#punta").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#punta").blur(function(){
            if($("#punta").val()=="" || $("#punta").val()==null || $("#punta").val()==undefined){
              $("#punta").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#relojera").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#relojera").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#relojera").blur(function(){
            if($("#relojera").val()=="" || $("#relojera").val()==null || $("#relojera").val()==undefined){
              $("#relojera").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#roto").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#roto").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#roto").blur(function(){
            if($("#roto").val()=="" || $("#roto").val()==null || $("#roto").val()==undefined){
              $("#roto").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
  
          $("#tiro").keyup(function(){
            var refe = document.getElementById("referencia").value;
            if(refe == ""){
              swal("¡Oops!", "Debe seleccionar una Referencia Primero.", "error");
              $("#tiro").val(0)
            }else{
            sumPrendasnoConforme()
            sumArreglosModulos()
            $("#tiro").blur(function(){
            if($("#tiro").val()=="" || $("#tiro").val()==null || $("#tiro").val()==undefined){
              $("#tiro").val(0)
              sumPrendasnoConforme()
              sumArreglosModulos()
            }
            });
            }
          });
        }
        /*
        $("#referencia").click(function() {
            var URLdominio = getAbsolutePath();
            var url = URLdominio + "referencia_validar";
            var lote_refe = $("#referencia").val();    
            if(lote_refe != ""){
              $.ajax({
                  url: url,
                  type: 'GET',
                  data: {
                    lote_refe: lote_refe,
                  },
                  dataType: 'json',
                  success: function(data){  
                    if(data==1){
                        swal("¡Oops!", "El lote de Referencia no Existe.", "error");
                        $("#id_refe").val("");
                        $("#referencia").val("");
                        $("#cant_lote").val("");
                        $("#cant_rev").val("");
                    }else{
                        swal("¡Bien!", "Lote de Referencia encontrado", "success"); 
                        $("#id_refe").val(data[0]['id']);
                        $("#referencia").val(data[0]['lote_referencia']);
                        $("#cant_lote").val(data[0]['cantidad_lote']);
                        var cant_lote = data[0]['cantidad_lote'];
  
                        if(cant_lote>=2 && cant_lote<=8){
                          $("#cant_rev").val(3);
                        }else if(cant_lote>=9 && cant_lote<=15){
                          $("#cant_rev").val(5);
                        }else if(cant_lote>=16 && cant_lote<=25){
                          $("#cant_rev").val(8);
                        }else if(cant_lote>=26 && cant_lote<=50){
                          $("#cant_rev").val(13);
                        }else if(cant_lote>=51 && cant_lote<=90){
                          $("#cant_rev").val(20);
                        }else if(cant_lote>=91 && cant_lote<=150){
                          $("#cant_rev").val(32);
                        }else if(cant_lote>=151 && cant_lote<=280){
                          $("#cant_rev").val(50);
                        }else if(cant_lote>=281 && cant_lote<=500){
                          $("#cant_rev").val(80);
                        }else if(cant_lote>=501 && cant_lote<=1200){
                          $("#cant_rev").val(125);
                        }else if(cant_lote>=1201 && cant_lote<=3200){
                          $("#cant_rev").val(200);
                        }
                    }
                }
                  });
                }
                else{
                  $("#id_refe").val("")
                  $("#cant_lote").val("")
                  $("#cant_rev").val("")
                }
        });
        */
        
  
        $("#agregar_ctrlp").click(function() {
            var URLdominio = getAbsolutePath();
            var url = URLdominio + "prendas_store";
            var fecha = $("#fecha").val();
            var modulo = null;
            if($("#modulo").val() == "Modulos"){
                modulo = $("#modulos").val();
            }else if($("#modulo").val() != "Modulos"){
                modulo = $("#modulo").val();
            }
            var id_refe = document.getElementById("referencia").value;
            var cant_lote = $("#cant_lote").val();
            var cant_rev = $("#cant_rev").val();
            var text_marra = parseInt($("#marra").val())
            var text_mancha = parseInt($("#mancha").val())
            var text_dos_tonos = parseInt($("#dos_tonos").val())
            var patro_t_piezas = parseInt($("#t_piezas").val())
            var corte_piezas_mcor = parseInt($("#piezas_mcor").val())
            var maqui_bota = parseInt($("#bota").val())
            var maqui_pretina = parseInt($("#pretina").val())
            var maqui_presilla = parseInt($("#presilla").val())
            var maqui_ojal = parseInt($("#ojal").val())
            var maqui_mol = parseInt($("#mol").val())
            var maqui_cotilla = parseInt($("#mecotilla").val())
            var maqui_cola = parseInt($("#mecola").val())
            var prepa_pinza = parseInt($("#prepa_pinza").val());
            var prepa_relojera = parseInt($("#prepa_relojera").val());
            var prepa_parche = parseInt($("#prepa_parche").val());
            var prepa_cerra = parseInt($("#prepa_cerra").val());
            var prepa_parcha = parseInt($("#prepa_parcha").val());
            var patin_caida_parche = parseInt($("#caida_parche").val());
            var patin_marc_parche = parseInt($("#marc_parche").val());
            var patin_marc_pinza = parseInt($("#marc_pinza").val());
            var patin_marc_moda = parseInt($("#marc_moda").val());
            var patin_sumn_ins = parseInt($("#sumn_ins").val());
            var mod_cierre = parseInt($("#cierre").val())
            var mod_cola = parseInt($("#cola").val())
            var mod_cos_bolsillo_pos = parseInt($("#cbp").val())
            var mod_cos_costado = parseInt($("#ccos").val())
            var mod_cos_cotilla = parseInt($("#ccot").val())
            var mod_cos_pretina = parseInt($("#cpre").val())
            var mod_cos_jota = parseInt($("#cjot").val())
            var mod_cos_parche = parseInt($("#cpar").val())
            var mod_cos_pinza = parseInt($("#cpin").val())
            var mod_cos_reboque = parseInt($("#creb").val())
            var mod_cos_ribete = parseInt($("#crib").val())
            var mod_cos_vista = parseInt($("#cvis").val())
            var mod_embonado_parche = parseInt($("#embparche").val())
            var mod_filete_costado = parseInt($("#fcos").val())
            var mod_filete_entrepierna = parseInt($("#fentp").val())
            var mod_punta = parseInt($("#punta").val())
            var mod_relojera = parseInt($("#relojera").val())
            var mod_roto = parseInt($("#roto").val())
            var mod_tiro = parseInt($("#tiro").val())
            var total_pno_conf = $("#total_pno_conf").val();
            var total_arr_mod = $("#total_arr_mod").val();
            
            
            if(fecha==""){
              swal("¡Error!", "El campo fecha es requerido.", "error");
            }else if(document.forms["ctrlprendasForm"]["modulo"].selectedIndex == "" ){
              swal("¡Error!", "Seleccione un Proceso.", "error");
            }else if(modulo == null){
              swal("¡Error!", "Seleccione un Modulo.", "error");
            }else if(id_refe==""){
              swal("¡Error!", "Seleccione una Referencia.", "error");
            }else if(parseInt(total_pno_conf)>parseInt(cant_rev)){
              swal("¡Error!", "El total de las Prendas no Conforme no puede ser mayor a la Cantidad de Muestra a Revisar.", "error");
            }else{
            $.ajax({
                  url: url,
                  type: 'GET',
                  data: {
                    fecha: fecha,
                    modulo: modulo,
                    id_refe: id_refe,
                    cant_lote: cant_lote,
                    cant_rev: cant_rev,
                    text_marra: text_marra,
                    text_mancha: text_mancha,
                    text_dos_tonos: text_dos_tonos,
                    patro_t_piezas: patro_t_piezas,
                    corte_piezas_mcor: corte_piezas_mcor,
                    maqui_bota: maqui_bota,
                    maqui_pretina: maqui_pretina,
                    maqui_presilla: maqui_presilla,
                    maqui_ojal: maqui_ojal,
                    maqui_mol: maqui_mol,
                    maqui_cotilla: maqui_cotilla,
                    maqui_cola: maqui_cola,
                    prepa_pinza: prepa_pinza,
                    prepa_relojera: prepa_relojera,
                    prepa_parche: prepa_parche,
                    prepa_cerra: prepa_cerra,
                    prepa_parcha: prepa_parcha,
                    patin_caida_parche: patin_caida_parche,
                    patin_marc_parche: patin_marc_parche,
                    patin_marc_pinza: patin_marc_pinza,
                    patin_marc_moda: patin_marc_moda,
                    patin_sumn_ins: patin_sumn_ins,
                    mod_cierre: mod_cierre,
                    mod_cola: mod_cola,
                    mod_cos_bolsillo_pos: mod_cos_bolsillo_pos,
                    mod_cos_costado: mod_cos_costado,
                    mod_cos_cotilla: mod_cos_cotilla,
                    mod_cos_pretina: mod_cos_pretina,
                    mod_cos_jota: mod_cos_jota,
                    mod_cos_parche: mod_cos_parche,
                    mod_cos_pinza: mod_cos_pinza,
                    mod_cos_reboque: mod_cos_reboque,
                    mod_cos_ribete: mod_cos_ribete,
                    mod_cos_vista: mod_cos_vista,
                    mod_embonado_parche: mod_embonado_parche,
                    mod_filete_costado: mod_filete_costado,
                    mod_filete_entrepierna: mod_filete_entrepierna,
                    mod_punta: mod_punta,
                    mod_relojera: mod_relojera,
                    mod_roto: mod_roto,
                    mod_tiro: mod_tiro,
                    total_pno_conf: total_pno_conf,
                    total_arr_mod: total_arr_mod,
                  },
                  dataType: 'json',
                  success: function(data){  
                    if(data==1){
                      swal("¡Bien!", "Datos guardados con Exito", "success"); 
                      window.location = "https://siversoftware.zarethpremium.com/prendas";
                    }else if(data==2){
                      swal("¡Oops!", "Ya se revisó la referencia es este proceso.", "error");
                    }
                }
                  });
                }
          });
    });