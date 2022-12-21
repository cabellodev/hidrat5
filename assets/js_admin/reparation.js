$(() => {
    get_data_reparation();
    get_all_notifications_rep(); 
});

let r_technicals = [];
let r_check_adm_old = '';
let list_technical_notification_rep=[];
let technicals_user_rep = 0;



get_data_reparation = () =>{
    
    id= $("#ot_number").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getReparationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            if(r_technicals.length == 0){
                xhr.response[1].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#r_technical");
                    r_technicals.push(u.full_name);
                });
            }

            if(xhr.response[0][0].check_adm == 1){
                $("#r_check_adm").prop("checked", true);
                r_check_adm_old = 'true';
            }else{
                $("#r_check_adm").prop("checked", false);
                r_check_adm_old = 'false';
            }

            if(xhr.response[0][0].check_technical == 1){
                $("#r_check_technical").prop("checked", true);
            }else{
                $("#r_check_technical").prop("checked", false);
            }

            if(xhr.response[0][0].user){
                $("#r_technical").val(xhr.response[0][0].user);
                technicals_user_rep = xhr.response[0][0].user;

            }else{
                $("#r_technical").val('');
            }

            if(xhr.response[0][0].date){
                $("#r_date_reparation").val(xhr.response[0][0].date);
            }else{
                $("#r_date_reparation").val('');
            }

            
            if(xhr.response[0][0].date_limit){
                $("#r_date_limite").val(xhr.response[0][0].date_limit);
            }else{
                $("#r_date_limite").val('');
            }

            console.log(xhr.response[0][0].date_assignment);
            if(xhr.response[0][0].date_assignment){
                $("#r_date_assignment").val(xhr.response[0][0].date_assignment);
            }else{
                $("#r_date_assignment").val('');
            }

            if(xhr.response[0][0].days){
                $("#r_days_reparation").val(xhr.response[0][0].days);
            }else{
                $("#r_days_reparation").val('');
            }

            $("#provider_number").val(xhr.response[0][0].provider_number);
            $("#date_provider_number").val(xhr.response[0][0].date_provider_number);
            $("#priority_rep").val(xhr.response[0][0].priority);

            interaction = JSON.parse(xhr.response[0][0].user_interaction);
            date_reparation = interaction.date_reparation;
            technical_assignment = interaction.technical_assignment;
            date_modify = interaction.date_modify;
            user_modify = interaction.user_modify;
            date_approve = interaction.date_approve;
            user_approve = interaction.user_approve;
            $("#r_popover").popover(
                { 
                html: true,
                title: "Información",
                content: "Técnico que realizó la reparación: " + technical_assignment +"<br />"+"Fecha reparación: "+date_reparation+"<br />"+
                        "Modificado por: " +user_modify+"<br />"+"Fecha mod.: "+date_modify+"<br />"+
                        "Aprobado por: " +user_approve+"<br />"+"Fecha aprv.: "+date_approve
                }
            ); 


		}else {
			swal({
				title: "Error",
				icon: "error",
				text: "No se pudo encontrar el recurso",
			});
		}
	});
	xhr.send();
}

r_enableFields = ()=>{
    a = $("#r_btnEdit").val();
    if(a == 0){
        $("#r_date_assignment").attr("readonly", false);
        $("#r_days_reparation").attr("readonly", false);
        $("#date_provider_number").attr("readonly", false);
        $("#provider_number").attr("readonly", false);
        $("#r_date_reparation").attr("readonly", false);
        $("#r_technical").removeAttr("disabled");
        $("#r_check_adm").removeAttr("disabled");
        $("#priority_rep").removeAttr("disabled");
        $("#r_check_technical").removeAttr("disabled");
        $("#r_date_assignment").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
        $("#date_provider_number").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
        $("#r_date_reparation").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });

        $("#r_btnEdit").val(1);
        $("#r_btnEdit").removeClass("btn btn-success");
        $("#r_btnEdit").addClass("btn btn-danger");
        $("#r_btnEdit").text("Cancelar");
        $("#r_btnSave").show();
    }else if(a==1){
        $("#r_date_assignment").attr("readonly", true);
        $("#r_days_reparation").attr("readonly", true);
        $("#date_provider_number").attr("readonly", true);
        $("#priority_rep").attr("readonly", true);
        $("#r_date_reparation").attr("readonly", true);
        $("#provider_number").attr("readonly", true);
        $("#r_technical").attr("disabled", true);
        $("#r_check_adm").attr("disabled", true);
        $("#r_check_technical").attr("disabled", true);
        $("#r_date_assignment").datepicker("destroy");
        $("#date_provider_number").datepicker("destroy");
        $("#r_date_reparation").datepicker("destroy");
        $("#r_btnEdit").val(0);
        $("#r_btnEdit").removeClass("btn btn-danger");
        $("#r_btnEdit").addClass("btn btn-success");
        $("#r_btnEdit").text("Editar");
        $("#r_btnSave").hide();
        get_data_reparation();
    }
}

