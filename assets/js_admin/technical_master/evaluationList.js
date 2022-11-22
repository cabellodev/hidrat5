$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});


$(() => {
    get_orders_ev();

});


get_orders_ev = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationEnable`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
         
            $global=[];
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);

            if(validation){
                if(validation.approve_technical == "false" && validation.approve_admin== "false" || validation.approve_technical == "true" && validation.approve_admin== "false"){
                   
                  report = 
                    {
                      number_ot : item.number_ot,
                      priority: item.priority,
			          description1:item.description,
                      technical : interaction ? interaction.date_create :"Pendiente" ,
                      date :  validation.date_evaluation == ""? "Pendiente":validation.date_evaluation,
                      description: validation ? validation.description : "",
                      notes : validation ? validation.notes : "",
                      enterprise : item.enterprise,
                      component : item.component,
                      service : item.service,
                      approve_technical:  validation.approve_technical=="true"? "Realizado":"No realizado",
                      approve_admin:  validation.approve_admin == "true"?  "Aprobado":"No aprobado",
                      time_init: item.time_init,
                      aux: item.aux,
                      time_end: item.time_end,
                      date_priority: item.date_priority
                    }
                 $global.push(report);
                 }
                }else {
                   
                    report = 
                    {
                        number_ot : item.number_ot,
                        priority: item.priority,
			            description1:item.description,
                        technical : interaction ? interaction.date_create :"Pendiente" ,
                        date :  'Por realizar',
                        description:  "",
                        notes : "",
                        enterprise : item.enterprise,
                        component : item.component,
                        service : item.service,
                        approve_technical: "No realizado",
                        approve_admin:  "No aprobado",
                        time_init: item.time_init,
                        aux: item.aux,
                        time_end: item.time_end,
                        date_priority: item.date_priority
                         
                    }
                    
                    
                   $global.push(report);

                }
                });

            tabla.clear();
			tabla.rows.add($global);	
			tabla.order( [ 1 , 'desc' ] ).draw();
		} 
	});
	xhr.send();
};

const tabla = $('#table_ev').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    columnDefs: [
        {className: "text-center", "targets": [6,7,8,9]},
        {
			"targets": [ 1 ],
			"visible": false,
			"searchable": false
		},
    ],
	columns: [
        { data: "number_ot"},
        {data:"date_priority"},
        { data: "date" } ,
        { data: "enterprise" } ,
	{data:"description1"},
        { data: "approve_technical"},
        { data: "approve_admin" },
		{ data: "service" },
        {   defaultContent: "oc",
        "render": function (data, type, row){
            if(row.approve_technical === 'Realizado'){
                return `<button type='button' class='btn btn-primary'>
                Finalizado
                </button>`
            /* }else{
                if(row.time_init){
                    if(row.aux){
                        return `<button name='tr_btn_play_continue' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`
                    }else{
                        return `<button name='tr_btn_stop' class="btn btn-warning rounded-circle"><i class="fas fa-pause"></i></button>` 
                    }      
                }else{
                    return `<button name='tr_btn_play' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`      
                }
            } */
            }else{
                if(row.time_init){
                    return `<button type='button' class='btn btn-warning'>
                        En proceso
                        </button>`    
                }else{
                    return `<button name='tr_btn_play' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`      
                }
            }
        }
     },// end defaultContent

    {   defaultContent: "oc",
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
    },// end defaultContent
   
    {   defaultContent: "oc",
    "render": function (data, type, row){
        if(row.approve_technical === 'Realizado'){
            return `<button type='button' name='admin_subtask' class='btn btn-primary'>
                    Ver <i class="fas fa-tasks"></i>
                    </button>` 
        }else{
            if(row.time_init){   
                return `<button type='button' name='admin_subtask' class='btn btn-warning'>
                Asignar <i class="fas fa-tasks"></i>
                </button>`
            }else{  
                return `<button type='button' name='admin_subtask' class='btn btn-primary'>
                Ver <i class="fas fa-tasks"></i>
                </button>` 
            }
        }
        }
    },// end defaultContent
    {
        defaultContent: `<button type='button' name='btn_images' class='btn btn-success'>
                            Imagenes
                            <i class="fas fa-images"></i>
                        </button>`,                    
    },

	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/
$("#table_ev").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_edit_ht") {
        let ot = data.number_ot;
		let url = 'editEvaluation'+'?ot='+ot;
		window.location.assign(host_url+url);
	}else{
        if($(this)[0].name == "show_ht"){
            let ot = data.number_ot;
            let url = 'viewEvaluation'+'?ot='+ot;
            window.location.assign(host_url+url);
        }else if($(this)[0].name == "tr_btn_play"){
            show_play(data);
        }else if($(this)[0].name == "tr_btn_stop"){
            show_stop(data);
        }else if($(this)[0].name == "tr_btn_play_continue"){
            show_continue(data);
        }else if($(this)[0].name == "admin_subtask"){
            let ot = data.number_ot;
            let url = 'subtasksEvaluationList'+'?ot='+ot;
            window.location.assign(host_url+url);
        } if($(this)[0].name == "btn_images"){
		    let ot = data.number_ot;
		    let url = 'adminImages'+'?ot='+ot;
		    window.location.assign(host_url+url);
        }
    }
});



show_play = (data) =>{
    swal({
        title: `Comenzar Informe Técnico`,
        icon: "warning",
        text: `¿Esta seguro de comenzar el informe técnico asociado a la OT ${data.number_ot}"?`,
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
        text: `¿Esta seguro de reanudarel informe de evaluación asociado a la OT ${data.number_ot}"?`,
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
        text: `¿Esta seguro de pausar el informe de evaluación asociado a la OT ${data.number_ot}"?`,
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
        url: host_url + "api/chronometer/evaluation",
        data: {datos},
        dataType: "json",
        success: (result) => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: result.msg,
             button: "OK",
         }).then(() => {
            get_orders_ev();
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



  



