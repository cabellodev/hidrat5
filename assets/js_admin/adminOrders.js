$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});


$(() => {
    get_orders_test();
});



$("#newOrder").on('click', () => {
	/* $('#input_search_0').val('4'); */
	let a = $('#input_search_0').val();
  window.open(host_url+'newOrder', '_self'); 
})
currentName="2428628432869191297121313173";
/*Funcion para recuperar las ordenes de trabajo*/
get_orders = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrders`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
            tabla.clear();
			tabla.rows.add(data);	
			tabla.order( [ 1, 'desc' ] ).draw();
			$('#table_orders thead tr').clone(true).appendTo( '#table_orders thead' );

			$('#table_orders thead tr:eq(1) th').each( function (i) {
				var title = $(this).text(); //es el nombre de la columna
				$(this).html( '<input type="text" style="border-radius: .2rem; border: 1px solid #d1d3e2;"/>' );
		 
				$( 'input', this ).on( 'keyup change', function () {
					if (tabla.column(i).search() !== this.value ) {
						tabla
							.column(i)
							.search( this.value )
							.draw();
					}
				} );
			} );   

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

get_orders_test =  () => {

	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrdersTest`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data = xhr.response;
			console.log(data);
            $global=[];
			
            data.forEach((item)=>{
			$alert=[];
			evaluation = JSON.parse(item.evaluation);
			technical_report = JSON.parse(item.technical_report);
			hydraulic_test = JSON.parse(item.hydraulic_test);
			date_reparation = item.date_reparation;
			
			 alert_on =false;
			 
			 if(evaluation){ 
				 if(item.ev_state){ 
					 if(item.ev_state == 1){
                        if(evaluation.approve_admin ==="false" && evaluation.approve_technical==="true"){ alert_on =true; $alert.push('Aprobar evaluación'); } 
			 }}}

			  if(technical_report){ 
				if(item.tr_state){ 
					if(item.tr_state==1){
						if(technical_report.check_adm === "false" && technical_report.check_technical === "true"|| technical_report.check_adm ==="" && technical_report.check_technical==="true" ) { console.log("entre a report"); alert_on =true; $alert.push('Aprobar reporte técnico');
						  }
			  }}}
				
			 if(hydraulic_test){ 
				if(item.ht_state){ 
					if(item.ht_state==1){
				         if(hydraulic_test.approve_admin ==="false" && hydraulic_test.approve_technical==="true"){ alert_on =true; $alert.push('Aprobar prueba hidráulica');}
			 }}}
			 
			 if(item.check_adm == 0 && item.check_technical == 1 ){
				alert_on =true;
				$alert.push('Aprobar reparación');
			 }
             console.log(item.number_ot);
			 console.log(alert_on);
			 console.log($alert);
			 console.log(date_reparation);
			 
			 object = {
                number_ot: item.number_ot,
				date: item.date,
                enterprise:item.enterprise,
                component:item.component,
				description:item.description,
				location: item.location,
                state:item.state,
		        service: item.service,
				alert:alert_on,
				alert_info:$alert,
				date_limit: item.date_limit,
				id_state:item.id_state,

			 }
			
			 $global.push(object);
			
		
			});

            tabla.clear();
			tabla.rows.add($global);	
			tabla.order( [ 0, 'desc' ] ).draw();
			$('#table_orders thead tr').clone(true).appendTo( '#table_orders thead' );

			$('#table_orders thead tr:eq(1) th').each( function (i) {
				let a = localStorage.getItem('input_search_'+i);
				if(a == null){a=''}

				var title = $(this).text(); //es el nombre de la columna
				$(this).html( '<div class="row"><div class="col-md-12 mb-3"><input style="width:100%" value="'+a+'" id="input_search_'+i+'" type="text" size ="10"/></div></div>' );
		 
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


		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener las órdenes de trabajo",
			});
		}
	});
	xhr.send();
	console.log('a');
};

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#table_orders').DataTable({
	stateSave: true,
	fixedHeader: true,
	orderCellsTop: false,
	aoColumnDefs: [
        { 'bSortable': false, 'aTargets': [ ]   }
     ],
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        { "width": "10%", "targets": 0 }, /*Id */
        { "width": "15%", "targets": 1 }, /*Fecha Ingreso*/
        { "width": "20%", "targets": 2 }, /*Cliente */
        { "width": "15%", "targets": 3 }, /*Componente */
		{ "width": "15%", "targets": 4 }, /*Description */
        { "width": "10%", "targets": 5 }, /*Estado */
        { "width": "10%", "targets": 6 }, /*Tipo De Servicio */
		{ "width": "5%", "targets": 7 }, /*alertas */
        { "width": "5%", "targets": 8 },  /*Administrar */
        { "width": "5%", "targets": 9 },  /*Editar */
		{ "width": "5%", "targets": 10 },
		{className: "text-center", "targets": [7,8,9]},
    ],
	columns: [
        { data: "number_ot"},
        { data: "date" },
        { data: "enterprise" },
        { data: "component" },
		{ data: "description" },
		{ data: "location" },
        { data: "state" },
		{ data: "service" },
		{ "render": function(data,type,row){
                      if(row.date_limit){
						return row.date_limit;
						 /* if(row.id_state >=4 && row.id_state <= 6){
							return row.date_limit;
						  }else{
							return `<button type='button' name='not_date' class='btn btn-danger'>
							<i class="far fa-calendar-times"></i>
								 </button>`
						  }*/
					  }else{
						   return `<button type='button' name='not_date' class='btn btn-danger'>
						   <i class="far fa-calendar-times"></i>
								 </button>`
					  }
		}
	},
		{   defaultContent: "oc",
        "render": function (data, type, row){
                                if(row.alert == true){
                                     return `<button type='button' name='alert_info' class='btn btn-danger'>
									 <i class="fas fa-exclamation-circle"></i>
                                             </button>`
                                }else{
                                 return `<button type='button' name='alert_show' class='btn btn-success'>
								 <i class="fas fa-bell-slash"></i>
                                </button>`
                                }
                   }
     },// end defaultCon
		{
            defaultContent: `<button type='button' name='btn_adm' class='btn btn-primary'>
                                  Administrar
								  <i class="fas fa-shield-alt"></i>
                              </button>`,
		},
		
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/
$("#table_orders").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_adm") {
		$('#input_search_0').val('4');
		let ot = data.number_ot;
		let url = 'stagesOrder'+'?ot='+ot;
		window.location.assign(host_url+url);
	}else{
	     if($(this)[0].name == "btn_images"){
		    let ot = data.number_ot;
		    let url = 'adminImages'+'?ot='+ot;
		    window.location.assign(host_url+url);
         }else{
		      if($(this)[0].name == "alert_info"){
			     swal({
				  title: `Aprobaciones pendientes`,
				  icon: "warning",
				  text: addAlerts(data.alert_info),
				  buttons: {
					
					cancel: {
						text: "Aceptar",
						value: "cancelar",
						visible: true,
					   },
				     },
			      });
              }else{
			      if($(this)[0].name == "alert_show"){
				  console.log("alert");}
				  else{
                        if($(this)[0].name == "btn_update"){
		                   let ot = data.number_ot;
		                   let url = 'newUpdateOrder'+'?ot='+ot;
		                   window.location.assign(host_url+url);	
		                }else{
						    if($(this)[0].name == "not_date"){
								swal({
									title: `Plazo de reparación`,
									 icon: "warning",
									text: "Aún no hay fecha de termino definida para esta orden.",
									buttons: {
								  
									cancel: {
									  text: "Aceptar",
									  value: "cancelar",
									  visible: true,
									 },
									},
								   });
		                    }
						}
					}
	          }
	    }
	}

	
	
});

addAlerts = errores => {
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







    
