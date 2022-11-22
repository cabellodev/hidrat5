$(() => {
    get_data_ht();
	getFields_ht();
	get_info_ht();
   
});


let check_admin_old = false;
let check_technical_old_ht = false;
let config =[];
let medida = []; 


ht_enableFields = ()=>{
    a = $("#ht_btnEdit").val();
    if(a == 0){
        $( "#date_ht" ).prop( "disabled", false );
        $( "#conclusion_ht" ).prop( "disabled", false );
        $( "#notes_ht" ).prop( "disabled", false );
        $( "#approve_admin_ht" ).prop( "disabled", false );
		$( "#approve_technical_ht" ).prop( "disabled", false );
        $( "#technical_ht" ).prop( "disabled", false );
		$("#date_ht").datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
		$("#ht_btnEdit").val(1);
        $("#ht_btnEdit").removeClass("btn btn-success");
        $("#ht_btnEdit").addClass("btn btn-danger");
        $("#ht_btnEdit").text("Cancelar");
        $("#btn_hidraulic").show();
	}else if(a==1){
        $( "#date_ht" ).prop( "disabled", true );
        $( "#conclusion_ht" ).prop( "disabled", true);
        $( "#notes_ht" ).prop( "disabled", true );
        $( "#approve_admin_ht" ).prop( "disabled", true );
		$( "#approve_technical_ht" ).prop( "disabled", true );
        $( "#technical_ht" ).prop( "disabled", true );
		$("#date_ht").datepicker("destroy");	
		$("#ht_btnEdit").val(0);
        $("#ht_btnEdit").removeClass("btn btn-danger");
        $("#ht_btnEdit").addClass("btn btn-success");
        $("#ht_btnEdit").text("Editar");
        $("#btn_hidraulic").hide();
	}
};


unable_edition =()=>{
	$('#hab_edit').prop( "checked", false );
	$( "#date_ht" ).prop( "disabled", true );
	$( "#conclusion_ht" ).prop( "disabled", true);
    $( "#notes_ht" ).prop( "disabled", true );
	$( "#approve_admin_ht" ).prop( "disabled", true );
	$( "#approve_technical_ht" ).prop( "disabled", true );
    $( "#technical_ht" ).prop( "disabled", true );
}


