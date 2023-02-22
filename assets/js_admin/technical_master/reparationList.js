$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getReparations();
});

let statesOt = [];

/*Funcion para recuperar las ordenes de trabajo*/
getReparations = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/tmGetReparation`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            let aux = [];
            console.log(data);
            data.forEach((item)=>{

                let priority = '';
                if(item.priority == '1'){
                    priority = 'Baja';
                }else if(item.priority == '2'){
                    priority = 'Media'
                }else if(item.priority == '3'){
                    priority = 'Alta'
                }else{
                    priority = 'NE'
                }

                if(item.check_technical == '1'){
                    if(item.check_adm == '0') {
                        reparation = 
                        {
                            number_ot : item.number_ot,
                            date : item.date,
                            client: item.client,
				            description:item.description,
                            component: item.component,
                            service : item.service,
                            date_reparation: item.date_limit,
                            priority: priority,
                            check_technical: 'Realizado',
                            check_adm: 'No Aprobado',
                            time_init: item.time_init,
                            aux: item.aux,
                            time_end: item.time_end,
                        }
                        aux.push(reparation);
                    } 
                }else{
                    reparation = 
                    {
                        number_ot : item.number_ot,
			             description:item.description,
                        date : item.date,
                        client: item.client,
                        component: item.component,
                        priority: priority,
                        date_reparation: item.date_limit,
                        service : item.service,
                        check_technical: 'No Realizado',
                        check_adm: 'No Aprobado',
                        time_init: item.time_init,
                        aux: item.aux,
                        time_end: item.time_end,
                    }
                    aux.push(reparation);
                } 
            });
            console.log(aux);
            tabla.clear();
            tabla.rows.add(aux);	


            let late_rep = localStorage.getItem('view_rep'); // true or false
            let search_rep = localStorage.getItem('search_rep'); // number , null or ""
            
        
            if(late_rep){
               tabla.order( [ 7 , 'asc' ] ).search(search_rep).draw();
               localStorage.setItem('view_rep',false);
               localStorage.setItem('search_rep',"");
                
            }else{
                tabla.order( [ 7 , 'asc' ] ).search("").draw();
            }
               
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las reparaciones",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#tableReparations').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [8,9,10,11] ,
        },
    ],
	columns: [
        { data: "number_ot"}, 
        { data: "date" }, 
        { data: "date_reparation" }, 
        { data: "client" } ,
		{data:"description"},	
        { data: "priority" }, 
        { data: "service" }, 
        { data: "check_technical" }, 
        { data: "check_adm" }, 
        { defaultContent: "tec",
            "render": function (data, type, row){
                console.log(row);
                if(row.check_technical === 'Realizado'){
                    return `<button type='button' class='btn btn-primary'>
                    Finalizado
                    </button>`
                }else{
                    if(row.time_init){
                        if(row.aux){
                            state = { 
                                number_ot : row.number_ot, val : 2,
                            }
                            if (!statesOt.find(o => o.number_ot === row.number_ot && o.val === 1)) statesOt.push(state);
                            return `<button name='tr_btn_play_continue' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`
                        }else{
                            state = {
                                number_ot : row.number_ot, val : 0,
                            }
                            if (!statesOt.find(o => o.number_ot === row.number_ot && o.val === 0)) statesOt.push(state);
                            return `<button name='tr_btn_stop' class="btn btn-warning rounded-circle"><i class="fas fa-pause"></i></button>` 
                        }      
                    }else{
                        state = {
                            number_ot : row.number_ot, val : 1,
                        }
                        if (!statesOt.find(o => o.number_ot === row.number_ot && o.val === 1)) statesOt.push(state);
                        return `<button name='tr_btn_play' class="btn btn-success rounded-circle"><i class="fas fa-play"></i></button>`      
                    }
                }
            }
        },
        {   defaultContent: "oc",
        "render": function (data, type, row){
            if(row.check_technical === 'Realizado'){
                return `<button type='button' name='btn_substaks' class='btn btn-primary'>
                    Ver  <i class="fas fa-tasks"></i>
                </button>`
            }else{
                if(row.time_init){   
                    return `<button type='button'  name='btn_substaks'  class='btn btn-warning'>
                    Asignar <i class="fas fa-tasks"></i>
                    </button>`
                }else{  
                    return `<button type='button' name='btn_substaks' class='btn btn-primary'>
                    Ver  <i class="fas fa-tasks"></i>
                    </button>`
                }
            }
            }
        },// end defaultContent
        {
            defaultContent: `<button type='button' name='btn_images' class='btn btn-success'>
                                Imágenes
                                <i class="fas fa-images"></i>
                            </button>`,                    
        },

        { defaultContent: "oc",
            "render": function (data, type, row){
                if(row.check_technical === 'Realizado'){
                    return `<button type='button' class='btn btn-primary'>
                    Realizado
                    </button>`
                }else{
                    return `<button type='button' name='btn_approve' class='btn btn-warning'>
                    Check Realizado
                    <i class="fas fa-pencil-alt"></i>
                    </button>`
                }
            }
        },
	],
});


$("#tableReparations").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_substaks") {
        let ot = data.number_ot;
		let url = 'tmAdminSubstasks/reparation/index'+'?ot='+ot;
		window.location.assign(host_url+url);
	}else if ($(this)[0].name == "btn_approve"){
        approve(data);
    }else if($(this)[0].name == "tr_btn_play"){
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

approve = (item) => {
    let op;
    let text;
    statesOt.forEach((state)=>{
        if(state.number_ot == item.number_ot){
            op = state.val;
        }
    });
    if(op == 1) text = 'inciar primero'; else if(op ==2) text = 'reanudar primero'

    if(op == 0){
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
                    id: item.number_ot,
                }
                $.ajax({
                    data: {
                        data,
                    },
                    type: "POST",
                    url: host_url + `api/getSubstaksByReparation`,
                    crossOrigin: false,
                    dataType: "json",
                    success: (result) => {
                        console.log(result);
                        if(result == 0){
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
                                    getReparations();
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
                        }else{
                            swal({
                                title: "Denegado!",
                                icon: "error",
                                text: 'No puede aprobar porque ha subtareas pendientes',
                            }).then(() => {
                             swal.close();
                            });
                        }
                    },
                    error: (result) => {
                        swal({
                            title: "Denegado!",
                            icon: "error",
                            text: 'No puede aprobar porque ha subtareas pendientes',
                        }).then(() => {
                         swal.close();
                        });
                    },
                });
            }
        });
    }else if(op == 1 || op == 2){
        swal({
            title: `Aprobar Reparación`,
            icon: "warning",
            text: `No puede aprobar la reparación, debe `+text,
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
        });
    }
}

show_play = (data) =>{
    swal({
        title: `Comenzar la Reapración`,
        icon: "warning",
        text: `¿Esta seguro de comenzar la reparación asociada a la OT ${data.number_ot}"?`,
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
        title: `Continuar Reparación`,
        icon: "warning",
        text: `¿Esta seguro de reanudar la reparación asociada a la OT ${data.number_ot}"?`,
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
        title: `Pausar Reparación`,
        icon: "warning",
        text: `¿Esta seguro de pausar la reparación asociada a la OT ${data.number_ot}"?`,
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
        msg: msg,
        name: 'reparation'
    } 
    $.ajax({
        type: "POST",
        url: host_url + "api/chronometer",
        data: {datos},
        dataType: "json",
        success: (result) => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: result.msg,
             button: "OK",
         }).then(() => {
            getReparations();
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

	

	
	
