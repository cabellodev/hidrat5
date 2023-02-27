$(() => {
    get_data_technical_report();
    get_all_notifications_tr(); 
});
let cont = 0;
let tr_id_images = [];
let tr_file_images = [];
let tr_technicals = [];
let id_image_change;
let id_file_change;
let img_header = false;
let img_header_file = '';
let tr_check_adm_old = '';
let tr_check_technical_old = '';
let date_create;
let user_create;
let date_modify;
let user_modify;
let date_approve;
let user_approve;
let list_technical_notification_tr = [];// notifications technical
let technicals_user_tr = 0; // user notifications

const tr_table_images = $('#tr_table_images').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        {
            "targets": [ 0 ],
            "visible": false,
            "searchable": false,
        },
        { "width": "15%", "targets": [2,3]},
		{ "width": "30%", "targets": 1 },
		{ "width": "5%", "targets": 0 },
		{ className: "text-center", "targets": [1,2,3,4]}
	  ],
	columns: [
        { data: "id" },
        { data: "name" },
        { data: "files",
          render: function(data){
              binary = data;
              return '<img src="'+host_url+"assets/upload/"+binary+'" width="200" heigth="200"/>';
          } 
        },
		{
            defaultContent: `<button type='button' name='tr_btn_look_image' class='btn btn-primary'>
                                 Ver 
								 <i class="fas fa-eye"></i>
                              </button>`,
		},
		{
            defaultContent: `<button type='button' name='tr_btn_select_image' class='btn btn-primary'>
                                <i class="fas fa-hand-pointer"></i>
                              </button>`,
		}, 
	],
});

