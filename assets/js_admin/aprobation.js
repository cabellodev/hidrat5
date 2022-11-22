
$(()=>{ 
    get_data_ap();
});


let check_client_old= false;

get_data_ap = () =>{

    id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getAprobationByOrder/${id}`);
	xhr.responseType = "json";
	xhr.setRequestHeader("Cache-Control", "no-cache");
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
		
			let data = xhr.response[0];
            let data2 = xhr.response[0].user_interaction;
		//nueva linea
			if(data){ //linea nueva
			    if(data.approve_client === "1" ){	
					$("#approve_client" ).prop('checked', true);
					check_client_old = true;

			    } else {
					$( "#approve_client" ).prop('checked', false );
				    check_client_old = false;                               
				}

				$( "#date_send_qt" ).val(data.date_quotation);
				$( "#date_ap" ).val(data.date_send_qt);
				$( "#number_qt").val(data.number_qt);
			
			}else{
				$( "#date_ap" ).val('');
				$( "#date_send_qt" ).val('');
				$( "#approve_client" ).prop('checked', false);
				$( "#number_qt").val('');
	
			}

			if(data2){
				let us = JSON.parse(data2);//linea nueva
			    $("#user_modify_ap").val(us.user_modify);
				$("#user_approve_ap").val(us.user_approve);
				$("#date_modify_ap").val(us.date_modify);
				$("#date_approve_ap").val(us.date_approve);//fin lineas nuevas			
			}else { 

				$("#user_modify_ap").val("");
				$("#user_approve_ap").val("");
				$("#date_modify_ap").val("");
				$("#date_approve_ap").val("");
				
            } 
			console.log(xhr.response[0]);
			if(xhr.response[0].date_send_email){
			   $("#date_send_email").val(xhr.response[0].date_send_email );
			}

        }else{
            console.log("error al cargar datos ");
        }
	});
	xhr.send();
}



ap_enableFields = ()=>{
    a = $("#hab_edit_ap").val();
    if(a == 0){
        $('#date_ap').prop( "disabled", false );
		$('#date_send_qt').prop( "disabled", false );
		$("#number_qt").prop( "disabled", false );
        $("#approve_client").prop( "disabled", false );
        $('#date_ap').datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
		$('#date_send_qt').datepicker({
            showOn: "button",
            buttonText: "Calendario",
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            buttonImage: host_url + 'assets/img/about/calendario2.png',
        });
		$("#hab_edit_ap").val(1);
        $("#hab_edit_ap").removeClass("btn btn-success");
        $("#hab_edit_ap").addClass("btn btn-danger");
        $("#hab_edit_ap").text("Cancelar");
        $("#btn_aprobation").show();
	}else if(a==1){
        $("#date_ap").prop( "disabled", true );
		$('#date_send_qt').prop( "disabled", true);
		$("#number_qt").prop( "disabled", true );
        $("#approve_client").prop( "disabled", true );
        $("#date_ap").datepicker("destroy");
		$("#date_send_qt").datepicker("destroy");
		$("#hab_edit_ap").val(0);
        $("#hab_edit_ap").removeClass("btn btn-danger");
        $("#hab_edit_ap").addClass("btn btn-success");
        $("#hab_edit_ap").text("Editar");
        $("#btn_aprobation").hide();		
	}
};




edit_ap = () => {

   
	event.preventDefault();
	let id = $("#ot_number").val();//Image ID 
	
	let data = {
        date_ap :$("#date_ap").val(),
		date_send :$("#date_send_qt").val(),
		qt_number:$("#number_qt").val(),
		approve_client: $("#approve_client").is(':checked'),
		user_approve: $("#user_approve_ap").val(),
		date_approve:$("#date_approve_ap").val(),//fin
		check_client_old: check_client_old,
	};



	Object.keys(data).map((d) => $(`.${d}`).hide());
	$.ajax({
		data: {
			data,
		},
		type: "POST",
		url: host_url + `api/editAprobation/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
            swal({
				title: "Exito",
				icon: "success",
				text: result.msg,
                button: "OK",
			}).then(() => {
					$("#hab_edit_ap").val('1');
					$('#hab_edit_ap').prop( "checked", false );
					$("#number_qt").prop( "disabled", true );
					$("#date_send_qt").datepicker("destroy");
					$("#date_send_qt").prop( "disabled", true );
					$("#date_ap").datepicker("destroy");
	                $("#date_ap").prop( "disabled", true );
	                $("#approve_client" ).prop( "disabled", true );
					ap_enableFields();
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

$("#ap_popover").on('click',function(){

	$("#ap_popover").popover(
		{ 
		html: true,
		title: "Información",
		content: "Modificado por: " + $("#user_modify_ap").val()+"<br />"+"Fecha mod.: "+ $("#date_modify_ap").val()+"<br />"+
	    "Aprobado por: " + $("#user_approve_ap").val()+"<br />"+"Fecha aprv.: "+ $("#date_approve_ap").val()+
		"<br />"+"Fecha envio mail cliente: "+ $("#date_send_email").val()
 });
});



$("#btn_aprobation").on("click", edit_ap);

$("#hab_edit_ap").on("click", ap_enableFields);
