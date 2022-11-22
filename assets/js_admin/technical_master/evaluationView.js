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
		    let data2 =xhr.response[0].user_interaction;
			let location=xhr.response[0].location;
			let problem=xhr.response[0].problem;
			let file=xhr.response[0].export;

        
		
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
				
				
			}else{
				$( "#date_evaluation" ).val('');
				$( "#description_ev" ).val('');
				$( "#problem" ).val(problem);
				$( "#approve_technical_ev" ).prop('checked', false);
			    $( "#approve_admin_ev" ).prop('checked', false);
				$( "#notes" ).val('');
				$("#record_path_pdf").val("");
			    $("#name_technical").val("");
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

			getLocation(id);

			if(technical){
				let a = $(`option[name ="${technical}"]`).val();
				$("#technical_ev").val(a);
			}else{
				$("#technical_ev").val('');
			}
			technicals_user = xhr.response[0].user_assignment;
		    $("#technical_id").val(technicals_user);
            
			disabledAlertEv();
		}else { 
            alert_not_evaluation(xhr.response.msg);
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
			}
		}
	})
	xhr.send();
}

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





