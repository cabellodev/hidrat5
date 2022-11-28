$(() => {
    get_locations();
});

let state = $('#state').val();
let ubicaciones = [];

getOrders = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrders`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            tabla.clear();
			tabla.rows.add(data);
			tabla.draw();
            $("#search_ot").modal();
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

get_locations = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getLocations`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            ubicaciones = xhr.response;
            let locationSearch = [];
            ubicaciones.map((u) => {
                locationSearch.push(u.name);
            });
            console.log(ubicaciones);
            fuzzyAutocomplete($("#location"), locationSearch);
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las ubicaciones",
			});
		}
	});
	xhr.send();
};

changeState = () => {

    swal({
        title: `Cambio de estado`,
        icon: "warning",
        text: `Esta  segur@ de cambiar el estado de la OT:  ${$('#ot_number').val()}?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "change",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "change") {
            let state_change = $('#state').val();

            if(state == state_change){
                swal({
                    title: "Error",
                    icon: "error",
                    text: "La OT ya se encuentra en el estado seleccionado",
                })
            }else{
                data = {
                    ot_number: $('#ot_number').val(),
                    state: state_change,
                }
                $.ajax({
                    type: "POST",
                    url: host_url + 'api/changeStateOrder',
                    data: {data},
                    dataType: "json",
                    success: (result) => {
                     swal({
                         title: "Éxito!",
                         icon: "success",
                         text: result.msg,
                         button: "OK",
                     }).then(() => {
                        $("#state").val(state_change);
                        state = state_change;
                        get_history_states();
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
                })   
            }
        } else {
            swal.close();
        }
    }); 
}


changeLocation = () => {
    swal({
        title: `Cambio de ubicación`,
        icon: "warning",
        text: `Esta  segur@ de cambiar la ubicación de la OT:  ${$('#ot_number').val()}?`,
        buttons: {
            confirm: {
                text: `Confirmar`,
                value: "change",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "change") {
            let location_change = $('#location').val();
            let location;

            ubicaciones.forEach(function(item) {
                if(location_change == item.name){
                    location = item.id;
                }
            });
            console.log(location);

            if(location){
                data = {
                    ot_number: $('#ot_number').val(),
                    location:  location,
                }
                $.ajax({
                    type: "POST",
                    url: host_url + 'api/changeLocationOrder',
                    data: {data},
                    dataType: "json",
                    success: (result) => {
                        swal({
                            title: "Éxito!",
                            icon: "success",
                            text: result.msg,
                            button: "OK",
                        }).then(() => {
                            $("#location").val(location_change);
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
                })   
            }else{
                swal({
                    title: "Error",
                    icon: "error",
                    text: "Seleccione una ubicación valida",
                })
            }      
        } else {
            swal.close();
        }
    }); 
}

const tabla = $('#table_orders').DataTable({
    "columnDefs": [
        {
            "targets": [ 7 ],
            "visible": false,
            "searchable": false,
        },
        {
            "targets": [ 8 ],
            "visible": false,
            "searchable": false,
        },
        {
            className: "text-center", "targets": [6] ,
        },
        {
            "width": "10", "targets": [6] , 
        }
    ],

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
        {
            defaultContent: `<button type='button' name='btn_change' class='btn btn-primary'>
                                <i class="fas fa-hand-pointer"></i>
                              </button>`,
		},
        { data: "priority" },
        { data: "description" },
	],
});

$("#table_orders").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_change") {
		 $('#ot_number').val(data.number_ot);
         $('#id_ot').val(data.number_ot);
		 $('#date_admission').val(data.date);
         $('#enterprise').val(data.enterprise);
         $('#service').val(data.service);
         $('#problem').val(data.problem);
         $('#component').val(data.component);
         $(`option[name ="${data.state}"]`).attr("selected",true);
         $('#description').val(data.description); 
         $('#priority').val(data.priority);
         $("#search_ot").modal('hide');

         get_data_evaluation();//funciona
         get_data_ht();//funciona
         get_info_ht(); //??
         verifyFile();//funciona
         get_data_technical_report();
         get_data_ap();
         verifyFile_OC();
         get_data_reparation();
         get_history_states();
         get_notes_ot();
         get_images();
         getImages();
    } 
});

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

getImages = () => {
	id= $("#ot_number").val();
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getImagesByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data = xhr.response;
			tabla_images.clear();
			tabla_images.rows.add(data);
			tabla_images.draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las ubicaciones",
			});
		}
	});
	xhr.send();
};



const tabla_images = $('#table_images').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	/*columnDefs: [
		{ "width": "15%", "targets": [2,3]},
		{ "width": "30%", "targets": 1 },
		{ "width": "5%", "targets": 0 },
		{ className: "text-center", "targets": [1,2,3,4]} ,
	  ],*/
	columns: [
    
        { data: "files",
          render: function(data){
              binary = data;
              return '<img src="'+host_url+"assets/upload/"+binary+'" width="200" heigth="200"/>';
          } 
        },
		
		{
            defaultContent: `<button type='button' name='btn_look' class='btn btn-primary'>
                                 Ver 
								 <i class="fas fa-eye"></i>
                              </button>`,
		},
		
	],
});


$("#table_images").on("click", "button", function () {
    let data = tabla_images.row($(this).parents("tr")).data();
	
	if($(this)[0].name == "btn_look"){
	url = `${host_url}assets/upload/${data.files}`;
	$('.imagepreview').attr('src',url);
		$('#show_image').modal('show');   
		//showImage(url);
	} 
});


closeModalShow=() =>{
    $('#show_image').modal('hide');  
    $('#modal_images').modal('show');
}




$("#btn_change_state").on("click", changeState);

$("#images").on("click", ()=> { 

    getImages();
    $("#modal_images").modal('show');
  
});

$("#btn_change_location").on("click", changeLocation);

$("#btn_search").on("click", getOrders);

$("#btn_create").on('click', () => {
	window.open(host_url+'newOrder', '_self');
})