get_data_technical_report = () =>{
    $('#tr_images').empty();
    id= $("#ot_number").val();
    tr_id_images = [];
    tr_file_images = [];
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getTechnicalReportByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response[0][0].data;
            
			let data_images = xhr.response[0][0].data_images;

            let data_interaction = xhr.response[0][0].data_interaction;

            let user = xhr.response[0][0].user;
            technicals_user_tr =xhr.response[0][0].user;
            if(data){
                technical_report = JSON.parse(data);
                $("#tr_date_technical_report").val(technical_report.date_technical_report);
                $("#tr_details").val(technical_report.details);
                $("#tr_notes").val(technical_report.notes);
                if(technical_report.check_adm === 'true'){
                    $("#tr_check_adm").prop("checked", true);
                    tr_check_adm_old = 'true';
                }else{
                    $("#tr_check_adm").prop("checked", false);
                    tr_check_adm_old = 'false';
                }
                if(technical_report.check_technical === 'true'){
                    $("#tr_check_technical").prop("checked", true);
                    tr_check_technical_old = 'true'
                    $('#tr_export').show();
                }else{
                    $("#tr_check_technical").prop("checked", false);
                    tr_check_technical_old = 'false'
                    $('#tr_export').hide();
                }
                
                if(technical_report.image_header){
                    $("#tr_image_header").attr('src',`${host_url}assets/upload/${technical_report.image_header}`);
                    img_header_file = technical_report.image_header;
                }else{
                    $("#tr_image_header").attr('src',`${host_url}assets/upload/technicalReport/noimage_poster.png`);
                }

                $("#tr_conclusion").val(technical_report.conclusion);
              //  $("#tr_recommendation").val(technical_report.recommendation);
	        if(technical_report.recommendation !=""){
                    console.log("entre if recomendacion");
                    $("#tr_recommendation").val(technical_report.recommendation);
                }else{
                    console.log("entre else recomendacion");
                    let text= {
                        texto:"SE RECOMIENDA UNA LIMPIEZA RIGUROSA DEL SISTEMA HIDRÁULICO. LA LIMPIEZA ES FUNDAMENTAL PARA LA DURABILIDAD DE LOS COMPONENTES DEL SISTEMA\n"+
                        "MANTENGA SIEMPRE EL ACEITE DEL ESTANQUE DENTRO DE LOS NIVELES RECOMENDADOS Y CONTROLE LA CONTAMINACIÓN BAJO LA NORMA QUE ESPECIFIQUE EL FABRICANTE\n"+
                        "TODA INTERVENCIÓN DEBE REALIZARLA PERSONAL COMPROMETIDO CON LOS PROCEDIMIENTOS, PARA EL MONTAJE Y PUESTA EN SERVICIO\n"+
                        "VERIFIQUE QUE LAS LÍNEAS DE CONEXIÓN, ESTÁN CORRECTAMENTE INSTALADAS DE ACUERDO AL CIRCUITO HIDRÁULICO\n"+
                        "REGULAR VÁLVULAS DE ALIVIO CONFORME A LAS ESPECIFICACIONES ORIGINALES DEL FABRICANTE, CON EL ACEITE A TEMPERATURA Y EN ROTACIONES DE TRABAJO. NUNCA ALTERAR LAS ESPECIFICACIONES DEL FABRICANTE\n"+
                        "LAS PRESIONES EXCESIVAS EN EL SISTEMA PUEDEN SER GENERADAS POR SOBRE CARGAS EN EL SISTEMA Y POTENCIAS SOBRE LAS RECOMENDADAS POR LOS FABRICANTES",
                    }
                    $("#tr_recommendation").val(text.texto);
                };
            }else{
                $("#tr_date_technical_report").val('');
                $("#tr_details").val('');
                $("#tr_notes").val('');
                $("#tr_check_adm").prop("checked", false);
                $("#tr_check_technical").prop("checked", false);
                $("#tr_image_header").attr('src','');;
                $("#tr_conclusion").val('');
                $("#tr_recommendation").val('');
                tr_check_adm_old = 'false';
                tr_check_technical_old = 'false';
            }

            if(data_images){
                technical_report_images = JSON.parse(data_images);
                if(tr_id_images.length == 0){
                    $.each(technical_report_images, function(i, item) {
                        console.log(item.name);
                        let image = "<div id='tr_div_details_image_"+item.id+"'><div class='row mb-2'><div class='col-md-5 mb-3'><label id='tr_label_image_"+item.id+"'>Imagen</label><button id='tr_btn_image_"+item.id+"' onclick='loadImages("+item.id+")' class='btn btn-primary' style='margin-right: 5px; margin-bottom: 5px; display:none;'><i class='fas fa-plus'></i>Seleccione imagen</button><div class='input-group'><img style='display:block;margin:auto;' width='400' heigth='400' id='tr_image_file_"+item.id+"' src='http://localhost/hidrat5/assets/upload/"+item.image+"' width='100%' class='responsive'></div></div>"
                        let minus = "<div class='col-md-7 mb-3'><div name='tr_delete_' id='tr_delete_"+item.id+"' style='text-align: right; display:none;'><button class='btn btn-danger rounded-circle' id='tr_btn_delete_"+item.id+"' onclick='deleteFields("+item.id+")'><i class='fas fa-minus'></i></button></div>"
                        let name = "<div><label>Nombre</label><div class='input-group'><input value='"+item.name+"' type='text' class='form-control' id='tr_image_name_"+item.id+"' readonly></div></div>"
                        let description = "<div style='padding-top: 15px;'><label>Descripción</label><div class='input-group'><textarea type='text' rows='6' class='form-control' id='tr_image_description_"+item.id+"' readonly>"+item.description+"</textarea></div></div></div></div><hr></div>"
                        let admin_images = image+minus+name+description;
                        $(admin_images).appendTo("#tr_images"); 
                        tr_id_images.push(item.id);
                        tr_file_images.push(item.image);
                    });
                }
            }

            if(data_interaction){
                interaction = JSON.parse(data_interaction);
                date_create = interaction.date_create;
                user_create = interaction.user_create;
                date_modify = interaction.date_modify;
                user_modify = interaction.user_modify;
                date_approve = interaction.date_approve;
                user_approve = interaction.user_approve;

                $("#tr_popover").popover(
                    { 
                    html: true,
                    title: "Información",
                    content: "Creado por: " +user_create+"<br />"+"Fecha creación: "+date_create+"<br />"+
                            "Modificado por: " +user_modify+"<br />"+"Fecha mod.: "+date_modify+"<br />"+
                            "Aprobado por: " +user_approve+"<br />"+"Fecha aprv.: "+date_approve
                    }
                ); 

            }else{
                date_create = '';
                user_create = '';
                date_modify = '';
                user_modify = '';
                date_approve = '';
                user_approve = '';

                $("#tr_popover").popover(
                    { 
                    html: true,
                    title: "Información",
                    content: "Creado por: " +user_create+"<br />"+"Fecha creación: "+date_create+"<br />"+
                            "Modificado por: " +user_modify+"<br />"+"Fecha mod.: "+date_modify+"<br />"+
                            "Aprobado por: " +user_approve+"<br />"+"Fecha aprv.: "+date_approve
                    }
                ); 
            }

            if(tr_technicals.length == 0){
                xhr.response[1].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#tr_technical");
                    tr_technicals.push(u.full_name);
                });
            }

            if(user){
                $("#tr_technical").val(user);
            }else{
                $("#tr_technical").val('');
            }
            disabledAlertTr();
		}else { 
            alertNotTechnical(xhr.response.msg);
        }
	});
	xhr.send();
}

