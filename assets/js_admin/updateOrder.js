$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

let check_evaluation_old = $('#check_evaluation').is(':checked');
let check_report_technical_old = $('#check_report_technical').is(':checked');
let check_hydraulic_test_old = $('#check_hydraulic_test').is(':checked');
let ot_number_old = $('#ot_number').val();
let location_old = $('#location').val();
let service_old = $('#service').val();


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

updateOrder = () => {
    let data = {
        ot_number : $('#ot_number').val(),
        enterprise : $('#enterprise').val(),
        service : $('#service').val(),
		service_old : service_old,
        component : $('#component').val(),
        priority : $('#priority').val(),
		problem : $('#problem').val(),
        description : $('#description').val(),
        date_admission : $('#date_admission').val(),
        days_quotation : $('#days_quotation').val(),
		location: $('#location').val(),
		location_old : location_old,
        check_evaluation : $('#check_evaluation').is(':checked'),
        check_report_technical : $('#check_report_technical').is(':checked'),
        check_hydraulic_test : $('#check_hydraulic_test').is(':checked'),
        check_evaluation_old: check_evaluation_old,
        check_report_technical_old: check_report_technical_old,
        check_hydraulic_test_old: check_hydraulic_test_old,
        ot_number_old : ot_number_old, 
    }
    $.ajax({
        type: "POST",
        url: host_url + "api/updateOrder",
        data: {data},
        dataType: "json",
        success: () => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: "órden de trabajo editada con éxito",
             button: "OK",
         }).then(() => {
			redirect(data.ot_number);
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
}

redirect =(id)=>{
	let url = 'stagesOrder'+'?ot='+id;
	window.location.assign(host_url+url);
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

$("#btnUpdate").on("click", updateOrder);