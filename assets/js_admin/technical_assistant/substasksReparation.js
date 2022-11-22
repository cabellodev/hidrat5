$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getSubstaksReparation();
});

let statesOt = [];

/*Funcion para recuperar las ordenes de trabajo*/
getSubstaksReparation = () => {
    let xhr = new XMLHttpRequest();
    xhr.open("get", `${host_url}/api/atGetSubstaksReparation/`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            let aux = [];
            console.log(data);
            if(data){
                data.forEach((item)=>{
                    if(item.check_at == '1'){
                        if(item.check_tm == '0') {
                            substak = 
                            {
                                number_ot : item.number_ot,
                                id: item.subtask_id,
                                date : item.date,
                                substask: item.substask,
                                check_tm: 'No Aprobado',
                                check_at: 'Realizado',
                                time_init: item.time_init,
                                aux: item.aux,
                                time_end: item.time_end,
                            }
                            aux.push(substak);
                        } 
                    }else{
                        substak = 
                        {
                            number_ot : item.number_ot,
                            id: item.subtask_id,
                            date : item.date,
                            substask: item.substask,
                            check_tm: 'No Aprobado',
                            check_at: 'No Realizado',
                            time_init: item.time_init,
                            aux: item.aux,
                            time_end: item.time_end,
                        }
                        aux.push(substak);
                    } 
                }); 
                tabla.clear();
                tabla.rows.add(aux);	
                tabla.order( [ 7, 'asc' ] ).draw();  
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las subtareas",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#tableSubstaksReparations').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [6] ,
        },
        {
            className: "text-center", "targets": [7] ,
        },
    ],
	columns: [
        { data: "number_ot"}, 
        { data: "id" }, 
        { data: "date" }, 
        { data: "substask" }, 
        { data: "check_at" },  
        { data: "check_tm" }, 
        { defaultContent: "tec",
            "render": function (data, type, row){
                console.log(row);
                if(row.check_at === 'Realizado'){
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
        { defaultContent: "oc",
            "render": function (data, type, row){
                if(row.check_at === 'Realizado'){
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

$("#tableSubstaksReparations").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_approve"){
        approve(data);
    }else if($(this)[0].name == "tr_btn_play"){
        show_play(data);
    }else if($(this)[0].name == "tr_btn_stop"){
        show_stop(data);
    }else if($(this)[0].name == "tr_btn_play_continue"){
        show_continue(data);
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
            title: `Aprobar Subtarea de Reparación`,
            icon: "warning",
            text: `Esta  segur@ de marcar como realizada la subtarea de la reparación asiganda a la ot n°:${item.number_ot}?, esta acción es irreversible`,
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
                    id: item.id,
                    name: 'subtask_reparation'
                }
                $.ajax({
                    type: "POST",
                    url: host_url + "api/atApproveSubstakReparation",
                    data: {data},
                    dataType: "json",
                    success: () => {
                     swal({
                         title: "Éxito!",
                         icon: "success",
                         text: "Subtarea de reparación actualizada con éxito.",
                         button: "OK",
                     }).then(() => {
                        getSubstaksReparation();
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
    }else if(op == 1 || op == 2){
        swal({
            title: `Aprobar Subtarea de Reparación`,
            icon: "warning",
            text: `No puede aprobar la subtarea de reparación, debe `+text,
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
        title: `Comenzar Subtarea de la Reapración`,
        icon: "warning",
        text: `¿Esta seguro de comenzar la subtarea de reparación asociada a la OT ${data.number_ot}"?`,
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
        title: `Continuar Subtarea de Reparación`,
        icon: "warning",
        text: `¿Esta seguro de reanudar la subtarea de reparación asociada a la OT ${data.number_ot}"?`,
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
        title: `Pausar Subtarea de Reparación`,
        icon: "warning",
        text: `¿Esta seguro de pausar la subtarea de reparación asociada a la OT ${data.number_ot}"?`,
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
        name: 'subtask_reparation'
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
            getSubstaksReparation();
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