
$(() => {
    get_data_evaluation();
	getFields();
   
});
let check_admin_old_ev = false;
let check_technical_old_ev = false;
let technicals_user = 0; 

get_data_evaluation = () =>{

    id= $("#ot_number").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			
			let data = xhr.response[0].details;
			let technical=xhr.response[0].full_name;
			let priority=xhr.response[0].priority;
			let location=xhr.response[0].location;
			console.log(typeof(location));
		    let data2 =xhr.response[0].user_interaction;
			let file=xhr.response[0].export;

        
		
			if(data){
				let evaluation= JSON.parse(data);

				if(evaluation.approve_admin === "true"){
					console.log("entre");
					$( "#approve_admin_ev" ).prop('checked', true);
			

				      if(evaluation.approve_technical === "true"){
					      $("#btn_export_ev").show();
				        $( "#approve_technical_ev").prop('checked', true);
				       check_technical_old_ev = true;
				         } else {
					    $("#btn_export_ev").hide();
					    $( "#approve_technical_ev" ).prop('checked', false );
				         check_technical_old_ev = false;
				         }
                
				      $( "#date_evaluation").val(evaluation.date_evaluation);
				      $( "#description_ev").val(evaluation.description);
				       $( "#notes" ).val(evaluation.notes);
				       $("#record_path_pdf").val(file);
                      $("#name_technical").val(technical);
				        $("#priority_ev").val(priority);

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
			
						getLocation(id);
			
						if(technical){
							let a = $(`option[name ="${technical}"]`).val();
							$("#technical_ev").val(a);
						}else{
							$("#technical_ev").val('');
						}
						technicals_user = xhr.response[0].user_assignment;
						$("#technical_id").val(technicals_user);
			
						disabled_not_aproveEv();
				
			}else{
				
				alert_not_approveEv();
			
			}
		
		}else { 
			
			alert_not_approveEv();
		}
	}else{
		
		alert_not_approveEv();
	}

	});
	xhr.send();
}

getLocation=(id)=>{
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
		    location_ev =xhr.response[0].location;
            
			if(location_ev){
			    $("#location_ev").val(location_ev);
				
			  }else{
				  
				  $("#location_ev").val("");
			  }}

})
xhr.send();}




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
alert_not_approveEv = ()=>{
	
    $("#evaluation_info" ).css("display","none");
    $("#alert_evaluation").addClass("alert alert-warning col-md-6 mb-3").text("Aviso : "+ "Pendiente de aprobación por administración.");
    $("#title_alert_ev").text( "Detalle:");
}

disabled_not_aproveEv= () =>{
    $("#evaluation_info" ).show();
    $("#alert_evaluation").removeClass("alert alert-warning col-md-6 mb-3");
    $("#alert_evaluation").text('');
    $("#title_alert_ev").css("display","none");
}


getLocation=(id)=>{
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
		    location_ev =xhr.response[0].location;
              console.log(location_ev);
			if(location_ev){
			    $("#location_ev").val(location_ev);
				
			  }else{
				  
				  $("#location_ev").val("");
			  }}

})

xhr.send();}



ev_enableFields = ()=>{
	a = $("#hab_edit_ev").val();
	if(a == 0){
        $( "#date_evaluation" ).prop( "disabled", false );
        $( "#description_ev" ).prop( "disabled", false );
        $( "#notes" ).prop( "disabled", false );
        $( "#technical_ev" ).prop( "disabled", false );
		$( "#location_ev" ).prop( "disabled", false );
		$( "#approve_admin_ev" ).prop( "disabled", false );
        $( "#approve_technical_ev" ).prop( "disabled", false );
		$("#priority_ev").prop( "disabled", false );
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
	}else if(a==1){
        $( "#date_evaluation" ).prop( "disabled", true );
        $( "#description_ev" ).prop( "disabled", true);
		$( "#priority_ev" ).prop( "disabled", true);
        $(  "#notes").prop( "disabled", true );
		$( "#location_ev" ).prop( "disabled", true );
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
    
	event.preventDefault();
	let id = $("#id_ot").val();//Image ID 
	let data = {
		id : $("#id_ot").val(),
        date_evaluation :$("#date_evaluation").val(),
        description: $("#description_ev").val(),
        notes: $("#notes").val(),
        technical: $("#technical_ev").val(),
		name_technical:  $('#technical_ev option:selected').text(),
		technical_id:$("#technical_id").val(),
		old_pdf: $("#record_path_pdf").val(),
		approve_technical: $("#approve_technical_ev").is(':checked'),
		approve_admin: $("#approve_admin_ev").is(':checked'),
		user_create:$("#user_create_ev").val(),//lineas nuevas
		user_modify:$("#user_modify_ev").val(),
		user_approve:$("#user_approve_ev").val(),
		date_create:$("#date_create_ev").val(),
		date_modify:$("#date_modify_ev").val(),
		date_approve:$("#date_approve_ev").val(),
		priority:$("#priority_ev").val(),
		check_admin_old:check_admin_old_ev,
        check_technical_old:check_technical_old_ev,
		
	};
   console.log(data.technical_id);

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
			   });
		},
		error: (result) => {
            swal({
				title: "Denegado!",
				icon: "error",
				text: 'Denegado',
			}).then(() => {
			 swal.close();
			});
		     
		},
	});
};

$("#ev_popover").on("click",function(){


	$("#ev_popover").popover( 
	
		{ html: true,
		title: "Información",
		content: "Creado por: " +$("#user_create_ev").val() +"<br />"+"Fecha creación: "+ 
		$("#date_create_ev").val()+"<br />"+"Modificado por: " +$("#user_modify_ev").val()+"<br />"+"Fecha mod.: "+ $("#date_modify_ev").val()+"<br />"+
		"Aprobado por: " +$("#user_approve_ev").val()+"<br />"+"Fecha aprv.: "+ $("#date_approve_ev").val(),
	});
});




let technicals = [];
let locations= [];

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

showExportEvaluation = ()=>{ 

	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getEvaluationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			    
			$file=xhr.response[0].export; //definir en base de datos 
			$url= host_url+$file;
			console.log($url);
			window.open($url);
		
        }else { 
			
			swal({
				title: "Error",
				icon: "error",
				text:  "Error al cargar el archivo ",
			});
		}
	});
	xhr.send();
}


$("#btn_edit").on("click", () => {
	edit_evaluation();
});

$("#btn_export_ev").on("click",showExportEvaluation );

$("#hab_edit_ev").on("click", ev_enableFields);






