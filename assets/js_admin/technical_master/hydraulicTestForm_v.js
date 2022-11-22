$(() => {
    get_data_ht();
	getFields_ht();
	get_info_ht();
   
});


let check_admin_old = false;

let medida = []; 

let technicals_user_ht = 0; 
info_popover="";

get_data_ht = () =>{

    id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getHydraulicTestByOrder/${id}`);
	xhr.responseType = "json";
	xhr.setRequestHeader("Cache-Control", "no-cache");
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
		
			let data1 = xhr.response[0].details;
			let data2 =xhr.response[0].user_interaction;//nueva linea
			let technical=xhr.response[0].full_name;
			
			if(data1){ //linea nueva
				let ht= JSON.parse(data1);
			    
			    if(ht.approve_admin === "true" ){	
					$("#approve_admin_ht" ).prop('checked', true);
					check_admin_old = true;

			    } else {
					$( "#approve_admin_ht" ).prop('checked', false );
				    check_admin_old = false;                               
				}

			    if(ht.approve_technical === "true"){
				     
					$( "#approve_technical_ht").prop('checked', true);
			    } else {
					
					$( "#approve_technical_ht" ).prop('checked', false );}
				
				//$( "#date_ht" ).val(ht.date_ht);
				$( "#conclusion_ht" ).val(ht.conclusion);
				$( "#notes_ht" ).val(ht.notes);
				//$( "#technical_ht" ).val(technical);
			
			}else{
				//$( "#date_ht" ).val('');
				$( "#conclusion_ht" ).val('');
				$( "#notes_ht" ).val('');
				$( "#approve_technical_ht" ).prop('checked', false);
			  //  $( "#approve_admin_ht" ).prop('checked', false);
	
			}

			if(data2){
				let us = JSON.parse(data2);//linea nueva
			
				$("#user_create").val(us.user_create);//lineas nuevas
				$("#user_modify").val(us.user_modify);
				$("#user_approve").val(us.user_approve);
				$("#date_create").val(us.date_create);
				$("#date_modify").val(us.date_modify);
				$("#date_approve").val(us.date_approve);//fin lineas nuevas
				
			
			}else { 
				$("#user_create").val("");//lineas nuevas
				$("#user_modify").val("");
				$("#user_approve").val("");
				$("#date_create").val("");
				$("#date_modify").val("");
				$("#date_approve").val("");
				
			}

			technicals_user_ht = xhr.response[0].user_assignment;
            disabledAlert_ht();
		}else { 
            alert_not_evaluation_ht(xhr.response.msg);
        }
	});
	xhr.send();
}

alert_not_evaluation_ht = (msg)=>{
	
    $("#hydraulic_info" ).css("display","none");
    $("#card-option").css("display","none");
    $("#alert_hydraulicTest").addClass("alert alert-warning col-md-6 mb-3").text("Aviso : "+ msg);
    $("#title_alert_ht").text( "Detalle:");
}

disabledAlert_ht= () =>{

    $("#hydraulic_info" ).show();
    $("#alert_hydraulicTest").removeClass("alert alert-warning col-md-6 mb-3");
    $("#alert_hydraulicTest").text('');
    $("#title_alert_ht").css("display","none");
}







let technicals_ht = [];

getFields_ht = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFieldsOrder`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            if(technicals_ht.length == 0){
				
                xhr.response[2].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#technical_ht");
					$("#technical_ht").val(technicals_user);
                     technicals_ht.push(u.full_name);
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






const tabla_ht = $("#table-ht-view").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "dato" },
		{ data: "speed" },
		{ data: "presion" },
		{ data: "caudal" },
		{ data: "time" },
	
	],
});

let edit= false;
let currentID= 0;


		
get_info_ht = () =>{

    id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_info_ht/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			
			let info = xhr.response[0].extra_info;

		    if(info){
			data = JSON.parse(info);
		    
			data.forEach((item,index)=>{
				  medida[index] = item;
			});
			
            tabla_ht.clear();
			tabla_ht.rows.add(data);
			tabla_ht.draw();
		}else { 
			medida=[];
			tabla_ht.clear();
			tabla_ht.rows.add("");
			tabla_ht.draw();
		}
		
        }
	});
	xhr.send();
}

// Delete by id


$("#ht_popover").on("click",function(){


	$("#ht_popover").popover( 
	
		{ html: true,
		title: "Información",
		content: "Creado por: " +$("#user_create").val() +"<br />"+"Fecha creación: "+ 
		$("#date_create").val()+"<br />"+"Modificado por: " +$("#user_modify").val()+"<br />"+"Fecha mod.: "+ $("#date_modify").val()+"<br />"+
		"Aprobado por: " +$("#user_approve").val()+"<br />"+"Fecha aprv.: "+ $("#date_approve").val(),
	});
});

