$(() => {

    getFields();
	getClientModal();

	let id = localStorage.getItem('enterprise_id');
	if(id)
	{
		getAllOrder();
		let name = localStorage.getItem('nameClient');
		getOrdersClientStorage(id, name);
	}else{
		getAllOrder();
	}

	for(let i=0; i<6; i++){
		let filter = localStorage.getItem('input_search_'+i);
		if(filter){
			$('#input_search_'+i).val(filter);
		}
	}

});


$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

let list_search = false; // se activa busqueda por lista 
let enterprises = []; /*Variable que almacenara las empresas*/
let clients = [];

/*Funcion para recuperar las ordenes de trabajo*/
getClientModal = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFieldsOrder`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
				data = xhr.response[1];
				
				  
				   $('#table-list thead tr').clone(search).appendTo( '#table-list thead' );
					   $('#table-list thead tr:eq(1) th').each( function (i) {
						   var title = $(this).text(); //es el nombre de la columna
						   $(this).html( '<input type="text" size ="10"style="border-radius: .1rem; border: 1px solid #d1d3e2; "/>' );
					
						   $( 'input', this ).on( 'keyup change', function () {
							   if (tabla2.column(i).search() !== this.value ) {
								   tabla2
									   .column(i)
									   .search( this.value , true, false, true )
									   .draw();
							   }
						   } );
					   } );
		   
					   
					   datatable_client(data);
				  
		}
	});
	xhr.send();
};

getFields = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getFieldsOrder`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
           
            if(enterprises.length == 0){
				clients = xhr.response[1];
				let enterpriseSearch = [];
                xhr.response[1].map((u) => {
                    enterprises.push(u.name);
                    enterpriseSearch.push(u.name);
                });
				fuzzyAutocomplete($("#enterprise"),enterpriseSearch );
            }

		} else {
			console.log("error no se pudo cargar los clientes");
		}
	});
	xhr.send();
};






getOrder=(id)=>{

     console.log(id);
	let data = { id_enterprise : id }
	$.ajax({
        type: "POST",
        url: host_url + "api/ordersEnterprise",
        data: {data},
        dataType: "json",
        success: (result) => {
            
               let orders = result.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			});

			datatable(orders);
           
		}
		});

		
}

let id_list = 0;
let search = true ;
let nameClient ="";

getOrdersClient=()=>{
	tabla.clear();
	tabla.draw();
	
    let data = {};
	let enterprise;
	let enterprise_id;
	
	if(list_search){

		data = { id_enterprise : id_list }
		$('#client_name').val(nameClient);
		localStorage.setItem('enterprise_id', id_list);
		localStorage.setItem('nameClient', nameClient);
	}else{

	enterprise = $('#enterprise').val();
	clients.forEach(function(item) {
		if(enterprise == item.name){
			nameClient =item.name;
			enterprise_id= item.id;
		}
	});

	$('#client_name').val(nameClient);
		data = { id_enterprise : enterprise_id  }
		localStorage.setItem('enterprise_id', enterprise_id);
		localStorage.setItem('nameClient', nameClient);
	}
	


    $.ajax({
        type: "POST",
        url: host_url + "api/ordersEnterprise",
        data: {data},
        dataType: "json",
        success: (result) => {
               
            let data = result.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			});
			datatable(data);
        },
        error: ()=>{
			getOrderFail();
        }
        })
};

getOrdersClientStorage = (id, name) =>{
	$('#client_name').val(name);
	data = { id_enterprise : id }
	
	$.ajax({
        type: "POST",
        url: host_url + "api/ordersEnterprise",
        data: {data},
        dataType: "json",
        success: (result) => {
               
            let data = result.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			});
			datatable(data);
        },
        error: ()=>{
			getOrderFail();
        }
        })
}

getOrderFail=()=>{
	$('#client_name').val("Todas las órdenes");
	localStorage.removeItem('enterprise_id');
	localStorage.removeItem('nameClient');
	
	$.ajax({
        type: "GET",
        url: host_url + "api/orders_all",
        dataType: "json",
        success: (result) => {
               
            let data = result.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			})

			datatable(data);
		},
		error: ()=>{
            tabla.clear();
            tabla.draw();
        }

	});
}


getAllOrder=()=>{
	$('#client_name').val("Todas las órdenes");
	$.ajax({
        type: "GET",
        url: host_url + "api/orders_all",
		async:false,
        dataType: "json",
        success: (result) => {
               
            let data = result.map((u) => {
				if (u.approve_client == 1) {
					u.approve_client = "Aprobado";
				} else {
					u.approve_client = "Pendiente de aprobación";
				}
				return u;
			})
          
			
   if(search){
         search =false; 
	
		    $('#table-clients thead tr').clone(search).appendTo( '#table-clients thead' );
			$('#table-clients thead tr:eq(1) th').each( function (i) {
				var title = $(this).text(); //es el nombre de la columna

				$(this).html( '<div class="row"><div class="col-md-12 mb-3"><input style="width:100%" id="input_search_'+i+'" type="text" size ="10"/></div></div>' );
				
			

				
				
				$( 'input', this ).on( 'keyup change', function () {
					if (tabla.column(i).search() !== this.value ) {
						localStorage.setItem('input_search_'+i, this.value);
						tabla
							.column(i)
							.search( this.value , true, false, true )
							.draw();
					}
				} );
			} ); 

			datatable(data);
		
        }else{
			datatable(data);
			
        }  
		
        },
        error: ()=>{
            tabla.clear();
            tabla.draw();
        }
        })
   
};



