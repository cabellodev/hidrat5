$(() => {
	getFields();
	get_orders();
	get_data_evaluation();
});

function autoresize(textarea) {
    textarea.style.height = '0px';     //Reset height, so that it not only grows but also shrinks
    textarea.style.height = (textarea.scrollHeight+10) + 'px';    //Set new height
}

$("#description_ev").keyup(function () {
    autoresize(this);
});

$("#notes").keyup(function () {
    autoresize(this);
});

let check_admin_old_ev = false;
let check_technical_old_ev = false;
let technicals_user = 0; 


get_orders=()=>{

let xhr = new XMLHttpRequest();
xhr.open("get", `${host_url}/api/getOrders`);
xhr.responseType = "json";
xhr.addEventListener("load", () => {
	if (xhr.status === 200) {
		console.log(xhr.response);
		const select_orders = $("#ot_previous");
		xhr.response.forEach( (x)=> {
			select_orders.append($("<option>", {
					value: x.number_ot ,
					text: String(x.number_ot)
				}));
			});

			select_orders.selectize({ 
				sortField: {
					field: 'text',
					direction: 'asc'
				}
			});
	} else {
		swal({
			title: "Error",
			icon: "error",
			text: "Error al obtener technicos",
		});
	}
});
xhr.send();
	
}






get_data_evaluation = () =>{
    id= $("#ot_number").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response[0][0].details;
			let technical=xhr.response[0][0].full_name;
			let problem=xhr.response[0][0].problem;
			let ot_previous = xhr.response[0][0].ot_previous;

		    let data2 =xhr.response[0][0].user_interaction;
			let priority=xhr.response[0][0].priority;
		    let location_ev =xhr.response[1][0].location_id;
            
			

			let file=xhr.response[0][0].export;
       
		
			if(data){
				let evaluation= JSON.parse(data);

				if(evaluation.approve_admin === "true"){$( "#approve_admin_ev" ).prop('checked', true);
				check_admin_old_ev = true
				} else {$( "#approve_admin_ev" ).prop('checked', false );
				check_admin_old_ev = false}

				if(evaluation.approve_technical === "true"){
				$("#export_ev").show();
				$( "#approve_technical_ev").prop('checked', true);
				check_technical_old_ev = true;
				} else {
					$("#export_ev").css("display","none");
					$( "#approve_technical_ev" ).prop('checked', false );
				check_technical_old_ev = false;
				}
                
				$( "#date_evaluation").val(evaluation.date_evaluation);
				$( "#description_ev").val(evaluation.description);
				$( "#problem").val(problem);
				$( "#notes" ).val(evaluation.notes);
				$("#record_path_pdf").val(file);
                $("#name_technical").val(technical);
				$("#priority_ev").val(priority);
				let select_previous=($("#ot_previous").selectize());
				let control =select_previous[0].selectize;
				control.setValue(ot_previous);
				
				
			}else{
				$( "#date_evaluation" ).val('');
				$( "#description_ev" ).val('');
				$( "#problem").val(problem);
				$( "#approve_technical_ev" ).prop('checked', false);
			    $( "#approve_admin_ev" ).prop('checked', false);
				$( "#notes" ).val('');
				$("#record_path_pdf").val("");
			    $("#name_technical").val("");
				$("#ot_previous").val("");
				$("#priority_ev").val(priority);
			}


			if(data2){
				let us = JSON.parse(data2);//linea nueva
			    console.log(us);
				$("#user_create_ev").val(us.user_create);//lineas nuevas
				$("#user_modify_ev").val(us.user_modify);
				$("#user_approve_ev").val(us.user_approve);
				$("#date_create_ev").val(us.date_create);
				$("#date_modify_ev").val(us.date_modify);
				$("#date_approve_ev").val(us.date_approve);//fin lineas nuevas
				$("#name_technical_ev" ).val(technical);
			
			}else { 
				$("#user_create_ev").val("");//lineas nuevas
				$("#user_modify_ev").val("");
				$("#user_approve_ev").val("");
				$("#date_create_ev").val("");
				$("#date_modify_ev").val("");
				$("#date_approve_ev").val("");
				$("#name_technical" ).val("");
			}

			if(location_ev){
				$('#location_ev').val(location_ev);
			  
			}else{
				$("#location_ev").val("");
			}
			
			technicals_user = xhr.response[0][0].user_assignment;
		    $("#technical_id").val(technicals_user);
            
			disabledAlertEv();
		}else { 
            alert_not_evaluation(xhr.response.msg);
        }

	});
	xhr.send();
}


alert_not_evaluation = (msg)=>{
	
    $("#evaluation_info" ).css("display","none");
    $("#alert_evaluation").addClass("alert alert-warning col-md-6 mb-3").text("Aviso : "+ msg);
    $("#title_alert_ev").text( "Detalle:");
}

disabledAlertEv= () =>{
    $("#evaluation_info" ).show();
    $("#alert_evaluation").removeClass("alert alert-warning col-md-6 mb-3");
    $("#alert_evaluation").text('');
    $("#title_alert_ev").css("display","none");
}






