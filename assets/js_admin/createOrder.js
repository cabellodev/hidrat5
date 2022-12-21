$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getFields();
    autoincrementID();
    get_all_notifications();
});

$("#service").selectize({
    sortField: "text",
});


$("#priority").selectize({
    sortField: "text",
});


autoincrementID = ()=>  { 
    $.ajax({
        type: "GET",
        url: host_url + "api/autoincrementID",
        dataType: "json",
        success: (result) => {
            let  ot_number = result[0].autoincrement;
            let automatic_id = parseInt(ot_number)+1;
            $("#ot_number").val(automatic_id);
        }
    })
}


$("#ot_number").change(() => { 
	let ot_number = $("#ot_number").val();
	if(ot_number){
		$("#frm_ot_number > input").removeClass("is-invalid");
	}else{
		$("#frm_ot_number > input").addClass("is-invalid");
	}
});

$("#enterprise").change(() => { 
	let enterprise = $("#enterprise").val();
	if(enterprise){
		$("#frm_enterprise > select").removeClass("is-invalid");
	}else{
		$("#frm_enterprise > select").addClass("is-invalid");
	}
});

$("#service").change(() => { 
	let service = $("#service").val();
	if(service){
		$("#frm_service > select").removeClass("is-invalid");
	}else{
		$("#frm_service > select").addClass("is-invalid");
	}
});

$("#component").change(() => { 
	let component = $("#component").val();
	if(component){
		$("#frm_component > select").removeClass("is-invalid");
	}else{
		$("#frm_component > select").addClass("is-invalid");
	}
});

$("#priority").change(() => { 
	let priority = $("#priority").val();
	if(priority){
		$("#frm_priority > select").removeClass("is-invalid");
	}else{
		$("#frm_priority > select").addClass("is-invalid");
	}
});

$("#date_admission").change(() => { 
	let date_admission = $("#date_admission").val();
	if(date_admission){
		$("#frm_date_admission > input").removeClass("is-invalid");
	}else{
		$("#frm_date_admission > input").addClass("is-invalid");
	}
});

$("#days_quotation").change(() => { 
	let days_quotation = $("#days_quotation").val();
	if(days_quotation){
		$("#frm_days_quotation > input").removeClass("is-invalid");
	}else{
		$("#frm_days_quotation > input").addClass("is-invalid");
	}
});

$("#check_evaluation").change(() => { 
	if($('#check_evaluation').is(':checked')){
		$("#frm_technical").show();
	}else{
		$("#frm_technical").hide();
        $('#technical').val('');
	}
});

$("#check_report_technical").change(() => { 
	if($('#check_report_technical').is(':checked')){
		$("#frm_technical_tr").show();
	}else{
		$("#frm_technical_re").hide();
        $('#technical_tr').val('');
	}
});


/* check_evaluation */

let components = []; /*Variable que almacenara los componentes*/
let enterprises = []; /*Variable que almacenara las empresas*/
let technicals = []; /*Variable que almacenara los tecnicos*/
let technicals_tr = []; /*Variable que almacenara los tecnicos tr*/
let locations = [];  /*Variable que almacenara las ubicaciones*/
let ubicaciones = [];

