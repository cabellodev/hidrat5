$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getTechnicalReports();
});


/*Funcion para recuperar las ordenes de trabajo*/
getTechnicalReports = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/tmGetTechnicalReport`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            console.log(data);
            if(data){
                $aux=[];
                data.forEach((item)=>{
                    validation = JSON.parse(item.details);
                    if(validation){
                        let date;
                        if(validation.date_technical_report) date = validation.date_technical_report;
                        else date = 'Pendiente';

                        if(validation.check_technical == 'true'){
                            if(validation.check_adm == 'false' || validation.check_adm == '') {
                                report = 
                                {
                                    number_ot : item.number_ot,
                                    date : date,
				                    description:item.description,
                                    enterprise : item.enterprise,
                                    service : item.service,
                                    check_technical: 'Realizado',
                                    check_adm: 'No Aprobado',
                                    time_init: item.time_init,
                                    aux: item.aux,
                                    time_end: item.time_end,
                                    date_priority:item.date_priority
                                }
                                $aux.push(report);
                            }
                        }else{
                            report = 
                            {
                                number_ot : item.number_ot,
                                date : date,
                                client: item.client,
                                enterprise : item.enterprise,
				                description:item.description,
                                component: item.component,
                                service : item.service,
                                check_technical: 'No Realizado',
                                check_adm: 'No Aprobado',
                                time_init: item.time_init,
                                aux: item.aux,
                                time_end: item.time_end,
                                date_priority:item.date_priority
                            }
                            $aux.push(report);
                        }
                    }else{
                        report = 
                        {
                            number_ot : item.number_ot,
                            date : 'Pendiente',
                            service : item.service,
                            enterprise : item.enterprise,
				            description:item.description,
                            check_technical: 'No Realizado',
                            check_adm: 'No Aprobado',
                            time_init: item.time_init,
                            aux: item.aux,
                            time_end: item.time_end,
                            date_priority:item.date_priority
                        }
                        $aux.push(report);
                    }
                });
    
                tabla.clear();
                tabla.rows.add($aux);	
                tabla.order( [ 1, 'desc' ] ).draw();
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los reportes técnicos",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#tableTechnicalReports').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [6,7,8] ,
        },
        {
			"targets": [ 1 ],
			"visible": false,
			"searchable": false
		},
        { "width": "5%", "targets": 0 },
        { "width": "5%", "targets": 1 },
        { "width": "10%", "targets": 2 },
        { "width": "20%", "targets": 3 },
        { "width": "10%", "targets": 4 },
        { "width": "10%", "targets": 5 },
        { "width": "10%", "targets": 6 },
        { "width": "10%", "targets": 7 },
	    {"width":"10%","targets":8},    
    ],

	columns: [
        { data: "number_ot"}, 
        {defaultContent:"1"},
        { data: "date" },
        {data:"enterprise"},
		{data:"description"},
        { data: "service" }, 
        { data: "check_technical" }, 
        { data: "check_adm" }, 
        { defaultContent: "tec",
            "render": function (data, type, row){
                if(row.check_technical === 'Realizado'){
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
        },
        { defaultContent: "oc",
		   "render": function (data, type, row){
			if(row.check_technical === 'Realizado'){
				return `<button type='button' name='btn_tr' class='btn btn-primary'>
                Ver informe
                <i class="fas fa-search"></i>
                </button>`
			}else{
                if(row.time_init){
                    if(row.aux){
                        return `<button type='button' name='btn_tr' class='btn btn-primary'>
                                Ver informe
                                <i class="fas fa-search"></i>
                                </button>`
                    }else{
                        return `<button type='button' name='btn_tr' class='btn btn-warning'>Realizar<i class="fas fa-pencil-alt"></i></button>`  
                    }  
                }else{  
                    return `<button type='button' name='btn_tr' class='btn btn-primary'>
                            Ver informe
                            <i class="fas fa-search"></i>
                            </button>`
                }
			}
		   }
		},
        { defaultContent: `<button type='button' name='btn_images' class='btn btn-success'>
                            Imágenes
                            <i class="fas fa-images"></i>
                            </button>`
		},
	
	],
});

$("#tableTechnicalReports").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_tr") {
        window.location.assign(host_url+`tmAdminViewTechnicalReport/${data.number_ot}`);
	}else if($(this)[0].name == "tr_btn_play"){
        show_play(data);
    }else if($(this)[0].name == "tr_btn_stop"){
        show_stop(data);
    }else if($(this)[0].name == "tr_btn_play_continue"){
        show_continue(data);
    }else if($(this)[0].name == "btn_images"){
        let ot = data.number_ot;
		let url = 'adminImages'+'?ot='+ot;
		window.location.assign(host_url+url);

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
        text: `¿Esta seguro de reanudar el informe técnico asociado a la OT ${data.number_ot}"?`,
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
        text: `¿Esta seguro de pausar el informe técnico asociado a la OT ${data.number_ot}"?`,
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
        name : 'technical_report'
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
            getTechnicalReports();
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
