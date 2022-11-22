$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    get_orders();
});

let idEdit;
showApprove='';


/*Funcion para recuperar las ordenes de trabajo*/
get_orders = () => {
	let row = [];
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrdersApproveByClient`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
			tabla.clear();
			for(i=0; i<data.length;i++){
				row = [data[i]];
				tabla.rows.add(row);
				tabla.order( [ 1, 'desc' ] ).draw();
			}
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las órdenes de trabajo",
			});
		}
	});
	xhr.send();
};



/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $("#table_orders").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	"columnDefs": [
        {
            className: "text-center", "targets": [5] ,
        },
    ],
	columns: [
		{ data: "id" },
		{ data: "date" },
		{ data: "component" },
		{ data: "service" },
		{ data: "state" },
		{ defaultContent: "oc",
		   "render": function (data, type, row){
			if(row.email_send === null){
				return `<button type='button' name='btnApprove' class='btn btn-primary'>
				Aprobar
				<i class="fas fa-thumbs-up"></i>
				</button>`
			}else{
				return `<button type='button' name='' class='btn btn-warning'>
				Aprobado
				<i class="fas fa-user-check"></i>
				</button>`
			}
		   }
		},
	],
});


approve = (data) => {
	idEdit = data.id;
	$("#modalApproveOT").modal("show");
}

saveFile = () =>{

	
    swal({
        title: `Aprobar Cotización`,
        icon: "warning",
        text: `Esta  segur@ de aprobar la cotización?, esta acción es irreversible`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "approve",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "approve") {
			id = $("#ot_number").val();
			let files = $("#oc")[0].files;//files.length
			console.log(document.getElementById("ocs"));
			if(files.length > 0) {
				$.ajax({
					data: new FormData(document.getElementById("ocs")),
					processData: false,
					contentType: false,
					cache: false,
					type: "post",
					url: `${host_url}api/approveByClient/${idEdit}`,
					success: () => {
						swal({
							title: "Exito!",
							icon: "success",
							text: "Se ha guardado el archivo con éxito. ",
							button: "OK",
						}).then(() => {
							$("#input_oc").css("display","none");
							$("#oc").val('');
							$("#modalApproveOT").modal("hide");
							get_orders();
						});
					},
					error: (result) => {
						swal({
							title: "Error",
							icon: "error",
							text:  result.responseJSON.msg,
						})
					},
				});
			}else{
				swal({
					title: "Error",
					icon: "error",
					text:  "Ningun archivo Seleccionado",
				});
			}
		} else {
            swal.close();
        }
	});
}

/*Función para cerrar y limpiar el modal utilizado para crear y editar cliente*/
closeModalApprove = (data) =>{
	idEdit = '';
	$("#oc").val('');
    $('#modalApproveOT').modal('hide');
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

$("#table_orders").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btnApprove") {
		approve(data);
	}
});

$("#btnSave").on("click", saveFile);







    