tr_enableFields = ()=>{
    a = $("#tr_btnEdit").val();
    if(a == 0){
        $("#tr_date_technical_report").attr("readonly", false);
        $("#tr_technical").attr("readonly", false);
        $("#tr_details").attr("readonly", false);
        $("#tr_notes").attr("readonly", false);
        $("#tr_conclusion").attr("readonly", false);
        $("#tr_recommendation").attr("readonly", false);
        $("#tr_technical").removeAttr("disabled");
        $("#tr_check_adm").removeAttr("disabled");
        $("#tr_check_technical").removeAttr("disabled");
        for(let i=0; i < tr_id_images.length; i++){
            $("#tr_image_description_"+tr_id_images[i]).attr("readonly", false);
            $("#tr_image_name_"+tr_id_images[i]).attr("readonly", false);
            $("#tr_delete_"+tr_id_images[i]).show();
            $("#tr_label_image_"+tr_id_images[i]).hide();
            $("#tr_btn_image_"+tr_id_images[i]).show();
        }
        $("#tr_date_technical_report").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
        $("#tr_div_add").show();
        $("#tr_btn_image_header").show();
        $("#tr_label_image_header").hide();
        $("#tr_btnEdit").val(1);
        $("#tr_btnEdit").removeClass("btn btn-success");
        $("#tr_btnEdit").addClass("btn btn-danger");
        $("#tr_btnEdit").text("Cancelar");
        $("#tr_btnSave").show();
    }else if(a==1){
        $("#tr_date_technical_report").attr("readonly", true);
        $("#tr_technical").attr("readonly", true);
        $("#tr_details").attr("readonly", true);
        $("#tr_notes").attr("readonly", true);
        $("#tr_conclusion").attr("readonly", true);
        $("#tr_recommendation").attr("readonly", true);
        $("#tr_technical").attr("disabled", true);
        $("#tr_check_adm").attr("disabled", true);
        $("#tr_check_technical").attr("disabled", true);
        $("#tr_date_technical_report").datepicker("destroy");

        $("#tr_div_add").hide();
        $("#tr_btn_image_header").hide();
        $("#tr_label_image_header").show();
        $('#tr_images').empty();
        $("#tr_btnEdit").val(0);
        $("#tr_btnEdit").removeClass("btn btn-danger");
        $("#tr_btnEdit").addClass("btn btn-success");
        $("#tr_btnEdit").text("Editar");
        $("#tr_btnSave").hide();
        get_data_technical_report();
    }
}

