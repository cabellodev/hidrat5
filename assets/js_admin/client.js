$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    get_clients();
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

$("#enterprise").change(() => { 
	let enterprise = $("#enterprise").val();
	if(enterprise){
		$("#frm_enterprise > select").removeClass("is-invalid");
	}else{
		$("#frm_enterprise > select").addClass("is-invalid");
	}
});

$("#seller").change(() => { 
	let seller = $("#seller").val();
	if(seller){
		$("#frm_seller > select").removeClass("is-invalid");
	}else{
		$("#frm_seller > select").addClass("is-invalid");
	}
});


let edit = false; /*Variable para determinar si se editara o creara*/
let emailEdit = ""; /*Variable que almacenara el nombre para editar*/
let op = []; /*Variable que almacenara los roles*/
let enterprises = []; /*Variable que almacenara las empresas*/
let sellers = []; /*Variable que almacenara los vendedores*/


/*Funcion para recuperar los clientes*/
get_clients = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/get_clients`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response[0].map((u) => {
				if (u.state == 1) {
					u.state = "Activo";
				} else {
					u.state = "Bloqueado";
                }
				return u;
            });
            if(op.length == 0){
                xhr.response[1].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.description);
                    $(option).html(u.description); 
                    $(option).appendTo("#range");
                    op.push(u.description);
                });
            }
            if(enterprises.length == 0){
                xhr.response[2].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.name);
                    $(option).html(u.name); 
                    $(option).appendTo("#enterprise");
                    enterprises.push(u.name);
                });
            }
            if(sellers.length == 0){
                xhr.response[3].map((u) => {
                    let option = document.createElement("option"); 
                    $(option).val(u.id); 
                    $(option).attr('name', u.full_name);
                    $(option).html(u.full_name); 
                    $(option).appendTo("#seller");
                    sellers.push(u.full_name);
                });
            }
            tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los clientes",
			});
		}
	});
	xhr.send();
};

/*Constante para rellenar las filas de la tabla: lista de clientes*/
const tabla = $('#list_client').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    columnDefs: [
        {className: "text-center", "targets": [5]},
		{className: "text-center", "targets": [6]}
    ],
	columns: [
        { data: "name" },
        { data: "email" },
        { data: "enterprise" },
        { data: "seller" },
        { data: "role" },
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

/*Funcion para crear y editar un cliente */
create_edit_client = () =>{
    //Discriminar si se debe crear o editar
    let url = "";
    let data = "";
    let full_name = $("#full_name").val();
    let passwd = $("#passwd").val();
    let email = $("#email").val();
    let range = $("#range").val();
    let enterprise = $("#enterprise").val();
    let seller = $("#seller").val();
    let state = ($("#state").val() == "Activo" ? 1 : 0);
    if(edit){
     url = "api/update_client";
     data = {full_name: full_name, email:email, seller:seller , range:range, enterprise:enterprise, state: state, email_old: emailEdit};
    }else{
     url = "api/create_client";
     data = {full_name: full_name, passwd:passwd, seller:seller , email:email, enterprise:enterprise, range:range, state: 1};
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
             emailEdit ="";
             close_modal_client();
             tabla.rows().remove().draw();
             get_clients();
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
                if(msg.full_name){$("#frm_full_name > div").html(msg.full_name); $("#frm_full_name > input").addClass("is-invalid");}
                if(msg.passwd){$("#frm_passwd > div").html(msg.passwd); $("#frm_passwd > input").addClass("is-invalid");}
                if(msg.email){$("#frm_email > div").html(msg.email); $("#frm_email > input").addClass("is-invalid");}
                if(msg.range){$("#frm_range > div").html(msg.range); $("#frm_range > select").addClass("is-invalid");}
                if(msg.enterprise){$("#frm_enterprise > div").html(msg.enterprise); $("#frm_enterprise > select").addClass("is-invalid");}
                if(msg.seller){$("#frm_seller > div").html(msg.seller); $("#frm_seller > select").addClass("is-invalid");}
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

 /*Función para des/habilitar un cliente*/
des_hab_client= (email, state) => {
    let state_change = (state == 0 ? 1 : 0);
    let data = {
        email: email,
		state: state_change,
    };
    $.ajax({
        type: "POST",
        url: host_url + "api/des_hab_client",
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
				get_clients();
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

/*Función para setear modal crear cliente*/
$("#btn").click(() => { 
    edit = false;
    emailEdit = "";
    $("#btn_ok").text("Crear cliente");
    $("#titulo").text("Crear cliente");
    $("#modal_client").modal("show");
    $("#frm_passwd").show();
});

/*Función para crear o editar client*/
$('#btn_ok').click(() => { 
    create_edit_client();  
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/
$("#list_client").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_des_hab") {
        show_info_des_hab_client(data);
    } else {
        show_info_update_client(data);
    }
});

/*Función para preparar la información a editar*/
show_info_update_client = (data) =>{
    edit = true;
    emailEdit = data.email;
    $("#full_name").val(data.name);
    $("#email").val(data.email);

    let a = $(`option[name ="${data.role}"]`).val();
    $("#range").val(a);

    let b = $(`option[name ="${data.enterprise}"]`).val();
    $("#enterprise").val(b);

    let c = $(`option[name ="${data.seller}"]`).val();
    $("#seller").val(c);

    $("#state").val(data.state);

    $("#frm_state").show();
    $("#frm_passwd").hide();

    $("#titulo").text("Editar Cliente");
    $("#btn_ok").text("Guardar Cambios");
    $("#modal_client").modal("show");
}

/*Función para preparar la información a des/habilitar*/
show_info_des_hab_client = (data) =>{
    let state = (data.state == "Activo" ? 1 : 0);
    let msg_text =""
    let title =""
    if(data.state == 'Activo') {state = 1; msg_text="¿Está seguro/a de deshabilitar al cliente:"; title="Deshabilitar"}
    else {state = 0; msg_text="¿Está seguro/a de Habilitar al cliente:"; title="Habilitar";};

    swal({
        title: `${title} cliente`,
        icon: "warning",
        text: `${msg_text} ${data.full_name}"?`,
        buttons: {
            confirm: {
                text: `${title}`,
                value: "hab_des_client",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "hab_des_client") {
            des_hab_client(data.email, state);
        } else {
            swal.close();
        }
    });
}

/*Función para cerrar y limpiar el modal utilizado para crear y editar cliente*/
close_modal_client = () =>{
    $("#passwd").val("");
    $("#full_name").val("");
    $("#email").val("");
    $("#range").val("");
    $("#enterprise").val("");
    $("#seller").val("");
    $("#frm_state").hide();
    $("#frm_passwd > input").removeClass("is-invalid");
    $("#frm_full_name > input").removeClass("is-invalid");
    $("#frm_email > input").removeClass("is-invalid");
    $("#frm_enterprise > select").removeClass("is-invalid");
    $("#frm_range > select").removeClass("is-invalid");
    $("#frm_seller > select").removeClass("is-invalid");
    $('#modal_client').modal('hide');
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