edit_ht = () => {
	event.preventDefault();
	let id = $("#ot_number").val();//Image ID 
	
	let data = {
		id: $("#ot_number").val(),
       // date_ht :$("#date_ht").val(),
        conclusion: $("#conclusion_ht").val(),
        notes: $("#notes_ht").val(),
        approve_technical: $("#approve_technical_ht").is(':checked'),
		approve_admin: $("#approve_admin_ht").is(':checked'),
        technical: $("#technical_aux").val(),
		technical_name: $("#technical_name_ht").val(),
		user_create:$("#user_create").val(),//lineas nuevas
		date_create: $("#date_create").val(),
		user_approve: $("#user_approve").val(),
		date_approve:$("#date_approve").val(),//fin
		check_admin_old: check_admin_old,
		check_technical_old :check_technical_old_ht,
		config_speed:$("#speed_c").val(),//lineas nuevas
		config_presion:$("#presion_c").val(),
		config_caudal:$("#caudal_c").val(),
		config_temperature:$("#temperature_c").val(),
	};

	data2=JSON.stringify(medida);

	Object.keys(data).map((d) => $(`.${d}`).hide());
	$.ajax({
		data: {
			data,
			data2
		},
		type: "POST",
		url: host_url + `api/editHydraulicTest/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
            swal({
				title: "Exito",
				icon: "success",
				text: result.msg,
                button: "OK",
			}).then(() => {
				$("#ht_btnEdit").val('1');
				$("#date_ht").datepicker("destroy");
				ht_enableFields();
				unable_edition();
				/* window.location.assign(host_url+'adminHydraulicTest'); */
				get_data_ht();
				swal.close();
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
};




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
			let config=xhr.response[0].config;
			
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
					$( "#export_ht").show();
					$( "#approve_technical_ht").prop('checked', true);
					check_technical_old_ht=true;
					

			    } else {
					
					$( "#approve_technical_ht" ).prop('checked', false );
					$("#export_ht").css("display","none");
					check_technical_old_ht=false;
				}
				
				$( "#date_ht" ).val(ht.date_ht);
				$( "#conclusion_ht" ).val(ht.conclusion);
				$( "#notes_ht" ).val(ht.notes);
				$( "#technical_ht" ).val(technical);
			
			}else{
				$( "#date_ht" ).val('');
				$( "#conclusion_ht" ).val('');
				$( "#notes_ht" ).val('');
				$( "#approve_technical_ht" ).prop('checked', false);
			    $( "#approve_admin_ht" ).prop('checked', false);
	
			}

			if(data2){
				let us = JSON.parse(data2);//linea nueva
			
				$("#user_create").val(us.user_create);//lineas nuevas
				$("#user_modify").val(us.user_modify);
				$("#user_approve").val(us.user_approve);
				$("#date_create").val(us.date_create);
				$("#date_modify").val(us.date_modify);
				$("#date_approve").val(us.date_approve);//fin lineas nuevas
				$("#technical_name_ht" ).val(technical);
				
                
				
	           $("#ht_popover").popover( 
	
		          { html: true,
		            title: "Información",
		            content: "Creado por: " +us.user_create +"<br />"+"Fecha creación: "+ 
					us.date_create+"<br />"+"Modificado por: " +us.user_modify+"<br />"+"Fecha mod.: "+ us.date_modify+"<br />"+
		             "Aprobado por: " +us.user_approve+"<br />"+"Fecha aprv.: "+ us.date_approve,
                	});
			
			}else { 
				$("#user_create").val("");//lineas nuevas
				$("#user_modify").val("");
				$("#user_approve").val("");
				$("#date_create").val("");
				$("#date_modify").val("");
				$("#date_approve").val("");
				$("#technical_name_ht" ).val("");
				$("#ht_popover").popover( 
	
					{ html: true,
					  title: "Información",
					  content: "Creado por: " +"" +"<br />"+"Fecha creación: "+ 
					""+"<br />"+"Modificado por: " +""+"<br />"+"Fecha mod.: "+ ""+"<br />"+
					   "Aprobado por: " +""+"<br />"+"Fecha aprv.: "+ "",
					  });
			}

			if(config){
				let settings = JSON.parse(config);//linea nueva
			
				$("#speed_c").val(settings.config_speed);//lineas nuevas
				$("#presion_c").val(settings.config_presion);
				$("#caudal_c").val(settings.config_caudal);
				$("#temperature_c").val(settings.config_time);
			
			
			}else { 
				$("#speed_c").val("true");//lineas nuevas
				$("#presion_c").val("true");
				$("#caudal_c").val("true");
				$("#temperature_c").val("true");
			}


			if(technical){
				let a = $(`option[name ="${technical}"]`).val();
				$("#technical_ht").val(a);
			}else{
				$("#technical_ht").val('');
			}
           
			technicals_user_ht = xhr.response[0].user_assignment;
            $("#technical_aux").val(technicals_user_ht);
            disabledAlert_ht();
		}else { 
            alert_not_evaluation_ht(xhr.response.msg);
        }
	});
	xhr.send();
}

alert_not_evaluation_ht = (msg)=>{
	
    $("#hydraulic_info" ).css("display","none");
	$("#card-option-ht").css("display","none");
    $("#alert_hydraulicTest").addClass("alert alert-warning col-md-6 mb-3").text("Aviso : "+ msg);
    $("#title_alert_ht").text( "Detalle:");
}

disabledAlert_ht= () =>{

    $("#hydraulic_info" ).show();
	$("#card-option-ht").show();
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
					$("#technical_ht").val(technicals_user_ht);
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






const tabla_ht = $("#table-ht").DataTable({
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
		{
			defaultContent: `<button type='button' name='editButton' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='deleteButton' class='btn btn-danger'>
                                    Eliminar
                                  <i class="fas fa-times"></i>
                              </button>`,
		},
	],
});

let edit= false;
let currentID= 0;

$("#table-ht").on("click", "button", function () {
	let data = tabla_ht.row($(this).parents("tr")).data();
	if ($(this)[0].name == "deleteButton") {
		swal({
			title: `Eliminar dato`,
			icon: "warning",
			text: `¿Está seguro/a de Eliminar el dato: "${data.id}"?`,
			buttons: {
				confirm: {
					text: "Eliminar",
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
				deleted(data.id);
			} else {
				swal.close();
			}
		});
	}else { 
		edit=true;
		currentID=data.id;
        $("#title_modal").text("Editar registro");
		$('#id_medidas').val(data.id);
		$('#dato').val(data.dato);
		$('#speed').val(data.speed);
		$('#presion').val(data.presion);
	    $('#caudal').val(data.caudal);
	    $('#time').val(data.time);
        $("#medidas").modal("show");
        
	}
});

		
get_info_ht = () =>{

    id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_info_ht/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			
			let info = xhr.response[0].extra_info;
			let c=xhr.response[0].config;

            setting = JSON.parse(c);
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

		if(setting){
			if(setting.config_speed === "false"){ tabla_ht.columns([1]).visible(false);$("#frm_speed").css("display",'none'); }else{tabla_ht.columns([1]).visible(true); $("#frm_speed").show();}
			if(setting.config_presion === "false"){ 
				tabla_ht.columns([2]).visible(false);$("#frm_presion").css("display",'none'); }else{tabla_ht.columns([2]).visible(true);$("#frm_presion").show();}
			if(setting.config_caudal === "false"){ 
				tabla_ht.columns([3]).visible(false); $("#frm_caudal").css("display",'none');}else{tabla_ht.columns([3]).visible(true);$("#frm_caudal").show();}
			if(setting.config_time === "false"){ 
				tabla_ht.columns([4]).visible(false);$("#frm_time").css("display",'none'); }else{tabla_ht.columns([4]).visible(true);$("#frm_time").show();}
		}
	}
	});
	xhr.send();
}

// Delete by id
deleted= (key) =>{
	id= $("#ot_number").val();
    
	let data2 = {
		id: $("#ot_number").val(),
        date_ht :$("#date_ht").val(),
        conclusion: $("#conclusion_ht").val(),
        notes: $("#notes_ht").val(),
        technical: $("#technical_aux").val(),
		technical_name: $("#technical_name_ht").val(),
		config_speed:$("#speed_c").val(),//lineas nuevas
		config_presion:$("#presion_c").val(),
		config_caudal:$("#caudal_c").val(),
		config_temperature:$("#temperature_c").val(),
		
	};

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_info_ht/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let info = xhr.response[0].extra_info;
			info1 = JSON.parse(info);
			update =  info1.filter(function(item) {
				return item.id != key;
			});//filter all "id"  different to "key_id" 
			data =JSON.stringify(update);

			$.ajax({
				data: {
					data,data2
				},
				type: "POST",
				url: host_url + `api/editInfoHt/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: () => {
					   
						get_info_ht();
						medida=[];
				},
				error: () => {
					swal({
						title: "Denegado!",
						icon: "error",
						text: "No se han podido eliminar los datos ",
					}).then(() => {
					 swal.close();
					});	 
				},
			});     
	}
});
  xhr.send();
	
}




 
edit_by_info= (key) =>{
   
	let data2 = {
		id: $("#ot_number").val(),
        date_ht :$("#date_ht").val(),
        conclusion: $("#conclusion_ht").val(),
        notes: $("#notes_ht").val(),
        technical: $("#technical_aux").val(),
		technical_name: $("#technical_name_ht").val(),
		config_speed:$("#speed_c").val(),//lineas nuevas
		config_presion:$("#presion_c").val(),
		config_caudal:$("#caudal_c").val(),
		config_temperature:$("#temperature_c").val(),
		
	};
    
   valid = true;
   if($('#dato').val()== ""){ valid = false; }
   if($('#speed').val()== ""){ valid = false; }
   if($('#presion').val()== ""){ valid = false; }
   if($('#caudal').val()== ""){ valid = false; }
   if($('#time').val()== ""){ valid = false; }

   if(valid){

	id= $("#ot_number").val(); 
	let data1 = {
		id:1, 
		dato:$('#dato').val(),
		speed:$('#speed').val(),
		presion:$('#presion').val(),
		caudal:$('#caudal').val(),
		time:$('#time').val(),
	};

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_info_ht/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let info = xhr.response[0].extra_info;
			update = JSON.parse(info);
	
			update.forEach((item)=>{
				if(item.id === key) {
					item.dato=data1.dato;
					item.speed=data1.speed;
					item.presion=data1.presion;
					item.caudal=data1.caudal;
					item.time=data1.time;
				}
		  });
      
		  data =JSON.stringify(update);
		 
			$.ajax({
				data: {
					data,data2
				},
				type: "POST",
				url: host_url + `api/editInfoHt/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: () => {
					swal({
						title: "Exito",
						icon: "success",
						text: "El registro se edito con exito",
					}).then(() => {
						swal.close();
						$("#medidas").modal("hide");
						get_info_ht();
						medida=[];
					   });	 
						
				},
				error: () => {
					swal({
						title: "Denegado!",
						icon: "error",
						text: "No se han podido eliminar los datos ",
					}).then(() => {
					 swal.close();
					});	 
				},
			});     
       }
});
		
xhr.send();

}else { 
	swal({
		title: "Registro denegado!",
		icon: "error",
		text: "Complete  todos los campos  ",
	}).then(() => {
	 swal.close();
	});	 


}

	
}




// create register  
edit_info =()=>{

	let data2 = {
		id: $("#ot_number").val(),
        date_ht :$("#date_ht").val(),
        conclusion: $("#conclusion_ht").val(),
        notes: $("#notes_ht").val(),
        technical: $("#technical_aux").val(),
		technical_name: $("#technical_name_ht").val(),
		config_speed:$("#speed_c").val(),//lineas nuevas
		config_presion:$("#presion_c").val(),
		config_caudal:$("#caudal_c").val(),
		config_temperature:$("#temperature_c").val(),
		
	};


	id= $("#ot_number").val();
    let data1 = {
			id:1, 
			dato:$('#dato').val(),
			speed:$('#speed').val(),
			presion:$('#presion').val(),
			caudal:$('#caudal').val(),
			time:$('#time').val(),
		};

	if(medida.length === 0){ medida.push(data1);
	}else{  medida.push(data1);
	        medida.forEach((item,index)=>{ //actualiza id  para cada registro en orden creciente
		    item.id= index;
	});}
	
	data=JSON.stringify(medida);
	
	$.ajax({
		data: {
			data,
			data2
		},
		type: "POST",
		url: host_url + `api/editInfoHt/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			swal({
				title: "Exito",
				icon: "success",
				text: "El registro se creo con éxito.",
				button: "OK",
			}).then(() => {
				get_info_ht();
				$("#medidas").modal("hide");
				medida=[];
		
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


}



showExportHidraulicTest = () => { 
    console.log(config);
	id= $("#ot_number").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getHydraulicTestByOrder/${id}`);
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

	

    
clearInput=()=> { 
	$("#title_modal").text("Agragar registro ");
	$('#dato').val("");
	$('#speed').val("");
    $('#presion').val("");
    $('#caudal').val("");
	 $('#time').val("");

};



save_config = () => { 
	let id= $("#ot_number").val();

	let data = {
		//technical_name: $("#technical_name_ht").val(),
		config_speed: $("#config_speed").is(':checked'),
		config_presion: $("#config_presion").is(':checked'),
		config_caudal:$("#config_caudal").is(':checked'),
		config_time:$("#config_time").is(':checked'),
		}

		$("#speed_c").val(data.config_speed);//lineas nuevas
		$("#presion_c").val(data.config_presion);
		$("#caudal_c").val(data.config_caudal);
		$("#temperature_c").val(data.config_time);
	
    let data2={
		id: $("#ot_number").val(),
        date_ht :$("#date_ht").val(),
        conclusion: $("#conclusion_ht").val(),
        notes: $("#notes_ht").val(),
        technical: $("#technical_ht").val(),
		technical_name: $("#technical_name_ht").val(),
		config_speed:$("#speed_c").val(),//lineas nuevas
		config_presion:$("#presion_c").val(),
		config_caudal:$("#caudal_c").val(),
		config_temperature:$("#temperature_c").val(),
	}

	

	
//[{"id":1,"dato":"213132","speed":"qwqe","presion":"12132","caudal":"123","time":"123"}]
	
    config.push(data);

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_info_ht/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		
		if (xhr.status === 200) {
			
			let info = xhr.response[0].extra_info;
			d = JSON.parse(info);
			data3= JSON.stringify(d);


			$.ajax({
				data: {
					data,data2,data3
				},
				type: "POST",
				url: host_url + `api/save_config/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: (result) => {
					swal({
						title: "Exito",
						icon: "success",
						text: "Configuración guardada.",
						button: "OK",
					}).then(() => {
						get_info_ht();
						$("#config").modal("hide");
						
						medida=[];
				
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
		}	
		
});
xhr.send();
}


$("#ht_btnEdit").on("click", ht_enableFields);

$("#btn_config").on("click", ()=>{	
	$("#config").modal("show");
}); 

$("#btn_export_ht").on("click",()=>{
	showExportHidraulicTest();
});


$("#btn_hidraulic").on("click", ()=>{

	swal({
		title: `Confirmación de guardado `,
		icon: "warning",
		text: `¿Está seguro/a de guardar definitivamente este informe de prueba hidráulica?`,
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
		    edit_ht();
		} else {
			swal.close();
		}
	});
	});


$("#btn_hidraulic").on("click", edit_ht);
$("#save_config").on("click", save_config);

$("#btn_information").on("click", ()=>{	
	edit=false;
	clearInput();
	$("#medidas").modal("show");});


$("#edit_information").on("click", ()=>{
 if(edit){ 
	edit_by_info(currentID);
 }else { 
	edit_info();
 }
});
 