datatable=(data)=>{
	
	tabla.clear();
	tabla.rows.add(data);	
	tabla.order( [ 1 , 'desc' ] ).draw();
}

$("#btn_list").on("click", ()=>{
	$("#clients").modal("show");
});


const tabla = $('#table-clients').DataTable( {
	stateSave: true,
	fixedHeader: true,
	orderCellsTop: false,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
		{ "width": "10%", "targets": 0 }, 
		{ "width": "10%", "targets": 1 }, 
		{ "width": "10%", "targets": 2 }, 
		{ "width": "10%", "targets": 3 }, 
		{ "width": "10%", "targets": 4 },
		{ "width": "10%", "targets": 5 }, 
		{ "width": "5%", "targets": 6 }, 
		{ "width": "15%", "targets": 7 }, 
		{ "width": "15%", "targets": 8 }, 
		{className: "text-center", "targets": [3]},
		{className: "text-center", "targets": [7,8,9]},
	], 
	columns: [
		{ data: "number_ot"},
		{ data: "date" },
		{ data: "component"},
		{ data: "description" },
		{ data: "service" },
		{ data: "state" },
		{ data: "approve_client" },
		{ defaultContent: "ap",
		"render": function (data, type, row){
		 if(row.approve_client == 'Pendiente de aprobación'){
			 return `<button type='button' name='btnAprove' class='btn btn-primary'>
			 Aprobar
			 <i class="fas fa-thumbs-up"></i>
			  </button>`
		 }else{
			 return `<button type='button' name='btnAprove' class='btn btn-warning'>
			 Aprobado
			 <i class="fas fa-user-check"></i>
			 </button>`
		 }
		}
	 },
	 { defaultContent: "ap",
	 "render": function (data, type, row){
	  if(row.correlative_oc){
		  return  `<button type='button' name='btn_show' class='btn btn-warning'>
						 Recibido
		  <i class="fas fa-search"></i>
	   </button>`
	  }else{
		return  `<button type='button' name='btn_show' class='btn btn-primary'>
		Subir
		<i class="fas fa-file-upload"></i>
		 </button>`
	  }
	 }
  },

  { defaultContent: "ap",
  "render": function (data, type, row){
  
	   return  `<button type='button' name='btn_details' class='btn btn-success'>
					 Ver
	   <i class="fas fa-search"></i>
	</button>`
   }
},
 
	
	],
});

$("#table-clients").on("click", "button", function () {
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
				approve_client(data.number_ot, data.approve_client,data.id_enterprise);
			} else {
				swal.close();
			}
		});
	}else if($(this)[0].name == "btn_show") { 

	   $("#id").val(data.number_ot);
	   $("#id_client").val(data.id_enterprise);
	   $("#modal_oc").modal('show');
	   verifyFile_OC();

	  
	}else if($(this)[0].name == "btn_details"){
		let ot = data.number_ot;
		let url = 'stagesOrderSeller'+'?ot='+ot;
		window.location.assign(host_url+url);
	}
});


const tabla2= $('#table-list').DataTable( {
	
	aoColumnDefs: [
		{ 'bSortable': false, 'aTargets': [ 0,1,2]   }
	 ],
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		
		{ data: "rut" },
		{ data: "name"},
	

	 { defaultContent: "ap",
	 "render":()=>{ return  `<button type='button' name='select' class='btn btn-primary'>
						Consultar
		  <i class="fas fa-search"></i>
	   </button>`
	
	
	 }
  },
	
	],
});


$("#table-list").on("click", "button", function () {
	let data = tabla2.row($(this).parents("tr")).data();
	if ($(this)[0].name == "select") {
		list_search=true;
		id_list=data.id;
		nameClient=data.name;
		$('#enterprise').val("");
		$("#clients").modal("hide");
		getOrdersClient();
	}
});

datatable_client=(data)=>{
	tabla2.clear();
	tabla2.rows.add(data);	
	tabla2.draw();
}

$("#btn_orders").on('click',()=>{
	list_search =false
    getOrdersClient();

});



//ot.id number_ot, ot.date_admission date, ot.priority priority,
 //ot.description description, ot.type_service service, 
 //e.name enterprise, c.name component, s.name state, approve_client
 let users_notification=[];
 let id_user;
 get_user =()=> {
    $.ajax({
	
		type: "GET",
		url: host_url + "api/get_user_notifications",
		crossOrigin: false,
		async: false,
		dataType: "json",
		success: (result) => {
           
           users_notification = result.users;
		   id_user=result.user_id;
		  
		},
      
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});

}


approve_client = (id, state,id_enterprise) => {
	users_notification =[];
    get_user();
    let aux =users_notification.map(x => {
		let data ={};
		if(x.id_user != id_user) {
			data = {id:x.id_user ,show:0}
			return data;
		}else{
			data = {id:x.id_user ,show:1}
			return data;
		}
	});

	console.log(aux);
	
	let data = {
		approve: state == "Aprobado" ? 0 : 1,
		id: id,
		states : JSON.stringify(aux)
    };
	
	$.ajax({
		data: { data },
		type: "POST",
		url: host_url + "api/changeState",
		crossOrigin: false,
		async:false,
		dataType: "json",
		success: (result) => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: result.msg,
				button: "OK",
			}).then(() => {
				
				getOrder(id_enterprise);
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
	let id_enterprise = $("#id_client").val();
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

				getOrder(id_enterprise);
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
    let id_enterprise = $("#id_client").val();
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
			window.open(`${host_url}assets/upload/purshaseOrder/${$file}`);
		
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
	id_enterprise= $("#id_client").val();
    
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
					getOrder(id_enterprise);
					$("#modal_oc").modal('hide');
					
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









