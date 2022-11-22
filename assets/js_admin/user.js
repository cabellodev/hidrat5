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
    get_users();
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

$("#full_name").change(() => { 
	let name = $("#full_name").val();
	if(name){
		$("#frm_full_name > input").removeClass("is-invalid");
	}else{
		$("#frm_full_name > input").addClass("is-invalid");
	}
});

$("#passwd").change(() =>{ 
	let pass = $("#passwd").val();
	if(pass){
		$("#frm_passwd > input").removeClass("is-invalid");
	}else{
		$("#frm_passwd > input").addClass("is-invalid");
	}
});

$("#email").change(() => { 
	let email = $("#email").val();
	let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
	if(email && emailRegex.test(email)){
		$("#frm_email > input").removeClass("is-invalid");
	}else{
		$("#frm_email > input").addClass("is-invalid");
	}
});

$("#range").change(() => { 
	let range = $("#range").val();
	if(range){
		$("#frm_range > select").removeClass("is-invalid");
	}else{
		$("#frm_range > select").addClass("is-invalid");
	}
});

let edit = false; /*Variable para determinar si se editara o creara*/
let rutEdit = ""; /*Variable que almacenara el id para editar*/
let emailEdit = ""; /*Variable que almacenara el nombre para editar*/
let op = []; /*Variable que almacenara los roles*/

/*Funcion para recuperar los usuarios*/
get_users = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_users`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response[0].map((u) => {
				if (u.state == 1) {
					u.state = "Activo";
				} else {
					u.state = "Bloqueado";
				}
				return u;
            });
            if(op.length == 0){
                let rol = xhr.response[1].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.description);
                    $(option).html(u.description); 
                    $(option).appendTo("#range");
                    op.push(u.description);
                });
            }
			tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los usuarios",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de usuarios*/
const tabla = $('#list_user').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    columnDefs: [
        {className: "text-center", "targets": [5]},
		{className: "text-center", "targets": [6]}
    ],
	columns: [
		{ data: "rut" },
        { data: "full_name" },
        { data: "email" },
        { data: "description" },
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

/*Función para setear modal crear usuario*/
$("#btn").click(() => { 
    edit = false;
    rutEdit = "";
    emailEdit = "";
    $("#btn_ok").text("Crear usuario");
    $("#titulo").text("Crear usuario");
    $("#modal_user").modal("show");
    $("#frm_passwd").show();
});

/*Función para crear o editar usuario*/
$('#btn_ok').click(() => { 
    create_edit_user();  
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo usuario*/
$("#list_user").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_user(data);
    } else {
        show_info_update_user(data);
    }
});

/*Funcion para crear y editar un usuario */
create_edit_user = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let rut = $("#rut").val();
    let full_name = $("#full_name").val();
    let passwd = $("#passwd").val();
    let email = $("#email").val();
    let range = $("#range").val();
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/update_user";
     data = {rut: rut, full_name: full_name, email:email, range:range, state: state, rut_old: rutEdit, email_old: emailEdit};
    }else{
     url = "api/create_user";
     data = {rut: rut, full_name: full_name, passwd:passwd,  email:email, range:range, state: 1};
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
             rutEdit = "";
             emailEdit ="";
            
             close_modal_user();
             tabla.rows().remove().draw();
             get_users();
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
                if(msg.full_name){$("#frm_full_name > div").html(msg.full_name); $("#frm_full_name > input").addClass("is-invalid");}
                if(msg.passwd){$("#frm_passwd > div").html(msg.passwd); $("#frm_passwd > input").addClass("is-invalid");}
                if(msg.email){$("#frm_email > div").html(msg.email); $("#frm_email > input").addClass("is-invalid");}
                if(msg.range){$("#frm_range > div").html(msg.range); $("#frm_range > select").addClass("is-invalid");}
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
des_hab_user= (rut, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        rut: rut,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_user",
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
				get_users();
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
show_info_update_user = (data) =>{
    edit = true;
    rutEdit = data.rut;
    emailEdit = data.email;
    $("#rut").val(data.rut);
    $("#full_name").val(data.full_name);
    $("#email").val(data.email);
    let a = $(`option[name ="${data.description}"]`).val();
    $("#range").val(a);
    $("#state").val(data.state);

    $("#frm_state").show();
    $("#frm_passwd").hide();

    $("#titulo").text("Editar Usuario");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_user").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_user = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar al usuario:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de Habilitar al usuario:"; title="Habilitar";};

    swal({
        title: `${title} usuario`,
        icon: "warning",
        text: `${msg_text} ${data.full_name}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_user",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_user") {
            des_hab_user(data.rut, state);
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
close_modal_user = () =>{
    $("#rut").val("");
    $("#passwd").val("");
    $("#full_name").val("");
    $("#email").val("");
    $("#range").val("");
    $("#frm_state").hide();
    $("#frm_rut > input").removeClass("is-invalid");
    $("#frm_passwd > input").removeClass("is-invalid");
    $("#frm_full_name > input").removeClass("is-invalid");
    $("#frm_email > input").removeClass("is-invalid");
    $("#frm_range > select").removeClass("is-invalid");
    $('#modal_user').modal('hide');
}

