$(() => {
  get_orders_ht();
	get_orders_ev();
	get_orders_tr();
	get_orders_reparation();

});

const tabla = $("#table-orders").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "number_ot" },
		{ data: "date" },
		{ data: "priority" },
		{ data: "component" },
       { data: "enterprise" },
       { data: "service" },
		
	],
});



const tablaReparation = $("#tableReparations").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	/* "columnDefs": [
        {
            className: "text-center", "targets": [4] ,
        },
        {
            className: "text-center", "targets": [5] ,
        },
    ], */
	columns: [
		{ data: "number_ot" },
		{ data: "component" },
        { data: "enterprise" },
        { data: "service" },	
	],
});


let down;
let e_quotation;
let e_aprobation;
let finished;
let reparation;
let evaluation;
let retired;
let hydraulic;
let hydraulicTests=[];
let evaluations=[];
let technicalsReports = [];
let reparations = [];
let urlRedirect = '';

get_orders_ht= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getHydraulicTestEnable`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);
             config = JSON.parse(item.config);
             if(validation.approve_technical == "false"){
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
                      approve_technical:  validation.approve_technical=="true"? "Realizado":"No realizado",
                      approve_admin:  validation.approve_admin == "true"?  "Aprobado":"No aprobado" ,
					            type:'hidraulic'
                      ,
                  }
                console.log(report.approve_technical);
                  
                 hydraulicTests.push(report);

                }
                });
         
           $("#hydraulicTest").html(hydraulicTests.length);
		} 
	});
	xhr.send();
};

get_orders_ev= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationEnable`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);
             if(validation){
             if(validation.approve_technical == "false"){
             report = 
                  {
                      number_ot : item.number_ot,
                      priority: item.priority=="1" ? "Baja":item.priority=="2"?"Media": item.priority=="3"?"Alta":"Por asignar",
                      technical : interaction ? interaction.date_create :"" ,
                      date :  validation.date_evaluation ==""?"Pendiente": validation.date_evaluation,
                      enterprise : item.enterprise,
                      component : item.component,
                      service : item.service,
					  type:'evaluation'
                  }
                
				  
				  evaluations.push(report);

                }

			}else{

				report = 
				{
					number_ot : item.number_ot,
					priority: item.priority=="1" ? "Baja":item.priority=="2"?"Media": item.priority=="3"?"Alta":"Por asignar",
					technical : interaction ? interaction.date_create :"" ,
					date :  "Pendiente",
					enterprise : item.enterprise,
					component : item.component,
					service : item.service,
					type:'evaluation',
				}

				evaluations.push(report);
			  

			}
                });
         
           $("#evaluation").html(evaluations.length);
		} 
	});
	xhr.send();
};



get_orders_tr= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/tmGetTechnicalReport`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            console.log(data);
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);
	console.log(validation);
		    console.log(item.number_ot);
             if(validation) {
                if(validation.check_technical == "false"|| validation.check_technical == ""){
                    report = 
                         {
                             number_ot : item.number_ot,
                             priority: item.priority,
                             component: item.client,
                             enterprise: item.client,
                             service: item.service,
                             date : "Pendiente",
                         }
                         
                         technicalsReports.push(report);
       
                       }    
             }
			});
             console.log(technicalsReports);         
           $("#technicalReportCount").html(technicalsReports.length);
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


get_orders_reparation = () => {
	reparations = [];
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/tmGetReparation`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            data.forEach((item)=>{
                if(item.check_technical == '0'){
					reparation = 
					{
						number_ot : item.number_ot,
						component: item.component,
						enterprise: item.client,
						service : item.service,
					}
					reparations.push(reparation);
				}
            });
            tablaReparation.clear();
            tablaReparation.rows.add(reparations);	
            tablaReparation.draw();      
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las reparaciones",
			});
		}
		$("#reparationCount").html(reparations.length);
	});
	xhr.send();
};


loadDataModal = (title, data) => {
	$("#titlemodal").html(title);
	tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
};



$("#btnHydraulicTest").on("click", () => {
	loadDataModal("Pruebas hidráulicas por realizar", hydraulicTests);
	$("#modal").modal("show");
});

$("#btnevaluation").on("click", () => {
	loadDataModal("Evaluaciones por realizar", evaluations);
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
	
});

$("#tableReparations").on("click", "button", function () {
    let data = tablaReparation.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_substaks") {
        alert('substaks');
	}else if ($(this)[0].name == "btn_approve"){
        approve(data);
    }
});