/*Funcion para recuperar las ordenes de trabajo*/
getFields = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFieldsOrder`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            if(components.length == 0){
                xhr.response[0].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#component");
                    components.push(u.name);
                });

                $("#component").selectize({
                    sortField: "text",
                });
            }
            if(enterprises.length == 0){
                xhr.response[1].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#enterprise");
                    enterprises.push(u.name);
                });
          
                $("#enterprise").selectize({
                    sortField: "text",
                });
                
            }
            if(technicals.length == 0){
                xhr.response[2].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#technical");
                    technicals.push(u.full_name);
                });
            }
            if(technicals_tr.length == 0){
                xhr.response[2].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#technical_tr");
                    technicals_tr.push(u.full_name);
                });
            }
            if(locations.length == 0){
                ubicaciones = xhr.response[3];
                let locationSearch = [];
                xhr.response[3].map((u) => {
                   /*  let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#location");*/ 
                    locations.push(u.name);
                    locationSearch.push(u.name);
                });
                fuzzyAutocomplete($("#location"), locationSearch);
            }
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

createOrder = () => {


    let location_change = $('#location').val();
    let location;

    ubicaciones.forEach(function(item) {
        if(location_change == item.name){
            location = item.id;
        }
    });

    let data = {
        ot_number : $('#ot_number').val(),
        enterprise : $('#enterprise').val(),
        service : $('#service').val(),
        component : $('#component').val(),
        priority : $('#priority').val(),
        problem:$('#problem').val(),
        location: location,
        description : $('#description').val(),
        date_admission : $('#date_admission').val(),
        days_quotation : $('#days_quotation').val(),
        check_evaluation : $('#check_evaluation').is(':checked'),
        check_report_technical : $('#check_report_technical').is(':checked'),
        check_hydraulic_test : $('#check_hydraulic_test').is(':checked'),
        technical : $('#technical').val(),
        technical_tr : $('#technical_tr').val(),
    }


    if(location){

        $.ajax({
            type: "POST",
            url: host_url + "api/createOrder",
            data: {data},
            dataType: "json",
            success: () => {
            swal({
                title: "Éxito!",
                icon: "success",
                text: "órden de trabajo ingresada con éxito",
                button: "OK",
            }).then(() => {
                notifications_technical(data.technical,data.technical_tr);
             window.location.assign(host_url+"adminOrders");
            });
            }, 
            statusCode: {
            400: (xhr) => {
                let msg = xhr.responseJSON;
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Por favor corrige los errores de este formulario",
                }).then(() => {
                    if(msg.ot_number){$("#frm_ot_number > div").html(msg.ot_number); $("#frm_ot_number > input").addClass("is-invalid");}
                    if(msg.enterprise){$("#frm_enterprise > div").html(msg.enterprise); $("#frm_enterprise > select").addClass("is-invalid");}
                    if(msg.service){$("#frm_service > div").html(msg.service); $("#frm_service > select").addClass("is-invalid");}
                    if(msg.component){$("#frm_component > div").html(msg.component); $("#frm_component > select").addClass("is-invalid");}
                    if(msg.priority){$("#frm_priority > div").html(msg.priority); $("#frm_priority > select").addClass("is-invalid");}
                    if(msg.date_admission){$("#frm_date_admission > div").html(msg.date_admission); $("#frm_date_admission > input").addClass("is-invalid");}
                    if(msg.days_quotation){$("#frm_days_quotation > div").html(msg.days_quotation); $("#frm_days_quotation > input").addClass("is-invalid");}
                });
            },
            405: (xhr) =>{
                let msg = xhr.responseJSON;
                swal({
                    title: "Error",
                    icon: "error",
                    text: addErrorStyle(msg),
                });
            },
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
            title: "Error",
            icon: "error",
            text: "Seleccione una ubicación valida",
        })
    }     
}

let list_technical_notification=[];

get_all_notifications = ()=>{  // todas las notificaciones de technicos 

	$.ajax({
		type: "GET",
		url: host_url + `api/getNotificationsTechnical`,
		crossOrigin: false,
		async:false,
		dataType: "json",
		success: (result) => {
            list_technical_notification= result;
			console.log(list_technical_notification);
		},
		error:()=>{
             console.log("error");
		}

		
	});
}



notifications_technical =(technical_ev , technical_tr)=>{
     
      let ot= $('#ot_number').val();
      //1 = evaluation , 2 = technical_report
      let technicals =[{report:1, technical:technical_ev}, {report:2, technical:technical_tr}];
      let data={};

      technicals.forEach(x=>{
        
                if(x.report==1){
                    if(x.technical !=""){ 
                        message=`Se le ha asignado la evaluación de la OT ${ot}`;
                        send_message(x.technical,list_technical_notification,message,ot);
                    }
                }else{
                    if(x.technical !=""){ 
                        message=`Se le ha asignado el reporte técnico de la OT ${ot}`;
                        send_message(x.technical,list_technical_notification,message,ot);
                       // message(message, technical);
                    }
                }
      });
}


send_message =(technical,list_technical_notification,message,ot)=>{

    if(list_technical_notification==0){
        aux = [];
        object = { message:message,
                   date:moment().format(),
                   ot:ot,
                   state:true}

        aux.push(object);
        data={user:technical,messages:JSON.stringify(aux)};
        $.ajax({
            data: {
                data,
            },
            type: "POST",
            url: host_url + `api/createNotificationTechnical`,
            crossOrigin: false,
            async:false,
            dataType: "json",
            success: (result) => {
                
                get_all_notifications();
              
            }	
        });

    }else{

        let user_exist = false;
        list_technical_notification.forEach((x) => {
            
                if(x.user == technical){ 
                    user_exist=true;
                    aux = JSON.parse(x.messages);

                    object={message:message,
                        date:moment().format(),
                        ot:ot,
                        state:true}

                    aux.push(object);
                    data ={user:technical,messages:JSON.stringify(aux)};
                       $.ajax({
                            data: {
                                data,
                            },
                            type: "POST",
                            async:false,
                            url: host_url + `api/createNotificationTechnical`,
                            crossOrigin: false,
                            dataType: "json",
                            success: (result) => {
                            
                                get_all_notifications();
                             
                            }	
                        });
                }
           });

        if(!user_exist){ // si existen usuarios , pero el usuario seleccionado no existe , se crea el usuario con el primer mensaje

            aux = [];
            object= { message:message,date:moment().format(),ot:ot,state:true}
            aux.push(object);
            data={user:technical,messages:JSON.stringify(aux)}; 
            
            $.ajax({
              data: {
                  data,
              },
              type: "POST",
              async:false,
              url: host_url + `api/createNotificationTechnical`,
              crossOrigin: false,
              dataType: "json",
              success: (result) => {
               
                get_all_notifications();
                  
              }	
            });
        }
    }  

}






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

$("#btn").on("click", createOrder);