createFields = () =>{
    let cont;
    if(tr_id_images.length > 0){
        cont = Math.max(...tr_id_images)+1;
    }else{
        cont =1;
    }
    
    let image = "<div id='tr_div_details_image_"+cont+"'><div class='row mb-2'><div class='col-md-5 mb-3'><button id='tr_btn_image_"+cont+"' onclick='loadImages("+cont+")' class='btn btn-primary' style='margin-right: 5px; margin-bottom: 5px;'><i class='fas fa-plus'></i>Seleccione imagen</button><div class='input-group'><img style='display:block;margin:auto;' width='400' heigth='400' src='' id='tr_image_file_"+cont+"' width='100%' class='responsive'></div></div>"
    let minus = "<div class='col-md-7 mb-3'><div name='tr_delete_' id='tr_delete_"+cont+"' style='text-align: right;'><button class='btn btn-danger rounded-circle' id='tr_btn_delete_"+cont+"' onclick='deleteFields("+cont+")'><i class='fas fa-minus'></i></button></div>"
    let name = "<div><label>Nombre</label><div class='input-group'><input type='text' class='form-control' id='tr_image_name_"+cont+"' ></div></div>"
    let description = "<div style='padding-top: 15px;'><label>Descripción</label><div class='input-group'><textarea type='text' rows='6' class='form-control' id='tr_image_description_"+cont+"'></textarea></div></div></div></div><hr></div>"
    let admin_images = image+minus+name+description;
    $(admin_images).appendTo("#tr_images"); 
}

deleteFields = (id) => {
    let position_file_change;

    for(i=0; i< tr_id_images.length ;i++){
        let number2 = parseInt(tr_id_images[i]);
        if(id === number2){
            position_file_change = i;
        }
    }

    tr_id_images = jQuery.grep(tr_id_images, function(value) {
        return value != id;
    });

    tr_file_images = jQuery.grep(tr_file_images, function(value) {
        return value != tr_file_images[position_file_change];
    });

    $('#tr_div_details_image_'+id).remove();
}

