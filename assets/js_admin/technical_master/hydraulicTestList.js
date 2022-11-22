$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});


$(() => {
    get_orders_ht();

});


get_orders_ht = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getHydraulicTestEnable`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
         
            $global=[];
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);
             config = JSON.parse(item.config);
             report = 
                  {
                      number_ot : item.number_ot,
                      priority: item.priority,
                      technical : interaction ? interaction.date_create :"" ,
                      date : validation ? validation.date_ht : "Pendiente",
                      conclusion : validation ? validation.conclusion : "",
                      notes : validation ? validation.notes : "",
                      enterprise : item.enterprise,
                      component : item.component,
                      service : item.service,
		              description:item.description,
                      approve_technical:  validation.approve_technical=="true"? "Realizado":"No realizado",
                      approve_admin:  validation.approve_admin == "true"?  "Aprobado":"No aprobado",
                      time_init: item.time_init,
                      aux: item.aux,
                      time_end: item.time_end,

                  }
                console.log(report.approve_technical);
                  
                 $global.push(report);
                });



            tabla.clear();
			tabla.rows.add($global);	
			tabla.order( [ 1, 'desc' ] ).draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "El usuario no tiene asignado pruebas hidraulicas",
			});
		}
	});
	xhr.send();
};

const tabla = $('#table_ht').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    columnDefs: [
        {className: "text-center", "targets": [5,6,7,8]},
    ],
	columns: [
        { data: "number_ot"},
        { data: "date" },
        { data: "enterprise" } ,
		{ data:"description"},	
        { data: "approve_technical"},
        { data: "approve_admin" },
		{ data: "service" },
        { defaultContent: "oc",
        "render": function (data, type, row){
            if(row.approve_technical === 'Realizado'){
                return `<button type='button' class='btn btn-primary'>
                Finalizado
                </button>`
            }else{
                if(row.time_init){
                    if(row.aux){
                        return `<button name='tr_btn_play_continue' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`
                    }else{
                        return `<button name='tr_btn_stop' class="btn btn-warning rounded-circle"><i class="fas fa-pause"></i></button>` 
                    }      
                }else{
                    return `<button name='tr_btn_play' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`      
                }
            }
        }
     },
     // end defaultContent
     { defaultContent: "oc",
     "render": function (data, type, row){
      if(row.approve_technical === 'Realizado'){
          return `<button type='button' name='show_ht' class='btn btn-primary'>
          Ver informe
          <i class="fas fa-search"></i>
          </button>`
      }else{
          if(row.time_init){
              if(row.aux){
                  return `<button type='button' name='show_ht' class='btn btn-primary'>
          Ver informe
          <i class="fas fa-search"></i>
          </button>`
              }else{
                  return `<button type='button' name='btn_edit_ht' class='btn btn-warning'>Realizar<i class="fas fa-pencil-alt"></i></button>`  
              }  
          }else{  
              return `<button type='button' name='show_ht' class='btn btn-primary'>
          Ver informe
          <i class="fas fa-search"></i>
          </button>`
          }
      }
     }
  },
  {
    defaultContent: `<button type='button' name='btn_images' class='btn btn-success'>
                        Imagenes
                        <i class="fas fa-images"></i>
                    </button>`,                    
    },
	
	
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/
$("#table_ht").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_edit_ht") {
        let ot = data.number_ot;
		let url = 'hydraylicTestForm'+'?ot='+ot;
		window.location.assign(host_url+url);
	}else if($(this)[0].name == "show_ht"){
            let ot = data.number_ot;
            let url = 'hydraylicTestFormView'+'?ot='+ot;
            window.location.assign(host_url+url);
        }if($(this)[0].name == "tr_btn_play"){
            show_play(data);
        }else if($(this)[0].name == "tr_btn_stop"){
            show_stop(data);
        }else if($(this)[0].name == "tr_btn_play_continue"){
            show_continue(data);
        }if($(this)[0].name == "btn_images"){
            let ot = data.number_ot;
            let url = 'adminImages'+'?ot='+ot;
            window.location.assign(host_url+url);
        }
    
});


show_play = (data) =>{
    swal({
        title: `Comenzar Informe Técnico`,
        icon: "warning",
        text: `¿Esta seguro de comenzar la prueba hidráulica asociada a la OT ${data.number_ot}"?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "play",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "play") {
            chronometer(data, 'iniciado');
        } else {
            swal.close();
        }
    });
}

/*Función para preparar la información a des/habilitar*/
show_continue = (data) =>{
    swal({
        title: `Continuar Informe Técnico`,
        icon: "warning",
        text: `¿Esta seguro de reanudar la prueba hidráulica asociada a la OT ${data.number_ot}"?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "continue",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "continue") {
            chronometer(data, 'reanudado');
        } else {
            swal.close();
        }
    });
}

/*Función para preparar la información a des/habilitar*/
show_stop = (data) =>{
    swal({
        title: `Pausar el Informe Técnico`,
        icon: "warning",
        text: `¿Esta seguro de pausar la prueba hidráulica asociada a la OT ${data.number_ot}"?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "stop",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "stop") {
            chronometer(data, 'detenido');
        } else {
            swal.close();
        }
    });
}


chronometer = (data, msg) =>{
    datos = {
        ot_id : data.number_ot,
        msg: msg
    } 
    $.ajax({
        type: "POST",
        url: host_url + "api/chronometer/HydraylicTest",
        data: {datos},
        dataType: "json",
        success: (result) => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: result.msg,
             button: "OK",
         }).then(() => {
            get_orders_ht();
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



  



