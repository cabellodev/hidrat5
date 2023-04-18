$(() => {
    get_locations();
    get_historial();
    
});

let state = $('#state').val();
let ubicaciones = [];


getOrders = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrders`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
            $("#search_ot").modal();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las órdenes de trabajo",
			});
		}
	});
	xhr.send();
};

get_locations = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getLocations`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            ubicaciones = xhr.response;
            let locationSearch = [];
            ubicaciones.map((u) => {
                locationSearch.push(u.name);
            });
            console.log(ubicaciones);
            fuzzyAutocomplete($("#location"), locationSearch);
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las ubicaciones",
			});
		}
	});
	xhr.send();
};

changeState = () => {

    swal({
        title: `Cambio de estado`,
        icon: "warning",
        text: `Esta  segur@ de cambiar el estado de la OT:  ${$('#ot_number').val()}?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "change",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "change") {
            let state_change = $('#state').val();

            if(state == state_change){
                swal({
                    title: "Error",
                    icon: "error",
                    text: "La OT ya se encuentra en el estado seleccionado",
                })
            }else{
                data = {
                    ot_number: $('#ot_number').val(),
                    state: state_change,
                }
                $.ajax({
                    type: "POST",
                    url: host_url + 'api/changeStateOrder',
                    data: {data},
                    dataType: "json",
                    success: (result) => {
                     swal({
                         title: "Éxito!",
                         icon: "success",
                         text: result.msg,
                         button: "OK",
                     }).then(() => {
                        $("#state").val(state_change);
                        state = state_change;
                        get_history_states();
                        if(state==6){
                            modal_billing();
                        }
                       
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
                })   
            }
        } else {
            swal.close();
        }
    }); 
}



modal_billing=()=>{
     $("#modal_close_ot").modal("show");

}


$("#reason_close").change(() => { 
    console.log("hola hola hola ");
	let reason_close = $("#reason_close").val();
    $("#billing_number").val("");
	if(reason_close ==1){
		$("#billing").show();
	}else if(reason_close==2){
	    $("#billing").hide();
        
	}else if(reason_close==3){
        $("#billing").hide();
    }
});

save_billing=()=>{
     
    data = { 
        message : $("#reason_close").val(),
        billing_number : $("#billing_number").val()

    }
    console.log(data);
}





changeLocation = () => {
    swal({
        title: `Cambio de ubicación`,
        icon: "warning",
        text: `Esta  segur@ de cambiar la ubicación de la OT:  ${$('#ot_number').val()}?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "change",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "change") {
            let location_change = $('#location').val();
            let location;

            ubicaciones.forEach(function(item) {
                if(location_change == item.name){
                    location = item.id;
                }
            });
            console.log(location);

            if(location){
                data = {
                    ot_number: $('#ot_number').val(),
                    location:  location,
                }
                $.ajax({
                    type: "POST",
                    url: host_url + 'api/changeLocationOrder',
                    data: {data},
                    dataType: "json",
                    success: (result) => {
                        swal({
                            title: "Éxito!",
                            icon: "success",
                            text: result.msg,
                            button: "OK",
                        }).then(() => {
                            $("#location").val(location_change);
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
                })   
            }else{
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Seleccione una ubicación valida",
                })
            }      
        } else {
            swal.close();
        }
    }); 
}

const tabla = $('#table_orders').DataTable({
    "columnDefs": [
        {
            "targets": [ 7 ],
            "visible": false,
            "searchable": false,
        },
        {
            "targets": [ 8 ],
            "visible": false,
            "searchable": false,
        },
        {
            className: "text-center", "targets": [6] ,
        },
        {
            "width": "10", "targets": [6] , 
        }
    ],

	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    
	columns: [
        { data: "number_ot"},
        { data: "date" },
        { data: "enterprise" },
        { data: "component" },
        { data: "state" },
		{ data: "service" },
        {
            defaultContent: `<button type='button' name='btn_change' class='btn btn-primary'>
                                <i class="fas fa-hand-pointer"></i>
                              </button>`,
		},
        { data: "priority" },
        { data: "description" },
	],
});

$("#table_orders").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_change") {
		 $('#ot_number').val(data.number_ot);
         $('#id_ot').val(data.number_ot);
		 $('#date_admission').val(data.date);
         $('#enterprise').val(data.enterprise);
         $('#service').val(data.service);
         $('#problem').val(data.problem);
         $('#component').val(data.component);
         $(`option[name ="${data.state}"]`).attr("selected",true);
         $('#description').val(data.description); 
         $('#priority').val(data.priority);
         $("#search_ot").modal('hide');

         get_data_evaluation();//funciona
         get_data_ht();//funciona
         get_info_ht(); //??
         verifyFile();//funciona
         get_data_technical_report();
         get_data_ap();
         verifyFile_OC();
         get_data_reparation();
         get_history_states();
         get_notes_ot();
         getImages();
         get_historial();
    } 
});