calculateDays = () => {
    if($("#r_date_assignment").val()){
        data = {
            date_assignment :  $("#r_date_assignment").val(),
            days_reparation : $("#r_days_reparation").val()
        }; 
        $.ajax({
            type: "POST",
            url: host_url + "api/CalculateDateReparation",
            data: {data},
            dataType: "json",
            success: (xhr) => {
                $("#r_date_limite").val(xhr);
            }
        });  
    }else{
        swal({
            title: "Error",
            icon: "error",
            text: "Debe ingresar primero una fecha de asignación",
        }).then(() => {
            $("#r_days_reparation").val('');
        });
    }
}

calculateDaysRep = () => {
    if($("#r_days_reparation").val()){
        data = {
            date_assignment :  $("#r_date_assignment").val(),
            days_reparation : $("#r_days_reparation").val()
        }; 
        $.ajax({
            type: "POST",
            url: host_url + "api/CalculateDateReparation",
            data: {data},
            dataType: "json",
            success: (xhr) => {
                $("#r_date_limite").val(xhr);
            }
        });  
    }
}

saveReparation = () =>{
    let user_assignment =null;
    let date_assignment =null;
    let date_reparation = null;
    let days_reparation = null;
    let date_limit = null;
    let check_adm = 0;
    let check_technical = 0;
    if($("#r_technical").val()) user_assignment = $("#r_technical").val(); else user_assignment = null;
    if($('#r_check_adm').is(':checked')) check_adm = 1; else check_adm = 0;
    if($('#r_check_technical').is(':checked')) check_technical = 1; else check_technical = 0;
    if($('#r_date_reparation').val()) date_reparation = $('#r_date_reparation').val(); else date_reparation = null;
    if($('#r_date_assignment').val()) date_assignment = $('#r_date_assignment').val(); else date_assignment = null;
    if($('#r_date_limite').val()) date_limit = $('#r_date_limite').val(); else date_limit = null;
    if($('#r_days_reparation').val()) days_reparation = $('#r_days_reparation').val(); else days_reparation = null;
    

    if(check_adm == '1'){
        if(date_reparation && date_assignment && user_assignment){
            data = {
                check_adm :  check_adm,
                check_technical : check_technical,
                user_assignment : user_assignment,
                ot_id : $("#ot_number").val(),
                days_reparation: days_reparation,
                date_reparation: date_reparation,
                date_limit: date_limit,
                date_assignment: date_assignment,
                date_provider_number : $('#date_provider_number').val(),
                provider_number : $('#provider_number').val(),
                check_adm_old: r_check_adm_old,
                priority: $('#priority_rep').val(),
                date_approve: date_approve,
                user_approve: user_approve,
                technical_assignment: $('#r_technical option:selected').text(),
            } 
            console.log(data.check_adm);
        
            $.ajax({
                type: "POST",
                url: host_url + "api/editReparation",
                data: {data},
                dataType: "json",
                success: () => {
                 swal({
                     title: "Éxito!",
                     icon: "success",
                     text: "Reparación actualizada con éxito.",
                     button: "OK",
                 }).then(() => {
                    $("#r_btnEdit").val('1');
                    $("#r_popover").popover('dispose');
                    r_enableFields();
                    get_data_reparation();
                    get_all_notifications_rep();
                 });

                 if(!data.check_adm){
                    notification_technical_rep(data.user_assignment,3);
                    }else{
                       console.log("no es posible enviar otra notificacion");
                    }
                
                }, 
                statusCode: {
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
                text: 'Los campos: Fecha de reparación, fecha límite y técnico asignado son obligatorios',
            });
        }
    }else{
        data = {
            check_adm :  check_adm,
            check_technical : check_technical,
            user_assignment : user_assignment,
            ot_id : $("#ot_number").val(),
            days_reparation: days_reparation,
            date_reparation: date_reparation,
            date_limit: date_limit,
            date_assignment: date_assignment,
            date_provider_number : $('#date_provider_number').val(),
            provider_number : $('#provider_number').val(),
            check_adm_old: r_check_adm_old,
            priority: $('#priority_rep').val(),
            date_approve: date_approve,
            user_approve: user_approve,
            technical_assignment: $('#r_technical option:selected').text(),
        } 
      
        $.ajax({
            type: "POST",
            url: host_url + "api/editReparation",
            data: {data},
            dataType: "json",
            success: () => {
             swal({
                 title: "Éxito!",
                 icon: "success",
                 text: "Reparación actualizada con éxito.",
                 button: "OK",
             }).then(() => {
                $("#r_btnEdit").val('1');
                $("#r_popover").popover('dispose');
                r_enableFields();
                get_data_reparation();
                get_all_notifications_rep();
             });


             if(data.check_adm !=1){
                notification_technical_rep(data.user_assignment,3);
                }else{
                   console.log("no es posible enviar otra notificacion");
                }
            
            }, 
            statusCode: {
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

get_all_notifications_rep = ()=>{  // todas las notificaciones de technicos 

	$.ajax({
		type: "GET",
		url: host_url + `api/getNotificationsTechnical`,
		crossOrigin: false,
		async:false,
		dataType: "json",
		success: (result) => {
            list_technical_notification_rep = result;
			console.log(list_technical_notification_rep);
		},
		error:()=>{
             console.log("error");
		}

		
	});
}


notification_technical_rep = (user,report)=>{ // crear notificaciones  
  
	ot=  $("#ot_number").val();
	message_hab="";
	message_des="";

    if(report==1){ // selecciona dependiendo del tipo de reporte
		message_hab = `Se te ha asignado la Evaluación de la OT (${ot})`;
		message_des = `Se te desvinculo de la Evaluación de la OT (${ot})`;
		}else if(report==2){
            
			message_hab= `Se te ha asignado el Reporte Técnico de la OT (${ot})`;
			message_des = `Se te desvinculo el Reporte Técnico de la OT (${ot})`;
		        }else if(report==3){
		           message_hab = `Se te ha asignado la Reparación para la OT (${ot})`;
				   message_des = `Se te desvinculo la Reparación de la OT (${ot})`;
	                   }else if(report==4){
		                    message_hab = `Se te ha asignado la Prueba Hidráulica de la OT (${ot})`;
							message_des = `Se te desvinculo la Prueba Hidráulica de la OT (${ot})`;
	                   }


    if(list_technical_notification_rep.length == 0){ // si no hay usuarios en la tabla , se agrega el primer usuario
	   
		  aux = [];
		  object = { message:message_hab,
			         date:moment().format(),
					 ot:ot,
					 state:true}

		  aux.push(object);
          data={user:user,messages:JSON.stringify(aux)}; 
		  console.log(data);

		  $.ajax({
			data: {
				data,
			},
			type: "POST",
			url: host_url + `api/createNotificationTechnical`,
			crossOrigin: false,
			dataType: "json",
			success: (result) => {
				console.log("exito del mensaje");
			}	
		});

	}else{ // si ya existen usuarios , buscar el usuario y agregar mensaje a la coleccion de mensajes 
	
        let user_exist = false;
		list_technical_notification_rep.forEach((x) => {
			
				if(x.user == user){ 
					user_exist=true;
					aux = JSON.parse(x.messages);

					object={message:message_hab,
						date:moment().format(),
						ot:ot,
						state:true}

					aux.push(object);
					data ={user:user,messages:JSON.stringify(aux)};
				       $.ajax({
							data: {
								data,
							},
							type: "POST",
							url: host_url + `api/createNotificationTechnical`,
							crossOrigin: false,
							dataType: "json",
							success: (result) => {
							  console.log("exito del mensaje");
							}	
						});
				}
           });

		if(!user_exist){ // si existen usuarios , pero el usuario seleccionado no existe , se crea el usuario con el primer mensaje

			aux = [];
			object= { message:message_hab,date:moment().format(),ot:ot,state:true}
			aux.push(object);
			data={user:user,messages:JSON.stringify(aux)}; 
			
			$.ajax({
			  data: {
				  data,
			  },
			  type: "POST",
			  url: host_url + `api/createNotificationTechnical`,
			  crossOrigin: false,
			  dataType: "json",
			  success: (result) => {
				  console.log("exito del mensaje");
			  }	
		    });
		}

        if(technicals_user_rep){ 
		
				if(user != technicals_user_rep){ // si cambia de usuario , se le envia notificacion de desvinculo al tecnico anterior
				
					
					let user_exist = false;
					
					list_technical_notification_rep.forEach((x) => {
								
									if(x.user == technicals_user_rep){ 
										user_exist=true;
										aux = JSON.parse(x.messages);
										object= { message:message_des,date:moment().format(),ot:ot,state:true}
										aux.push(object);
										console.log(aux);
										data ={user:technicals_user_rep,messages:JSON.stringify(aux)};
										$.ajax({
												data: {
													data,
												},
												type: "POST",
												url: host_url + `api/createNotificationTechnical`,
												crossOrigin: false,
												dataType: "json",
												success: (result) => {
												console.log("exito del mensaje");
												}	
											});
									}
					});
				
					if(!user_exist){ // si existen usuarios , pero el usuario seleccionado no existe , se crea el usuario con el primer mensaje

						aux = [];
						object = { message:message_des,date:moment().format(),ot:ot,state:true}
						aux.push(object);
						data={user:technicals_user_rep,messages:JSON.stringify(aux)}; 
						
						$.ajax({
						  data: { data, },
						  type: "POST",
						  url: host_url + `api/createNotificationTechnical`,
						  crossOrigin: false,
						  dataType: "json",
						  success: (result) => {
							  console.log("exito del mensaje");
						  }	
						});
					}
				}
	  		 }
    }


} // fin de la funcion de notificaciones de asignaciones 

notification_manual_rep= () => {

   let message = $("#notification_manual_rep").val();
   let user = $("#r_technical").val();
   let ot=  $("#ot_number").val();

	if(list_technical_notification_rep.length == 0){ // si no hay usuarios en la tabla , se agrega el primer usuario
	   
		aux = [];
		object = { message:message,date:moment().format(),ot:ot,state:true}
		aux.push(object);
		data={user:user,messages:JSON.stringify(aux)}; 
		
		$.ajax({
		  data: {
			  data,
		  },
		  type: "POST",
		  url: host_url + `api/createNotificationTechnical`,
		  crossOrigin: false,
		  dataType: "json",

		success: (result) => {
					swal({
						title: "Exito",
						icon: "success",
						text: "La notificación fue enviada con éxito.",
						button: "OK",
					}).then(() => {
						$("#modal_notification_tr").modal('hide');
						get_all_notifications_rep(); 
					});
				}	
	  });

  }else{ // si ya existen usuarios , buscar el usuario y agregar mensaje a la coleccion de mensajes 
	 
	  let user_exist = false;
	  list_technical_notification_rep.forEach((x) => {
		  
			  if(x.user == user){ 
				  user_exist=true;
				  aux = JSON.parse(x.messages);
				  object = { message:message,date:moment().format(),ot:ot,state:true}
				  aux.push(object);
				  data ={user:user,messages:JSON.stringify(aux)};
					 $.ajax({
						  data: {
							  data,
						  },
						  type: "POST",
						  url: host_url + `api/createNotificationTechnical`,
						  crossOrigin: false,
						  dataType: "json",
						  success: (result) => {
							swal({
								title: "Exito",
								icon: "success",
								text: "La notificación fue enviada con éxito.",
								button: "OK",
							}).then(() => {
								$("#modal_notification_rep").modal('hide');
								get_all_notifications_rep(); 
							});
						  }	
					  });
			  }
		 });

	}
}

$("#send_notification_rep").on("click",()=>{
	$("#modal_notification_rep").modal("show");
});
$("#send_technical_rep").on("click",notification_manual_rep);  
//notifications

$("#r_btnEdit").on("click", r_enableFields);

$("#r_btnSave").on("click", saveReparation);

$("#r_days_reparation").on("change", calculateDays);


$("#r_date_assignment").on("change", calculateDaysRep);