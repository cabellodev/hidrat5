/*Proceso para cargar el loading cuando se ejecuta una función ajax*/
$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    $("#rut").rut({
		minimumLength: 8,
		validateOn: "change",
	});
    get_enterprise();
});

/*Falta validar el rut*/
$("#rut").change(() =>{ 
	let rut = $("#rut").val();
	if(rut){
		$("#frm_rut > input").removeClass("is-invalid");
	}else{
		$("#frm_rut > input").addClass("is-invalid");
	}
});

$("#name").change(() => { 
	let name = $("#name").val();
	if(name){
		$("#frm_name > input").removeClass("is-invalid");
	}else{
		$("#frm_name > input").addClass("is-invalid");
	}
});

let edit = false; /*Variable para determinar si se editara o creara*/
let nameEdit = "";
let idEdit = 0; /*Variable que almacenara el id para editar*/

/*Funcion para recuperar los compomentes*/
get_enterprise = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_enterprises`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response.map((u) => {
				if (u.state == 1) {
					u.state = "Activo";
				} else {
					u.state = "Bloqueado";
				}
				return u;
			});
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las empresas",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de componentes*/
const tabla = $('#list_enterprise').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    columnDefs: [
        {className: "text-center", "targets": [3]},
		{className: "text-center", "targets": [4]}
    ],
	columns: [
		{ data: "rut" },
        { data: "name" },
        { data: "state" },
		{
            defaultContent: `<button type='button' name='btn_update' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='btn_des_hab' class='btn btn-danger'>
                                Bloquear/Desbloquear
                                <i class="fas fa-times"></i>
                            </button>`,
                              
		},
	],
});

/*Función para setear modal crear empresa*/
$("#btn").click(() => { 
    edit = false;
    rutEdit = 0;
    nameEdit = "";
    $("#btn_ok").text("Crear empresa");
    $("#titulo").text("Crear Empresa");
    $("#frm_rut > input").removeClass("is-invalid");
    $("#frm_name> input").removeClass("is-invalid");
    $("#modal_component").modal("show");
});

/*Función para crear o editar una nueva empresa*/
$('#btn_ok').click(() => { 
    create_edit_enterprise();  
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo componente*/
$("#list_enterprise").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_enterprise(data);
    } else {
        show_info_update_enterprise(data);
    }
});

/*Funcion para crear y editar una empresa */
create_edit_enterprise = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let rut = $("#rut").val();
    let name = $("#name").val();
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/update_enterprise";
     data = {rut: rut, name: name, state: state, name_old: nameEdit , rut_old: rutEdit};
    }else{
     url = "api/create_enterprise";
     data = {rut: rut, name: name, state: 1};
    } 
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
             rutEdit = 0;
             nameEdit = "";
             close_modal_enterprise();
             tabla.rows().remove().draw();
             get_enterprise();
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
                if(msg.rut){$("#frm_rut > div").html(msg.rut); $("#frm_rut > input").addClass("is-invalid");}
                if(msg.name){$("#frm_name > div").html(msg.name); $("#frm_name > input").addClass("is-invalid");}
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
des_hab_enterprise = (rut, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        rut: rut,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_enterprise",
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
				get_enterprise();
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
show_info_update_enterprise = (data) =>{
    edit = true;
    rutEdit = data.rut;
    nameEdit = data.name;
    $("#rut").val(data.rut);
    $("#name").val(data.name);
    $("#state").val(data.state);

    $("#frm_state").show();
    
    $("#titulo").text("Editar Empresa");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_enterprise").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_enterprise= (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar la empresa:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de Habilitar la empresa:"; title="Habilitar";};

    swal({
        title: `${title} empresa`,
        icon: "warning",
        text: `${msg_text} ${data.name}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_enterprise",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_enterprise") {
            des_hab_enterprise(data.rut, state);
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

/*Función para cerrar y limpiar el modal utilizado para crear y editar componente*/
close_modal_enterprise = () =>{
    $("#rut").val("");
    $("#name").val("");
    $("#frm_state").hide();
    $("#frm_rut > input").removeClass("is-invalid");
    $("#frm_description > input").removeClass("is-invalid");
    $('#modal_enterprise').modal('hide');
}