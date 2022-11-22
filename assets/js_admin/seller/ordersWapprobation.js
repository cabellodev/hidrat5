$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    get_orders_eaprobation();
    verifyFile_OC();
});


get_orders_eaprobation = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrdersQuotation`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			console.log(xhr.response);
            let data = xhr.response.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			});
            tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
			tabla.order( [ 1, 'desc' ] ).draw();
		} else {
			swal({
				title: "Mensaje",
				icon: "info",
				text: "Aun no hay registro de órdenes en ' Espera de aprobación'. ",
			});
		}
	});
	xhr.send();
};



const tabla = $('#table-order').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "number_ot"},
        { data: "date" },
        { data: "enterprise" },
        { data: "component" },
        { data: "state" },
        { data: "service" },
        { data: "approve_client" },
/* 		{
            defaultContent: `<button type='button' name='btnAprove' class='btn btn-primary'>
                                 Aprobar
								 <i class="fas fa-thumbs-up"></i>
                              </button>`,
		}, */
		{ defaultContent: "ap",
		   "render": function (data, type, row){
			if(row.approve_client == 'Pendiente de aprobación'){
				return `<button type='button' name='btnAprove' class='btn btn-primary'>
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
        {
            defaultContent: `<button type='button' name='btn_show' class='btn btn-primary'>
                            
								 <i class="fas fa-file-upload"></i>
                              </button>`,
		},
	
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/

$("#table-order").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "btnAprove") {
		swal({
			title: `Aprobación de cotización`,
			icon: "warning",
			text: `¿Está seguro/a de "aprobar o Dejar pendiente" la cotización: "${data.number_ot}"?`,
			buttons: {
				confirm: {
					text: "Aprobar/Dejar pendiente",
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
				approve_client(data.number_ot, data.approve_client);
			} else {
				swal.close();
			}
		});
	}else { 

	   $("#id").val(data.number_ot);
       $("#modal_oc").modal('show');
	   verifyFile_OC();

      
	} 
});


approve_client = (id, state) => {
	let data = {
		approve: state == "Aprobado" ? 0 : 1,
		id: id,
    };

    console.log(data);

	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + "api/changeState",
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
				get_orders_eaprobation();
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


editFileOC = () => {

	event.preventDefault();
    id = $("#id").val();
	let files = $("#oc")[0].files;//files.length

    if(files.length > 0) {

    $.ajax({
		data: new FormData(document.getElementById("ocs")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/OCseller/${id}`,
		success: () => {
			swal({
				title: "Exito!",
				icon: "success",
				text: "Se ha guardado el archivo con éxito. ",
				button: "OK",
			}).then(() => {
				$("#input_oc").css("display","none");
				$("#actions_oc").show();
				$("#modal_oc").modal('hide');
				
			   });
		},
				
		    error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text:  result.responseJSON.msg,
			});
		},
	});

}else{ 
    swal({
        title: "Error",
        icon: "error",
        text: "Cargue un archivo pdf por favor. ",
    });
}
};


verifyFile_OC = () =>{
	id= $("#id").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			file=xhr.response[0].correlative_oc;
			verify = Boolean(file);
          if(verify){  
				$("#input_oc").css("display","none");
				$("#actions_oc").show();
			    }else{ 
				$("#actions_oc").css("display","none"); 
				$("#input_oc").show();  
				}
		 }else{
			$("#input_oc").css("display","none");
			$("#actions_oc").css("display","none"); 
		 }
	});

	xhr.send();
}

showOC =()=>{ 

	id= $("#id").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			    
			$file=xhr.response[0].correlative_oc;
			window.open(`${host_url}assets/upload/${$file}`);
		
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

deleteOC =()=>{ 

	id= $("#id").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {

		    response =xhr.response[0].correlative_oc;
			aux = response.toString();
            let data = { pdf : aux }
			$.ajax({
				data: {
					data
				},
				type: "POST",
				url: host_url + `api/deleteOC/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: () => {
					swal({
						title: "Exito",
						icon: "success",
						text: "Se ha eliminado el archivo con éxito.",
					}).then(() => {
				    $("#actions_oc").css("display","none");
					$("#input_oc").show();
                    $("#oc").val("");
					 swal.close();
					});	 
				},
				error: () => {
					swal({
						title: "Denegado!",
						icon: "error",
						text: "No se ha podido eliminar el archivo. ",
					});
				},
			});  

        }else { 
			swal({
				title: "Error",
				icon: "error",
				text:  "Error al detectar el archivo. ",
			});
		}
	});
	xhr.send();
}





$("#upload_oc").on('click', editFileOC);
$("#show_oc").on("click", showOC);
$("#delete_oc").on("click", deleteOC);




