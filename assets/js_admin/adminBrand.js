$(() => {
	getBrand();
});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	},
});

$("#name").change(() => { 
	let name = $("#name").val();
	if(name){
		$("#frm_name > input").removeClass("is-invalid");
	}else{
		$("#frm_name > input").addClass("is-invalid");
	}
});

var edit = false;
var idEdit = 0;
let currentName = "_[[][ÑLLKLHHGHJKUUHYT%&%%$%//&%%$%%$$#";

const tabla = $("#table-brand").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        {className: "text-center", "targets": [2]},
		{className: "text-center", "targets": [3]}
    ],
	columns: [
        { data: "name" },
		{ data: "state" },
		{
			defaultContent: `<button type='button' name='editButton' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
		{
			defaultContent: `<button type='button' name='deleteButton' class='btn btn-danger'>
                                    Bloquear/Desbloquear
                                  <i class="fas fa-times"></i>
                              </button>`,
		},
	],
});

addErrorStyle = (errores) => {
	let arrayErrores = Object.keys(errores);
	arrayErrores.map((err) => {
		$(`.${err}`).show();
	});
};

getBrand = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getBrand`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response.map((u) => {
				if (u.state == 1) {
					u.state = "En utilización";
				} else {
					u.state = "Suspendido";
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
				text: "Error al obtener las marcas",
			});
		}
	});
	xhr.send();
};

$("#table-brand").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	
	if ($(this)[0].name == "deleteButton") {
		swal({
			title: `Bloquear/Desbloquear ubicación`,
			icon: "warning",
			text: `¿Está seguro/a de Bloquear/Desbloquear la marca: "${data.name}"?`,
			buttons: {
				confirm: {
					text: "Bloquear/Desbloquear",
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
				bloquearDesbloquearBrand(data.id, data.state);
			} else {
				swal.close();
			}
		});
	} else {
		edit = true;
		idEdit = data.id;
        currentName = data.name;
		cleanInput();
        $("#title").text("Modificar marca");
        $("#name").val(data.name);
		$("#id").val(data.id);
		$("#addBrand").modal("show");
	}
});

bloquearDesbloquearBrand = (id, state) => {
	let data = {
		state: state == "En utilización" ? 0 : 1,
		id: id,
    };
    
	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + "api/changeStateBrand",
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
				getBrand();
			});
		},
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});
};

registerBrand = () => {
	let data = {
		name: $("#name").val(),
        id: $("#id").val(),
    };

	if (currentName != data.name) {
	let url = "";
	if (edit) url = "api/editBrand";
	else url = "api/createBrand";
	Object.keys(data).map((d) => $(`.${d}`).hide());
	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + url,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
            
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				$("#addBrand").modal("hide");
				tabla.rows().remove().draw();
				getBrand();
				edit = false;
				idEdit = 0;
			});
		},
		error: (result) => {


			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			}).then(() => {
				if(result.responseJSON.err){$("#frm_name > div").html(result.responseJSON.err); $("#frm_name > input").addClass("is-invalid");}
			});
          },
	});

}else{
	swal({
		title: "Error",
		icon: "error",
		text: "Ingrese un nombre diferente al actual.",
	});

}



};

cleanInput = () => {
    $("#title").text("Crear marca");
    $("#id").val("");
	$("#name").val("");
	$(`.name`).hide();
    $(`.id`).hide();
	$("#frm_name > input").removeClass("is-invalid");

};

$("#btn").on("click", () => {
	cleanInput();
	edit = false;
	idEdit = 0;
	$("#addBrand").modal("show");
});

$("#createBrand").on("click", () => {
	registerBrand();
});