ev_enableFields = ()=>{
	a = $("#hab_edit_ev").val();
	if(a == 0){

        $( "#date_evaluation" ).prop( "disabled", false );
        $( "#description_ev" ).prop( "disabled", false );
        $( "#notes" ).prop( "disabled", false );
        $( "#technical_ev" ).prop( "disabled", false );
		$( "#approve_admin_ev" ).prop( "disabled", false );
        $( "#approve_technical_ev" ).prop( "disabled", false );
		$( "#location_ev" ).prop( "disabled", false );
		$( "#ot_previous" ).prop( "disabled", false );
		$("#date_evaluation").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
		$("#hab_edit_ev").val(1);
		$("#hab_edit_ev").removeClass("btn btn-success");
        $("#hab_edit_ev").addClass("btn btn-danger");
        $("#hab_edit_ev").text("Cancelar");
        $("#btn_edit").show();
	}else{
		$( "#ot_previous" ).prop( "disabled", true );
        $( "#date_evaluation" ).prop( "disabled", true );
        $( "#description_ev" ).prop( "disabled", true);
		$( "#location_ev" ).prop( "disabled", true );
        $(  "#notes").prop( "disabled", true );
        $(  "#technical_ev").prop( "disabled", true );
		$( "#approve_admin_ev" ).prop( "disabled", true );
        $( "#approve_technical_ev" ).prop( "disabled", true );
		$( "#id_ot" ).prop( "disabled", true );
		$("#date_evaluation").datepicker("destroy");	
		$("#hab_edit_ev").val(0);
		$("#hab_edit_ev").removeClass("btn btn-danger");
        $("#hab_edit_ev").addClass("btn btn-success");
        $("#hab_edit_ev").text("Editar");
        $("#btn_edit").hide();
	}
};


edit_evaluation = () => {

	id= $("#ot_number").val();
	data = { id: id };
	$.ajax({
		data: {
			data,
		},
		type: "POST",
		url: host_url + `api/getSubstaksByEvaluation`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			if(result == 0){
				event.preventDefault();
				let id = $("#id_ot").val();//Image ID 
				let data = {
					id : $("#id_ot").val(),
					date_evaluation :$("#date_evaluation").val(),
					description: $("#description_ev").val(),
					notes: $("#notes").val(),
					technical:$("#technical_id").val(),
					name_technical:  $('#technical_ev option:selected').text(),
					approve_technical: $("#approve_technical_ev").is(':checked'),
					approve_admin: $("#approve_admin_ev").is(':checked'),
					user_create:$("#user_create_ev").val(),//lineas nuevas
					user_modify:$("#user_modify_ev").val(),
					user_approve:$("#user_approve_ev").val(),
					date_create:$("#date_create_ev").val(),
					date_modify:$("#date_modify_ev").val(),
					date_approve:$("#date_approve_ev").val(),
					location: $("#location_ev").val(),
					priority:$("#priority_ev").val(),
					check_admin_old:check_admin_old_ev,
					check_technical_old:check_technical_old_ev,
					ot_previous:$("#ot_previous").val(),
					userAdmin: 0
					
				};
				console.log(data);
				 
						Object.keys(data).map((d) => $(`.${d}`).hide());
						$.ajax({
							data: {
								data,
							},
							type: "POST",
							url: host_url + `api/editEvaluation/${id}`,
							crossOrigin: false,
							dataType: "json",
							success: (result) => {
								swal({
									title: "Exito",
									icon: "success",
									text: result.msg,
									button: "OK",
								}).then(() => {
									$("#hab_edit_ev").val('1');
									ev_enableFields();
									get_data_evaluation();
									window.location.assign(host_url+'adminEvaluation');
								});
							},
							error: (result) => {
								swal({
									title: "Denegado!",
									icon: "error",
									text: result.responseJSON.msg,
								}).then(() => {
								swal.close();
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
};





let technicals = [];
let locations = [];
getFields = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFieldsOrder`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            if(technicals.length == 0){
				
                xhr.response[2].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#technical_ev");
					$("#technical_ev").val(technicals_user);
                     technicals.push(u.full_name);
                });
            }
	        if(locations.length == 0){
                xhr.response[3].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#location_ev");
                    locations.push(u.name);
                });
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener technicos",
			});
		}
	});
	xhr.send();
};



$("#btn_edit").on("click", () => {

    swal({
		title: `Confirmación de guardado `,
		icon: "warning",
		text: `¿Está seguro/a de guardar definitivamente este informe de evaluación?`,
		buttons: {
			confirm: {
				text: "Confirmar guardado",
				value: "exec",
			},
			cancel: {
				text: "Cancelar",
				value: "cancelar",
				visible: true,
			},
		},
	}).then((action) => {
		if (action == "exec") {
            edit_evaluation();
		} else {
			swal.close();
		}
	});
	
});


$("#hab_edit_ev").on("click", ev_enableFields);