/*Función para manejo de errores*/
addErrorStyle = errores => {
	let arrayErrores = Object.keys(errores);
	let cadena_error = "";
	let size = arrayErrores.length;
	let cont = 1;
	arrayErrores.map(err => {
		if(size!= cont){
			cadena_error += errores[`${err}`] +'\n'+'\n';
		}else{
			cadena_error += errores[`${err}`];
		}
		cont++;
	});
	return cadena_error;
};

editOt =()=>{
    ot= $("#ot_number").val();
    let url = 'newUpdateOrder'+'?ot='+ot;
    window.location.assign(host_url+url);
}







/// notifications-billing


let all_users=[]
 
 get_users =()=> {

    $.ajax({
	
		type: "GET",
		url: host_url + "api/get_user_notifications",
		crossOrigin: false,
		async: false,
		dataType: "json",
		success: (result) => {
             all_users=result.users;
           console.log(all_users);
		},
      
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});
}


save_number_billig = ()=>{
   
    number_billing = $("#billing_number").val();

    aux =$("#number_bill").val();

    if(aux){
        swal({
            title: "Atención",
            icon: "warning",
            text: "Ya existe datos de cierre en esta OT. Desea sobreescribir la información existente para seguir?",
        }).then(()=>{
            $("#number_billing").val("");
            request_billing();
        });
      
    }else{  
        request_billing();
    }
}

request_billing= ()=>{
    let data = {
        number_billing: number_billing,
        ot_number: $('#ot_number').val(),
        reason: $('#reason_close').val(),
      }
      console.log(data.reason);
       
       $.ajax({
       type: "POST",
       url: host_url + 'api/updateNumberBilling',// agregar nueva ruta .
       data: {data},
       dataType: "json",
       success: (result) => {
           swal({
               title: "Éxito!",
               icon: "success",
               text: "Número de factura registrado con éxito.",
               button: "OK",
           }).then(() => {
               $("#number_billing").val("");
               get_data_ap();
               notification_billing(data.reason);
           });
       }, 
       error: () => {
         console.log("error en el guardado de la facturacion ");
       },
   })   


}


notification_billing=(reason)=>{
   
    all_users =[];
    // recupera el id del usuario actual 
    get_users();

    let aux =all_users.map(x => {
		let data ={};
		if(x.id_user != id_user_notification) {
			data = {id:x.id_user ,show:0}
			return data;
		}else{
			data = {id:x.id_user ,show:1}
			return data;
		}
	});

    let data = {
		ot: $('#ot_number').val(),
		states : JSON.stringify(aux),
        reason: reason,

    };


    $.ajax({
		data: { data },
		type: "POST",
		url: host_url + "api/notification/billing",
		crossOrigin: false,
		async:false,
		dataType: "json",
		success: (result) => {
			console.log(result)
		},
        error: (result) => {
            alert("no se ha enviado nada");}
		
	});
	
}

get_historial=()=>{
    let id = $('#ot_number').val();
    let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/gethistorialprevious/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            aux=[];
            
            xhr.response.forEach( x =>{
                let object={};
                    object = {
                       ot:x.ot_previous,
                       enterprise:x.details.enterprise,
                        description:x.details.description,
                        component:x.details.component,
                        service:x.details.service,
                        
                    }
                aux.push(object);
                });
               

           

            console.log(aux);
            tabla_previous.clear();
			tabla_previous.rows.add(aux);
			tabla_previous.draw();
            
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las órdenes de trabajo",
			});
		}
	});
	xhr.send(); 
}

const tabla_previous= $('#table_previous').DataTable({
    
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    
	columns: [
        { data: "ot"},
        { data: "enterprise" },
        { data: "description" },
        { data: "component" },
		{ data: "service" },
        {
            defaultContent: `<button type='button' name='btn_change' class='btn btn-primary'>
                                <i class="fas fa-hand-pointer"></i>
                              </button>`,
		},
       
        
	],
});

$("#table_previous").on("click", "button", function () {
    let data = tabla_previous.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_change") {
        let url = 'stagesOrder'+'?ot='+data.ot;
        window.location.assign(host_url+url);
   } 
});


$("#previous").on('click', () => {
	$("#modal_previous").modal('show');
})


$("#edit_ot").on("click",editOt);
$("#btn_change_state").on("click", changeState);

$("#btn_change_location").on("click", changeLocation);

$("#btn_search").on("click", getOrders);
$("#btn_save_close").on("click",save_number_billig);

$("#btn_create").on('click', () => {
	window.open(host_url+'newOrder', '_self');
})











