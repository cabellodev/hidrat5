$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getSubstaks();
});

$("#date_admission").change(() => { 
	let date_admission = $("#date_admission").val();
	if(date_admission){
		$("#frm_date_admission > input").removeClass("is-invalid");
	}else{
		$("#frm_date_admission > input").addClass("is-invalid");
	}
});

$("#technical_assistant").change(() => { 
	let technicalAssistant = $("#technical_assistant").val();
	if(technicalAssistant){
		$("#frm_technical_assistant > select").removeClass("is-invalid");
	}else{
		$("#frm_technical_assistant > select").addClass("is-invalid");
	}
});

$("#substak").change(() => { 
	let substak = $("#substak").val();
	if(substak){
		$("#frm_substak > select").removeClass("is-invalid");
	}else{
		$("#frm_substak > select").addClass("is-invalid");
	}
});

let substaks = []; /*Variable que almacenara las subtareas*/
let technicalAssistant = []; /*Variable que almacenara los ayudantes técnicos*/
let edit = false; /*Variable para determinar si se editara o creara*/
let idEdit = ""; /*Variable que almacenara el id de la subtarea para editar*/

/*Funcion para recuperar las ordenes de trabajo*/
getSubstaks = () => {
    let id = $('#ot_id').val();
	let xhr = new XMLHttpRequest();
	xhr.open("post", `${host_url}/api/tmGetSubstaksReparation`);
    xhr.open("get", `${host_url}/api/tmGetSubstaksReparation/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            console.log(data);
            let substaksReparation = data[0];
            let technicalAssistantData = data[1];
            let substaksData = data[2];
            let stateRep = data[3][0]['check_technical'];
            let aux = [];
            console.log(data);
            if(substaksReparation){
                substaksReparation.forEach((item)=>{
                    let check_tm;
                    let check_at;
                    console.log(item);

                    if(item.check_tm == '1') check_tm = 'Aprobado';
                    else check_tm = 'No aprobado';
                    
                    if(item.check_at == '1') check_at = 'Realizado';
                    else check_at = 'No realizado';
                    substak = 
                    {
                        number_ot : item.number_ot,
                        id: item.id,
                        date : item.date,
                        substask: item.substask,
                        technical_assistant: item.technical_assistant,
                        check_tm: check_tm,
                        check_at: check_at,
                        state: item.state == "1" ? 'Activo' : 'Bloqueado',
                        state_ev: stateRep
                    }
                    aux.push(substak);
                    console.log(substak);
                });
                tabla.clear();
                tabla.rows.add(aux);	
                tabla.draw();  
            }
          
            if(stateRep=='1'){
                $('#btn_create_substak').hide();
            }

            if(technicalAssistant.length == 0){
                technicalAssistantData.map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#technical_assistant");
                    technicalAssistant.push(u.name);
                });
            }
            
            if(substaks.length == 0){
                substaksData.map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#substak");
                    substaks.push(u.name);
                });
            }
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las subtareas",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#tableSubstaksReparations').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [8, 9] ,
        },
    ],
	columns: [
        { data: "number_ot"}, 
        { data: "id" }, 
        { data: "date" }, 
        { data: "substask" }, 
        { data: "technical_assistant" },
        { data: "check_at" },  
        { data: "check_tm" }, 
        { data: "state" }, 
        {   defaultContent: "oc",
            "render": function (data, type, row){
                if(row.state_ev == '1'){
                    return `<button type='button'  class='btn btn-primary'>
                    Detalles
                    </button>`
                }else{
                    return `<button type='button' name='btn_update' class='btn btn-primary'>
                    Detalles
                    </button>`
                }
            }
        },// end defaultContent
        {   defaultContent: "oc",
            "render": function (data, type, row){
                if(row.state_ev == '1'){
                    return `<button type='button' class='btn btn-danger'>
                        Bloquear/Desbloquear
                        <i class="fas fa-times"></i>
                    </button>`
                }else{
                    return `<button type='button' name='btn_des_hab' class='btn btn-danger'>
                        Bloquear/Desbloquear
                        <i class="fas fa-times"></i>
                    </button>`
                }
            }
        },// end defaultContent
	],
});

/*Función para setear modal crear usuario*/
$("#btn").click(() => { 
    edit = false;
    idEdit = "";
    $("#frm_check_tm").hide();
    $("#frm_check_at").hide();
    $("#tr_check_technical_master").prop('checked', false);
    $("#tr_check_technical_assistant").prop('checked', false);
    $("#btn_ok").text("Crear subtarea");
    $("#titulo").text("Crear subtarea");
    $("#modalSubstaks").modal("show");
});

/*Función para crear o editar usuario*/
$('#btn_ok').click(() => { 
    create_edit_substask();  
});


$("#tableSubstaksReparations").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_substask(data);
    } else if ($(this)[0].name == "btn_update"){
        show_info_update_substask(data);
    }
});

/*Funcion para crear y editar un usuario */
create_edit_substask = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let date = $('#date_admission').val();
    let user_id = $('#technical_assistant').val();
    let subtask_id = $('#substak').val();
    let check_tm =  $('#tr_check_technical_master').is(':checked') ? 1 : 0;
    let check_at = $('#tr_check_technical_assistant').is(':checked') ? 1 : 0;

    if(edit){
        url = "api/update/substakReparation";
        data = {id: idEdit, subtask_id: subtask_id ,user_id: user_id, check_at: check_at, check_tm: check_tm, date_assignment: date,ot_id : $('#ot_id').val()};
    }else{
        url = "api/create/substakReparation";
        data = {user_id: user_id, subtask_id: subtask_id , date_assignment: date, ot_id : $('#ot_id').val()};
    } 
    console.log(data);
    $.ajax({
        type: "POST",
        url: host_url + url,
        data: {data},
        dataType: "json",
        success: (result) => {
         swal({
             title: "Éxito!",
             icon: "success",
             text: result.msg,
             button: "OK",
         }).then(() => {
             edit = false;
             idEdit = "";
             close_modal();
             tabla.rows().remove().draw();
             getSubstaks();
         });
        }, 
        statusCode: {
         400: (xhr) => {
             let msg = xhr.responseJSON;
             swal({
                 title: "Error",
                 icon: "error",
                 text: addErrorStyle(msg),
             }).then(() => {
                if(msg.date){$("#frm_date_admission > div").html(msg.date); $("#frm_date_admission > input").addClass("is-invalid");}
                if(msg.substak){$("#frm_substak > div").html(msg.substak); $("#frm_substak > select").addClass("is-invalid");}
                if(msg.ta){$("#frm_technical_assistant > div").html(msg.ta); $("#frm_technical_assistant > select").addClass("is-invalid");}
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

/*Función para des/habilitar una empresa */
des_hab_sub = (id, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        id: id,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab/substakReparation",
        data: {data},
        crossOrigin: false,
        dataType: "json",
        success: (result) => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				tabla.rows().remove().draw();
				getSubstaks();
			});
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

/*Función para preparar la información a editar*/
show_info_update_substask = (data) =>{
    edit = true;
    idEdit = data.id;

    $("#date_admission").val(data.date);

    let a = $(`option[name ="${data.substask}"]`).val();
    $("#substak").val(a);

    let b = $(`option[name ="${data.technical_assistant}"]`).val();
    $("#technical_assistant").val(b);

    if(data.check_at == 'Realizado') $("#tr_check_technical_assistant").prop('checked', true);

    if(data.check_tm == 'Aprobado')  $("#tr_check_technical_master").prop('checked', true);

    $("#frm_check_tm").show();
    $("#frm_check_at").show();
    $("#titulo").text("Editar Substask");
    $("#btn_ok").text("Guardar Cambios");
    $("#modalSubstaks").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_substask = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de bloquear la subtarea:"; title="Bloquear"}
    else {state = 0; msg_text="¿Está seguro/a de Desbloquear la subtarea:"; title="Desbloquear";};

    swal({
        title: `${title} subtarea`,
        icon: "warning",
        text: `${msg_text} ${data.substask}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "bloq_des_sub",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "bloq_des_sub") {
            des_hab_sub(data.id, state);
        } else {
            swal.close();
        }
    });
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

/*Función para cerrar y limpiar el modal utilizado para crear y editar usuario*/
close_modal = () =>{
    $("#substak").val("");
    $("#technical_assistant").val("");
    $("#date_admission").val("");
    $("#tr_check_technical_master").prop('checked', false);
    $("#tr_check_technical_assistant").prop('checked', false);
    $("#frm_date_admission > input").removeClass("is-invalid");
    $("#frm_technical_assistant > select").removeClass("is-invalid");
    $("#frm_substak > select").removeClass("is-invalid");
    $('#modalSubstaks').modal('hide');
}
