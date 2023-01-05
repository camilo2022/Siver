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

$(document).ready(function(){
    var lote_ref_inicial = $("#lote").val();
    var lote_inicial = $("#cant_lote").val();

$("#actu_refe").click(function() {
    var URLdominio = getAbsolutePath();
    var id = $("#id").val();
    var url = URLdominio +id +"/referencias_update";
    var refe = $("#refe").val();
    var lote = $("#lote").val();
    var cant_lote = $("#cant_lote").val();
    var cant_prep_emb_prc = $("#cant_prep_emb_prc").val();
    var cant_prep_emb_rlj = $("#cant_prep_emb_rlj").val();
    var cant_prep_pin = $("#cant_prep_pin").val();
    var cant_prep_cot = $("#cant_prep_cot").val();
    var cant_prep_col = $("#cant_prep_col").val();
    var cant_prep_prc = $("#cant_prep_prc").val();
    var cant_conf = $("#cant_conf").val();
    
    var cant_ensa_prt = $("#cant_ensa_prt").val();
    var cant_ensa_pnt = $("#cant_ensa_pnt").val();
    var cant_ensa_bot = $("#cant_ensa_bot").val();
    var cant_ensa_bot_pln = $("#cant_ensa_bot_pln").val();
    var cant_ensa_prs = $("#cant_ensa_prs").val();
    var cant_ensa_pas_prs = $("#cant_ensa_pas_prs").val();
    var cant_ensa_pas_mol = $("#cant_ensa_pas_mol").val();
    var cant_ensa_ojal = $("#cant_ensa_ojal").val();
    var cant_ensa_rvs = $("#cant_ensa_rvs").val();
    var cant_ensa_rvs_ext = $("#cant_ensa_rvs_ext").val();
    var cant_ensa_rvs_prs = $("#cant_ensa_rvs_prs").val();
    
    var cant_term_des = $("#cant_term_des").val();
    var cant_term_tac = $("#cant_term_tac").val();
    var cant_term_pla = $("#cant_term_pla").val();
    var cant_term_mes = $("#cant_term_mes").val();
    var tc_refe = $("#tc_refe").val();
    if(refe == "" || lote == "" || cant_lote == "" || tc_refe=="" || cant_conf=="" || cant_term_des=="" || cant_term_tac=="" || cant_term_pla=="" || cant_term_mes==""){
          swal("¡Hay campos vacios!", "Debe ingresar una Referencia, lote, cantidad y tiempo de ciclo del lote.", "warning"); 
    }else{
    $.ajax({
          url: url,
          type: 'GET',
          data: {
            id: id,
            refe: refe,
            lote: lote,
            cant_lote: cant_lote,
            cant_prep_emb_prc: cant_prep_emb_prc,
            cant_prep_emb_rlj: cant_prep_emb_rlj,
            cant_prep_pin: cant_prep_pin,
            cant_prep_cot: cant_prep_cot,
            cant_prep_col: cant_prep_col,
            cant_prep_prc: cant_prep_prc,
            cant_conf: cant_conf,
            cant_ensa_prt: cant_ensa_prt,
            cant_ensa_pnt: cant_ensa_pnt,
            cant_ensa_bot: cant_ensa_bot,
            cant_ensa_bot_pln: cant_ensa_bot_pln,
            cant_ensa_prs: cant_ensa_prs,
            cant_ensa_pas_prs: cant_ensa_pas_prs,
            cant_ensa_pas_mol: cant_ensa_pas_mol,
            cant_ensa_ojal: cant_ensa_ojal,
            cant_ensa_rvs: cant_ensa_rvs,
            cant_ensa_rvs_ext: cant_ensa_rvs_ext,
            cant_ensa_rvs_prs: cant_ensa_rvs_prs,
            cant_term_des: cant_term_des,
            cant_term_tac: cant_term_tac,
            cant_term_pla: cant_term_pla,
            cant_term_mes: cant_term_mes,
            tc_refe: tc_refe
          },
          dataType: 'json',
          success: function(data){  
            if(data==1){
                window.location = "https://siversoftware.zarethpremium.com/referencias/list";
            }else if(data==2){
                swal("Oops!", "El lote de Referencia ya existe.", "error");
                $("#lote").val(lote_ref_inicial);
            }
        }
          });
    }
});
});   ;