saveTechnicalReport = () =>{
    if($('#tr_check_adm').is(':checked') &&  !$('#tr_check_technical').is(':checked')){
        swal({
            title: "Error",
            icon: "error",
            text: "Si se aprueba el informe técnico por administración, es obligación tambien aprobar el check del técnico master",
        }).then(() => {
            $("body").removeClass("loading");
        });
    }else{
        let details_images = [{}];
        if(tr_id_images.length==0){
            details_images = null;
        }else{
            for(i=0; i<(tr_id_images).length; i++){
                details_images.push({
                    "id" : tr_id_images[i],
                    "name" : $('#tr_image_name_'+tr_id_images[i]).val(), 
                    "image" : tr_file_images[i],
                    "description" : $('#tr_image_description_'+tr_id_images[i]).val(),  
                });
            }
        }
    
        data = {
            date_technical_report: $('#tr_date_technical_report').val(),
            image_header: img_header_file,
            details : $('#tr_details').val(),
            notes : $('#tr_notes').val(),
            check_adm :  $('#tr_check_adm').is(':checked'),
            check_technical : $('#tr_check_technical').is(':checked'),
            conclusion : $('#tr_conclusion').val(),
            recommendation : $('#tr_recommendation').val(),
            details_images: details_images,
            technical : $('#tr_technical').val(),
            ot_id : $("#ot_number").val(),
            date_create_old: date_create,
            user_create_old: user_create,
            date_create: $('#tr_date_technical_report').val(),
            user_create: $('#tr_technical option:selected').text(),
            date_approve: date_approve,
            user_approve: user_approve,
            check_adm_old: tr_check_adm_old,
            check_technical_old: tr_check_technical_old,
            profile: 'admin',
        } 
       $.ajax({
            type: "POST",
            url: host_url + "api/editTechnicalReport",
            data: {data},
            dataType: "json",
            success: () => {
             swal({
                 title: "Éxito!",
                 icon: "success",
                 text: "Reporte técnico actualizado con éxito.",
                 button: "OK",
             }).then(() => {
                $("#tr_btnEdit").val('1');
                cont = 0;
                tr_id_images = [];
                tr_file_images = [];
                id_image_change ='';
                id_file_change = '';
                img_header = false;
                img_header_file = '';
                $("#tr_popover").popover('dispose');
                tr_enableFields();
                get_data_technical_report();
                get_all_notifications_tr(); 
             });
             if(!data.check_adm){
                notification_technical_tr(data.technical,2);
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

$("#tr_table_images").on("click", "button", function () {
    let data = tr_table_images.row($(this).parents("tr")).data();

    if ($(this)[0].name == "tr_btn_look_image") {
		url = `${host_url}assets/upload/${data.files}`;
	    $('.imagepreview').attr('src',url);
		$('#tr_show_image').modal('show');   
	}else if($(this)[0].name == "tr_btn_select_image"){

        if(img_header == true){
            $('#tr_image_header').attr('src',`${host_url}assets/upload/${data.files}`);
            img_header_file = data.files;
            $('#tr_search_image').modal('hide');
        }else if(img_header == false){
            $('#tr_div_details_image_'+id_image_change).attr("id","tr_div_details_image_"+data.id);

            $('#tr_image_name_'+id_image_change).val(data.name);
            $('#tr_image_name_'+id_image_change).attr("id","tr_image_name_"+data.id);
    
            $('#tr_image_file_'+id_image_change).attr('src',`${host_url}assets/upload/${data.files}`);
            $('#tr_image_file_'+id_image_change).attr("id","tr_image_file_"+data.id);
    
            $('#tr_image_description_'+id_image_change).attr("id","tr_image_description_"+data.id);
    
            $('#tr_btn_image_'+id_image_change).attr("id","tr_btn_image_"+data.id);
            $("#tr_btn_image_"+data.id).attr("onclick", "loadImages("+data.id+")");
    
            $('#tr_btn_delete_'+id_image_change).attr("id","tr_btn_delete_"+data.id);
            $("#tr_btn_delete_"+data.id).attr("onclick", "deleteFields("+data.id+")");
            
            let position_file_change;
            for(i=0; i< tr_id_images.length ;i++){
                if(tr_id_images[i] == id_image_change){
                    position_file_change = i;
                }
            }
    
            tr_id_images = jQuery.grep(tr_id_images, function(value) {
                return value != id_image_change;
            });
    
            tr_file_images = jQuery.grep(tr_file_images, function(value) {
                return value != tr_file_images[position_file_change];
            });
    
            tr_id_images.push(data.id);
            tr_file_images.push(data.files);
            $('#tr_search_image').modal('hide');
        }
        img_header = false;
    }
});

loadImages = (id) =>{
    let data;
    if(tr_file_images.length == 0 || id == null){
        data = {
            ot_id : $("#ot_number").val(),
            images : null,
        }
        if(id == null){
            img_header = true;
        }
    }else{
        data = {
            ot_id : $("#ot_number").val(),
            images : tr_id_images,
        }
    }

    $.ajax({
        type: "POST",
        url: host_url + "api/getImagesByTechnicalReport",
        data: {data},
        dataType: "json",
        success: (xhr) => {
            console.info(xhr);
            tr_table_images.clear();
			tr_table_images.rows.add(xhr);
			tr_table_images.draw();
            id_image_change = id;
            $("#tr_search_image").modal();
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

exportTechnicalReport = () =>{
    export_id = $("#ot_number").val();
    file = 'assets/upload/technicalReport/technical_report_'+export_id+'.pdf';
    url = host_url + file;
    window.open(url);
}

alertNotTechnical = (msg)=>{
    $("#technical_report_info" ).css("display","none");
    $("#alert_technical_report").addClass("alert alert-warning col-md-6 mb-3").text("Aviso : "+ msg);
    $("#tr_title_alert").text( "Detalle:");
}

disabledAlertTr = () =>{
    $("#technical_report_info" ).show();
    $("#alert_technical_report").removeClass("alert alert-warning col-md-6 mb-3");
    $("#alert_technical_report").text('');
    $("#tr_title_alert").css("display","none");
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


get_all_notifications_tr = ()=>{  // todas las notificaciones de technicos 

	$.ajax({
		type: "GET",
		url: host_url + `api/getNotificationsTechnical`,
		crossOrigin: false,
		async:false,
		dataType: "json",
		success: (result) => {
            list_technical_notification_tr = result;
			console.log(list_technical_notification_tr);
		},
		error:()=>{
             console.log("error");
		}

		
	});
}


notification_technical_tr = (user,report)=>{ // crear notificaciones  
  
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


    if(list_technical_notification_tr.length == 0){ // si no hay usuarios en la tabla , se agrega el primer usuario
	   
		  aux = [];
		  object = { message:message_hab,
			         date:moment().format(),
					 ot:ot,
					 state:true,
                     transmitter:transmitter,
                     report:report
                    }

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
		list_technical_notification_tr.forEach((x) => {
			
				if(x.user == user){ 
					user_exist=true;
					aux = JSON.parse(x.messages);

					object={message:message_hab,
						date:moment().format(),
						ot:ot,
						state:true,
                        transmitter:transmitter,report:report}

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
			object= { message:message_hab,date:moment().format(),ot:ot,state:true,
                transmitter:transmitter,report:report}
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

        if(technicals_user_tr){ 
		
				if(user != technicals_user_tr){ // si cambia de usuario , se le envia notificacion de desvinculo al tecnico anterior
				
					
					let user_exist = false;
					
					list_technical_notification_tr.forEach((x) => {
								
									if(x.user == technicals_user_tr){ 
										user_exist=true;
										aux = JSON.parse(x.messages);
										object= { message:message_des,date:moment().format(),ot:ot,state:true,
                                            transmitter:transmitter,report:report}
										aux.push(object);
										console.log(aux);
										data ={user:technicals_user_tr,messages:JSON.stringify(aux)};
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
						object = { message:message_des,date:moment().format(),ot:ot,state:true,
                            transmitter:transmitter,report:report}
						aux.push(object);
						data={user:technicals_user_tr,messages:JSON.stringify(aux)}; 
						
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

notification_manual_tr = () => {

   let message = $("#notification_manual_tr").val();
   let user = $('#tr_technical').val();
   let ot=  $("#ot_number").val();

	if(list_technical_notification_tr.length == 0){ // si no hay usuarios en la tabla , se agrega el primer usuario
	   
		aux = [];
		object = { message:message,date:moment().format(),ot:ot,state:true,
            transmitter:transmitter,report:2}
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
						get_all_notifications_tr(); 
					});
				}	
	  });

  }else{ // si ya existen usuarios , buscar el usuario y agregar mensaje a la coleccion de mensajes 
	 
	  let user_exist = false;
	  list_technical_notification_tr.forEach((x) => {
		  
			  if(x.user == user){ 
				  user_exist=true;
				  aux = JSON.parse(x.messages);
				  object = { message:message,date:moment().format(),ot:ot,state:true,
                    transmitter:transmitter,report:2}
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
								$("#modal_notification_tr").modal('hide');
								get_all_notifications_tr(); 
							});
						  }	
					  });
			  }
		 });

	}
}

$("#send_notification_tr").on("click",()=>{
	$("#modal_notification_tr").modal("show");
});
$("#send_technical_tr").on("click",notification_manual_tr);  

// NOTIFICATIONS CODE END

$("#tr_btn_add").on("click", createFields);

$("#tr_btnEdit").on("click", tr_enableFields);

$("#tr_btnSave").on("click", saveTechnicalReport);

$("#tr_export").on("click", exportTechnicalReport);

