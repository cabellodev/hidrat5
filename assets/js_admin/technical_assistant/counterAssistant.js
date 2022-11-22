$(() => {
      get_subtask_ev();
      get_subtask_rep();
   
  
  });
  
  const tabla = $("#table-orders").DataTable({
      language: {
          url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      columns: [
          { data: "number_ot" },
          { data: "date" },
          { data: "substask" },
         
          {
              defaultContent: `<button type='button' name='btn_admin' class='btn btn-primary'>
                                    Administrar
                                    <i class="fas fa-edit"></i>
                                </button>`,
          },
      ],
  });
  
  let aux_ev;
  let aux_rep;
  let ev =false;
  let rep =false;
  get_subtask_ev= () => {
      let xhr = new XMLHttpRequest();
      xhr.open("get", `${host_url}/api/counterAssistant`);
      xhr.responseType = "json";
      xhr.addEventListener("load", () => {
          if (xhr.status === 200) {
              let data =xhr.response;
              console.log(data);
              aux_ev = data.subtask_ev;
              $("#subtask_ev").html(aux_ev.length);
          } 
        
       });

      xhr.send();
  };

  get_subtask_rep= () => {
    let xhr = new XMLHttpRequest();
    xhr.open("get", `${host_url}/api/counterAssistant`);
    xhr.responseType = "json";
    xhr.addEventListener("load", () => {
        if (xhr.status === 200) {
            
            let data =xhr.response;
            aux_rep = data.subtask_rep;
            console.log(aux_rep);
            $("#subtask_rep").html(aux_rep.length);
        } 
      
     });

    xhr.send();
};
  
  
  loadDataModal = (title, data) => {
      $("#titlemodal").html(title);
      tabla.clear();
      tabla.rows.add(data);
      tabla.draw();
  };
  
  
  
  $("#btnEvaluation").on("click", () => {
      ev = true;
      rep = false;
      loadDataModal("Subtareas de evaluaciones ", aux_ev);
      $("#modal").modal("show");
  });
  
  $("#btnReparation").on("click", () => {
    ev = false;
    rep = true;
      loadDataModal("Subtareas de reparaciones ", aux_rep);
      $("#modal").modal("show");
  });
  
  
  approve = (item) => {
      swal({
          title: `Aprobar Reparación`,
          icon: "warning",
          text: `Esta  segur@ de marcar como realizada la reparación de la ot n°:${item.number_ot}?, esta acción es irreversible`,
          buttons: {
              confirm: {
                  text: `Confirmar`,
                  value: "approve",
              },
              cancel: {
                  text: "Cancelar",
                  value: "cancelar",
                  visible: true,
              },
          },
      }).then((action) => {
          if (action == "approve") {
              data = {
                  ot_id: item.number_ot,
              }
              $.ajax({
                  type: "POST",
                  url: host_url + "api/tmApproveReparation",
                  data: {data},
                  dataType: "json",
                  success: () => {
                   swal({
                       title: "Éxito!",
                       icon: "success",
                       text: "Reparación actualizada con éxito.",
                       button: "OK",
                   }).then(() => {
                      get_orders_reparation();
                   });
                  }, 
                  error: () => {
                      swal({
                          title: "Error",
                          icon: "error",
                          text: "No se pudo encontrar el recurso",
                      }).then(() => {
                          $("body").removeClass("loading");
                      });
                  },
              });  
  
          }
      });
  
  }
  
  
  $("#btnTechnicalReports").on("click", () => {
      urlRedirect = 'technicalReport';
      loadDataModal("Informes técnicos por realizar", technicalsReports);
      $("#modal").modal("show");
  });
  
  $("#btnReparations").on("click", () => {
      $("#modalReparation").modal("show");
  });
  
  
  $("#table-orders").on("click", "button", function () {
      let data = tabla.row($(this).parents("tr")).data();
      if ($(this)[0].name == "btn_admin") {
               if (ev){
                window.location.assign(host_url+`atAdminSubstaksEvaluation`);
               }else if(rep){
              window.location.assign(host_url+`atAdminSubstaksReparation`);}
      }
    }
  );
  
 
  
  