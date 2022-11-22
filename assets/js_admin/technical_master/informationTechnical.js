$(() => {
	hidePeriode();

});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	},
});
let periodo = 0;
$("#periodo").change(() => { 

	let valor = $("#periodo").val();
	console.log(valor);
	if(valor==1) { //anual
		periodo=1;
		showPeriode();
	}else if(valor==2){ // mensual 
		 periodo = 2;
		$("#frm_year").show(); $("#frm_month").hide();
	}else if(valor==""){
		hidePeriode();
	}
});

$("#typeTech").change(() => { 

	let valor = $("#typeTech").val();

	if(valor==1) { 
		getTechnical(); 
	}else if(valor==2){ 

		getAssistent();
	}else if(valor==""){
		$("#nameTech").empty();
	}
});

$("#nameTech").change('click', ()=>{

	
});


convertirMes = (valor )=>{ 

	let mes ="";
	let meses = [{ mes:'Enero'},{ mes:'Febrero'},{ mes:'Marzo'},{ mes:'Abril'}
	,{ mes:'Mayo'},{ mes:'Junio'},{ mes:'Julio'},{ mes:'Agosto'}
	,{ mes:'Septiembre'},{ mes:'Octubre'},{ mes:'Noviembre'},{ mes:'Diciembre'}];
  
	meses.forEach((item,index)=>{
		if(index == ((parseInt(valor)-1))){ mes = item.mes ;}
	});
  
	return mes;
  }


	
selectTechnical=()=>{
	data = { technical: $("#nameTech").val() };
	console.log(data);
	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/selectTech",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			technical = result[0][0].full_name;
			$("#g_technical").val(technical);
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
//details tecnical report(modal information)
details_ev=(ot_number)=>{
	data = { ot_number:ot_number};

	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/details_ev",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			console.log(result);
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
//details tecnical report(modal information)
details_tr=(ot_number)=>{
	data = { ot_number: ot_number};

	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/details_tr",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			
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

//details hidraulic_test(modal information)
details_ht=(ot_number)=>{
    data = { ot_number:ot_number};
	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/details_ht",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		       
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

//details reparation (modal information)
details_rep=(ot_number)=>{
    
	console.log(data);
	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/details_rep",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			technical = result[0][0].full_name;
			$("#g_technical").val(technical);
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


getTechnical = ()=> { 
	
	$("#nameTech").empty();
	$.ajax({
		type: "GET",
		url: host_url + "module_technical/info/technical/getTechnical",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			let data = result[0];
            data.forEach((i)=>{
				$(`#nameTech option[value='${i.id}']`).remove();
				 $("#nameTech").append('<option value="' + i.id + '">' + i.full_name + '</option>');
				
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

}

getAssistent=()=> { 
	$("#nameTech").empty();
	$.ajax({
		type: "GET",
		url: host_url + "module_technical/info/technical/getAssistent",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			let data = result[0];

			data.forEach((i)=>{
				$(`#nameTech option[value='${i.id}']`).remove();
				 $("#nameTech").append('<option value="' + i.id + '">' + i.full_name + '</option>');
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
}

let user=0;

getOrdersWorked=()=> {
	typeTech = $("#typeTech").val();
	user = $('#nameTech').val();
	if(periodo !=0 ){
		if(typeTech != ""){
			let data = {user: $("#nameTech").val()}
			let obj_periode ;
			if(periodo ==2 ){
				obj_periode = {year: $( '#year').val() }
			}else if (periodo ==1){
				obj_periode = {year: $( '#year').val() , month:$('#month').val() }
			}
			console.log(data);
			console.log(typeTech);
			if(typeTech=='1'){
				$("#div_tm").show();
				$("#div_at").hide();
				$.ajax({
					data:{data},
					type: "POST",
					url: host_url + "module_technical/info/technical/getOrdersWorked",
					crossOrigin: false,
					dataType: "json",
					success: (result) => {
					let orders =result[0];
					console.log(orders);

					if(periodo==1){
						
						selectTechnical();
						dataTableMonths(orders,obj_periode);
						close_modal();
						$("#general_info").show();

					}else if (periodo==2){
						
						selectTechnical();
						dataTableYears(orders,obj_periode);
						close_modal();
						$("#general_info").show();
					}else{
						selectTechnical();
						dataTableAll(orders);
						close_modal();
						$("#general_info").show();
					}
					substacks_list = [];
					
					},
					error: (result) => {
						swal({
							title: "Error",
							icon: "error",
							text: result.responseJSON.msg,
						});
					},
				});
			}else if(typeTech=='2'){
				getTechnicalWorked(periodo, user, obj_periode);
			}
		}else{
			swal({
				title: "Error",
				icon: "error",
				text: "Ingrese el tipo de técnico a consultar.",
			});
			
		}

	}else{
		swal({
			title: "Error",
			icon: "error",
			text: "Ingrese un período a consultar.",
		});

	} 
}


dataTableAll=(orders)=>{

	
	let aux_orders = [];
	orders.forEach((item)=>{
        /*ot.id ot_number , r.check_adm check_admin_r ,r.check_technical check_technical_r , ev.details details_ev, ht.details details_ht, tr.details details_tr, 
                   tr.user_assignment technical_tr,ev.user_assignment technical_ev,ht.user_assignment technical_ht,r.user_assignment technical_r
         */
		$("#g_year").val('General');
		$("#g_month").val('General');
		let ot_number= item.ot_number;
		let validation_ev =false;
		let validation_tr =false;
		let validation_ht=false;
		let validation_r=false;
		let ev = JSON.parse(item.details_ev);
		let tr = JSON.parse(item.details_tr);
		let ht = JSON.parse(item.details_ht);

		
		if(ev){if(item.technical_ev==user){ if(ev.approve_technical=="true"){validation_ev=true; }}} //fecha.getFullYear (año ) y (fecha.getMonth+1) (mes)
		if(tr){if(item.technical_tr==user){ if(tr.check_technical=="true"){validation_tr=true;}}}
		if(ht){if(item.technical_ht==user){if(ht.approve_technical=="true"){validation_ht=true;}}}
	    if(item.check_technical_r == 1){ if(item.technical_r = user){validation_r=true}}	
	

		// validation
		if(validation_ev ==false && validation_tr ==false && validation_ht==false && validation_r ==false){

			console.log(item.ot_number);
		}else{
           
			data ={
				ot_number: ot_number,
				date_admission: item.date_admission,
				state: item.state_name,
				check_technical_ev: ev? ev.approve_technical:null,
				check_technical_tr: tr? tr.check_technical:null,
				check_technical_ht: ht? ht.approve_technical:null,
				check_technical_r: item.check_technical_r,
				user_ev: item.technical_ev?item.technical_ev:null,
				user_tr: item.technical_tr?item.technical_tr:null,
				user_ht: item.technical_ht?item.technical_ht:null,
				user_r:  item.technical_r?item.technical_r:null,
				validation_ev:validation_ev,
				validation_tr:validation_tr,
				validation_ht:validation_ht,
				validation_r:validation_r,
			}

			aux_orders.push(data);
		}
	});

	tabla.clear();
	tabla.rows.add(aux_orders);	
	tabla.draw();

}

dataTableYears=(orders,obj_periode)=>{

	let aux_orders = [];
	orders.forEach((item)=>{
        /*ot.id ot_number , r.check_adm check_admin_r ,r.check_technical check_technical_r , ev.details details_ev, ht.details details_ht, tr.details details_tr, 
                   tr.user_assignment technical_tr,ev.user_assignment technical_ev,ht.user_assignment technical_ht,r.user_assignment technical_r
         */
		 $("#g_year").val(obj_periode.year);
		 $("#g_month").val('General');
		
		let year = obj_periode.year;
		let validation_ev =false;
		let validation_tr =false;
		let validation_ht=false;
		let validation_r=false;

		let ev = JSON.parse(item.details_ev);
		let tr = JSON.parse(item.details_tr);
		let ht = JSON.parse(item.details_ht);

		
		if(ev){  date = new Date (ev.date_evaluation);if(item.technical_ev==user){ if(ev.approve_technical=="true"){  if(date.getFullYear(ev.date_evaluation)==year) {validation_ev=true;} }}} //fecha.getFullYear (año ) 
		if(tr){  date = new Date (tr.date_technical_report);if(item.technical_tr==user){ if(tr.check_technical=="true"){    if(date.getFullYear(tr.date_technical_report)==year) {validation_tr=true;} }}}
		if(ht){  date = new Date (ht.date_ht);if(item.technical_ht==user){if(ht.approve_technical=="true"){   if(date.getFullYear(ht.date_ht)==year) {validation_ht=true;} }}}
	    if(item.check_technical_r == 1){date= new Date(item.date_reparation); if(item.technical_r = user){if(date.getFullYear(item.date_reparation)==year ){validation_r=true}}}	
	

		// validation
		if(validation_ev ==false && validation_tr ==false && validation_ht==false && validation_r ==false){

			console.log(item.ot_number);
		}else{
			
			data ={
				ot_number: item.ot_number,
				date_admission: item.date_admission,
				state: item.state_name,
				check_technical_ev: ev? ev.approve_technical:null,
				check_technical_tr: tr? tr.check_technical:null,
				check_technical_ht: ht? ht.approve_technical:null,
				check_technical_r: item.check_technical_r,
				user_ev: item.technical_ev?item.technical_ev:null,
				user_tr: item.technical_tr?item.technical_tr:null,
				user_ht: item.technical_ht?item.technical_ht:null,
				user_r:  item.technical_r?item.technical_r:null,
				validation_ev: validation_ev,
				validation_tr: validation_tr,
				validation_ht: validation_ht,
				validation_r: validation_r,
			}

			aux_orders.push(data);
		}
	});
    console.log(aux_orders);
	tabla.clear();
	tabla.rows.add(aux_orders);	
	tabla.draw();

}

dataTableMonths=(orders,obj_periode)=>{
	
	let aux_orders = [];
	orders.forEach((item)=>{
        /*ot.id ot_number , r.check_adm check_admin_r ,r.check_technical check_technical_r , ev.details details_ev, ht.details details_ht, tr.details details_tr, 
                   tr.user_assignment technical_tr,ev.user_assignment technical_ev,ht.user_assignment technical_ht,r.user_assignment technical_r
         */
	    $("#g_year").val(obj_periode.year);
		$("#g_month").val(convertirMes(obj_periode.month));
		
		let ot_number= item.ot_number;
		let year = obj_periode.year;
		let month = obj_periode.month;
		console.log(obj_periode);
		let validation_ev =false;
		let validation_tr =false;
		let validation_ht=false;
		let validation_r=false;
		let ev = JSON.parse(item.details_ev);
		let tr = JSON.parse(item.details_tr);
		let ht = JSON.parse(item.details_ht);
        
		
		
		if(ev){  date = new Date (ev.date_evaluation);if(item.technical_ev==user){ if(ev.approve_technical=="true"){  if(date.getFullYear(ev.date_evaluation)==year && (date.getMonth(ev.date_evaluation)+1)==month) {validation_ev=true;} }}} //fecha.getFullYear (año ) 
		if(tr){  date = new Date (tr.date_technical_report);if(item.technical_tr==user){ if(tr.check_technical=="true"){ if(date.getFullYear(tr.date_technical_report)==year && (date.getMonth(tr.date_technical_report)+1)==month) {validation_tr=true;} }}}
		if(ht){  date = new Date (ht.date_ht);if(item.technical_ht==user){if(ht.approve_technical=="true"){   if(date.getFullYear(ht.date_ht)== year && (date.getMonth(ht.date_ht)+1)==month) {validation_ht=true;} }}}
	    if(item.check_technical_r == 1){date= new Date(item.date_reparation); if(item.technical_r = user){if(date.getFullYear(item.date_reparation)==year && (date.getMonth(item.date_reparation)+1)==month ){validation_r=true}}}		
	     

		// validation
		if(validation_ev ==false && validation_tr ==false && validation_ht==false && validation_r ==false){
            
			console.log(item.ot_number);
		}else{
           
			data ={
				ot_number: ot_number,
				date_admission: item.date_admission,
				state: item.state_name,
				check_technical_ev: ev? ev.approve_technical:null,
				check_technical_tr: tr? tr.check_technical:null,
				check_technical_ht: ht? ht.approve_technical:null,
				check_technical_r: item.check_technical_r,
				user_ev: item.technical_ev?item.technical_ev:null,
				user_tr: item.technical_tr?item.technical_tr:null,
				user_ht: item.technical_ht?item.technical_ht:null,
				user_r:  item.technical_r?item.technical_r:null,
				validation_ev: validation_ev,
				validation_tr: validation_tr,
				validation_ht: validation_ht,
				validation_r: validation_r,
			
			}
			aux_orders.push(data);
		}
	});

	tabla.clear();
	tabla.rows.add(aux_orders);	
	tabla.draw();

}


const tabla = $("#table-orders-worked").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
		{className: "text-center", "targets": [1]},
        {className: "text-center", "targets": [2]},
		{className: "text-center", "targets": [3]},
		{className: "text-center", "targets": [4]},
		{className: "text-center", "targets": [5]},
		{className: "text-center", "targets": [6]}
    ],
	columns: [
		{ data: "ot_number" },
		{ data: "date_admission" },
		{ data: "state" },
		{ "render": function(data,type,row){
			if(row.validation_ev){
              if(row.user_ev){
				console.log("entre a user");
              if(row.user_ev==user){
                if (row.check_technical_ev){
                     if(row.check_technical_ev =="true"){
						 
						return `<button type='button' name='details_ev' class='btn btn-success'>
						<i class="fas fa-check-circle"></i>
						</button>`
					 }else{
						return `<button type='button' name='not_details' class='btn btn-danger'>
						<i class="fas fa-minus-circle"></i>
						</button>`
					 }

				}else{
					return `<button type='button' name='not_details' class='btn btn-danger'>
					<i class="fas fa-minus-circle"></i>
				            </button>`
				}
			
			  }else{
				return `<button type='button' name='not_details' class='btn btn-danger'>
				<i class="fas fa-minus-circle"></i>
				</button>`
			  }// if compare users
			}else{
				return `<button type='button' name='not_details' class='btn btn-danger'>
				<i class="fas fa-minus-circle"></i>
				</button>`
			}
		}else{
			return `<button type='button' name='not_details' class='btn btn-danger'>
				<i class="fas fa-minus-circle"></i>
				</button>`
		}      
	     }},
		 
		 { "render": function(data,type,row){
			if(row.validation_tr){
            if(row.user_tr){
			if(parseInt(row.user_tr)==user){
			  if (row.check_technical_tr){
				   if(row.check_technical_tr =="true"){
					  return `<button type='button' name='details_tr' class='btn btn-success'>
					  <i class="fas fa-check-circle"></i>
					  </button>`
				   }else{
					  return `<button type='button' name='not_details' class='btn btn-danger'>
					  <i class="fas fa-minus-circle"></i>
					  </button>`
				   }

			  }else{
				  return `<button type='button' name='not_details' class='btn btn-danger'>
				          <i class="fas fa-minus-circle"></i>
						  </button>`
			  }
		  
			}else{
			  return `<button type='button' name='not_details' class='btn btn-danger'>
			  <i class="fas fa-minus-circle"></i>
			  </button>`
			}// if compare users
		}else{
			return `<button type='button' name='not_details' class='btn btn-danger'>
			<i class="fas fa-minus-circle"></i>
			</button>`
		}	
	}else{
		return `<button type='button' name='not_details' class='btn btn-danger'>
		<i class="fas fa-minus-circle"></i>
		</button>`

	} 
	   }}
	   ,
	   { "render": function(data,type,row){
         if(row.validation_ht){
         if(row.user_ht){
		   if(parseInt(row.user_ht)==user){
		      if (row.check_technical_ht){
			   if(row.check_technical_ht ==="true"){
				  return `<button type='button' name='details_ht' class='btn btn-success'>
				  <i class="fas fa-check-circle"></i>
				  </button>`
			   }else{
				  return `<button type='button' name='not_details' class='btn btn-danger'>
				  <i class="fas fa-minus-circle"></i>
				  </button>`
			   }

		  }else{
			  return `<button type='button' name='not_details' class='btn btn-danger'>
			          <i class="fas fa-minus-circle"></i>
					  </button>`
		  }
	  
		}else{
		  return `<button type='button' name='not_details' class='btn btn-danger'>
		  <i class="fas fa-minus-circle"></i>
		  </button>`
		}// if compare users
	}else{
		return `<button type='button' name='not_details' class='btn btn-danger'>
		<i class="fas fa-minus-circle"></i>
		  </button>`
	}
}else{
	return `<button type='button' name='not_details' class='btn btn-danger'>
			<i class="fas fa-minus-circle"></i>
			</button>`
}
   }},
    { "render": function(data,type,row){
        if(row.validation_r){
	     if(row.user_r==user){
	        if (row.check_technical_r=="1"){
		      
			        return `<button type='button' name='details_r' class='btn btn-success'>
					<i class="fas fa-check-circle"></i>
			       </button>`
		       }else{
			        return `<button type='button' name='not_details' class='btn btn-danger'>
			        <i class="fas fa-minus-circle"></i>
			       </button>`
		   }

		}else{
			return `<button type='button' name='not_details' class='btn btn-danger'>
			<i class="fas fa-minus-circle"></i>
		  </button>`
		}
	}else{
		return `<button type='button' name='not_details' class='btn btn-danger'>
			<i class="fas fa-minus-circle"></i>
			</button>`
	}
         }
		}
	],
});

$("#table-orders-worked").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "not_details") {
		swal({
			title: "",
			icon: "warning",
			text: `Este proceso es responsabilidad de otro técnico o bien no ha sido asignado aún.`,
		
		}).then(()=>{
			swal.close();
		})
		}else if ($(this)[0].name == "details_ev"){
			$("#titulo_modal_report").text("Detalles de evaluación");
			infoEv(data.ot_number,1);
			$("#details_process").modal('show');

		}else if($(this)[0].name == "details_tr"){
			$("#titulo_modal_report").text("Detalles de informe técnico");
			infoTr(data.ot_number,2);
			$("#details_process").modal('show');
		}else if($(this)[0].name == "details_ht"){
			$("#titulo_modal_report").text("Detalles de prueba hidráulica");
			infoHt(data.ot_number,3);
			$("#details_process").modal('show');
		}else if($(this)[0].name == "details_r"){
			
			$("#titulo_modal_report").text("Detalles de reparación");
			infoRep(data.ot_number,4);
			$("#details_process").modal('show');
		}
	
	});



   fill_info=(data,type_info)=>{
	let details; 
	if(type_info != 4){
		details = JSON.parse(data.details);
		console.log(details);
	}
	
	$("#technical_master").val(data.full_name);
	if(type_info == 1){
	$("#date_begin").val(details.date_evaluation);
    }else if(type_info == 2){
		$("#date_begin").val(details.date_technical_report);
	}else if (type_info == 3){
		$("#date_begin").val(details.date_ht);
	}else { 
		$("#date_begin").val(data.date_reparation);
	}
	
	$("#date_end").val(data.time_end);

	if(data.hours){
		$("#time_used").val(calculate_time_dataTable(parseFloat(data.hours*3600)));
	} else{ $("#time_used").val('Aun no calculada');}
	
	$("#report").val('archivo');
   }

   infoEv =(id,type)=>{ // evaluation information 
	   data={ot_number:id};
	$.ajax({

		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/getInfoEvaluation",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		 fill_info(result[0],type);
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
   
   infoRep =(id,type)=>{ // evaluation information 
	 data={ot_number:id};
     $.ajax({

	 data:{data},
	 type: "POST",
	 url: host_url + "module_technical/info/technical/getInfoRep",
	 crossOrigin: false,
	 dataType: "json",
	 success: (result) => {
	  fill_info(result[0],type);
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

   infoTr =(id,type)=>{ // technical report  information 
	data={ot_number:id};
    $.ajax({

	 data:{data},
	 type: "POST",
	 url: host_url + "module_technical/info/technical/getInfoTr",
	 crossOrigin: false,
	 dataType: "json",
	 success: (result) => {
		fill_info(result[0],type);
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


  infoHt =(id,type)=>{ // hidraulic_test information 
	data={ot_number:id};
    $.ajax({

	 data:{data},
	 type: "POST",
	 url: host_url + "module_technical/info/technical/getInfoHt",
	 crossOrigin: false,
	 dataType: "json",
	 success: (result) => {
		fill_info(result[0],type);
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
	 

 showPeriode=()=>{ $("#frm_year").show(); $("#frm_month").show();}
 hidePeriode =()=>{ $("#frm_year").hide(); $("#frm_month").hide(); $("#general_info").hide();}

$("#btn_search").on('click', () =>{$("#search_technical").modal('show');})
$("#btn_ok").on('click',getOrdersWorked)

close_modal = () =>{
	
    $("#periodo").val("");
    $("#typeTech").val("");
    $("#nameTech").val("");
    $("#search_technical").modal("hide");
	hidePeriode ();
}
close_modal_details = () =>{
   
	$("#titulo_modal_report").text("");
    $("#details_process").modal("hide");

}

calculate_time_dataTable = (seconds) =>{
	console.log(seconds);
	var days = Math.floor(seconds / (3600*24));
	
	seconds  -= days*3600*24;
	var hrs   = Math.floor(seconds / 3600);
	seconds  -= hrs*3600;
	var mnts = Math.floor(seconds / 60);
	console.log(seconds);
	seconds  -= mnts*60;
	console.log(seconds);
	return(days+" Dias, "+hrs+" Horas, "+mnts+" Minutos, "+seconds+" Segundos");
}























































































































































let substacks_list = [];
getTechnicalWorked = (periodo, user, obj_periode)=>{
	tabla.clear();
	substacks_list = [];
	$("#div_tm").hide();
	$("#div_at").show();
	selectTechnical();
	per = '';
	data = {};

	if(obj_periode['year'] && obj_periode['month']){
		data = {
			user: user, 
			periodo : 1,
			month: obj_periode['month'],
			year: obj_periode['year'],
		};
	}else if(obj_periode['year']){
		data = {
			user: user, 
			periodo : 2,
			month: '2',
			year: obj_periode['year'],
		};		
	};
	console.log(data);

	$.ajax({
		data:{data},
		type: "POST",
		url: host_url + "module_technical/info/technical/getOrdersWorkedAT",
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
		let subs_ev =result[0]['subs_ev'];
		let subs_sr =result[0]['subs_sr'];
		console.log(subs_ev);
		console.log(subs_sr);



		if(subs_ev){  
			subs_ev.forEach((item)=>{	
			
			/*Revisar si la lista esta vacia*/
				console.log(item);
				if(substacks_list.length == 0){ 
					
					let sub = {
						name : item.sub_ev,
						date_assignment : item.date_assigment,
						date_end : item.date_end,
						hours : item.hours,
					}
					console.log(sub);

					let obj = {
						ot_number : item.ot_number,
						date_admission : item.date_admission,
						state_name : item.state_name,
						subs_ev : [sub],
						subs_sr : []
					};
					substacks_list.push(obj);
				}else{
					/* Si no esta vacia revisar si la ot ya esta ingresada */
					let op = 0;
					substacks_list.forEach((item_list)=>{
						if(item_list.ot_number == item.ot_number){
							op = 1;
							let sub = {
								name : item.sub_ev,
								date_assignment : item.date_assigment,
								date_end : item.date_end,
								hours : item.hours,
							}
							item_list.subs_ev.push(sub);
						};
					});

					/* En caso que se mantenga 0 mi subtarea es para otra ot */
					if(op == 0){
						let sub = {
							name : item.sub_ev,
							date_assignment : item.date_assigment,
							date_end : item.date_end,
							hours : item.hours,
						}
	
						let obj = {
							ot_number : item.ot_number,
							date_admission : item.date_admission,
							state_name : item.state_name,
							subs_ev : [sub],
							subs_sr : []
						};
						substacks_list.push(obj);
					}


				}
				console.log(substacks_list);
			});
		}

		if(subs_sr){  
			subs_sr.forEach((item)=>{	
			
			/*Revisar si la lista esta vacia*/
				console.log(item);
				if(substacks_list.length == 0){ 
					
					let sub = {
						name : item.sub_sr,
						date_assignment : item.date_assignment,
						date_end : item.date_end,
						hours : item.hours,
					}

					let obj = {
						ot_number : item.ot_number,
						date_admission : item.date_admission,
						state_name : item.state_name,
						subs_ev : [],
						subs_sr : [sub]
					};
					substacks_list.push(obj);
				}else{
					/* Si no esta vacia revisar si la ot ya esta ingresada */
					let op = 0;
					substacks_list.forEach((item_list)=>{
						if(item_list.ot_number == item.ot_number){
							op = 1;
							let sub = {
								name : item.sub_sr,
								date_assignment : item.date_assigment,
								date_end : item.date_end,
								hours : item.hours,
							}
							item_list.subs_sr.push(sub);
						};
					});

					/* En caso que se mantenga 0 mi subtarea es para otra ot */
					if(op == 0){
						let sub = {
							name : item.sub_sr,
							date_assignment : item.date_assigment,
							date_end : item.date_end,
							hours : item.hours,
						}
	
						let obj = {
							ot_number : item.ot_number,
							date_admission : item.date_admission,
							state_name : item.state_name,
							subs_ev : [],
							subs_sr : [sub]
						};
						substacks_list.push(obj);
					}
				}
				console.log(substacks_list);
			});
		}

		tabla_sub.clear();
		tabla_sub.rows.add(substacks_list);	
		tabla_sub.draw();

		if(periodo==1){
			$("#g_year").val(obj_periode['year']);
			$("#g_month").val(obj_periode['month']);
		}else if (periodo==2){
			$("#g_year").val(obj_periode['year']);
			$("#g_month").val('General');
		}
		
		},
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});

	close_modal();
	$("#general_info").show();
};

const tabla_sub = $("#table-orders-worked_substacks").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
		{className: "text-center", "targets": [1]},
        {className: "text-center", "targets": [2]},
		{className: "text-center", "targets": [3]},
		{className: "text-center", "targets": [4]},
    ],
	columns: [
		{ data: "ot_number" },
		{ data: "date_admission" },
		{ data: "state_name" },
		{ "render": function(data,type,row){
			if(row.subs_ev.length > 0){		
				return `<button type='button' name='details_se' class='btn btn-success'>
				<i class="fas fa-check-circle"></i>
				</button>`
			}else if(row.subs_ev.length == 0){
				return `<button type='button' name='not_details' class='btn btn-danger'>
				<i class="fas fa-minus-circle"></i>
				</button>`
			}
			}
		},
		{ "render": function(data,type,row){
			if(row.subs_sr.length > 0){		
				return `<button type='button' name='details_sr' class='btn btn-success'>
				<i class="fas fa-check-circle"></i>
				</button>`
			}else if(row.subs_sr.length == 0){
				return `<button type='button' name='not_details' class='btn btn-danger'>
				<i class="fas fa-minus-circle"></i>
				</button>`
			}
			}
		}
	],
});

const tabla_sub_details = $("#table-details-sub").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
	/* 	{className: "text-center", "targets": [1]},
        {className: "text-center", "targets": [2]},
		{className: "text-center", "targets": [3]}, */

    ],
	columns: [
		{ data: "name" },
		{ data: "date_assignment" },
		{ data: "date_end" },
		{ data: "hours" },
	],
});


$("#table-orders-worked_substacks").on("click", "button", function () {
	let data = tabla_sub.row($(this).parents("tr")).data();
	let id_ot = data.ot_number;
	if ($(this)[0].name == "not_details") {
		swal({
			title: "",
			icon: "warning",
			text: `Este proceso es responsabilidad de otro técnico o bien no ha sido asignado aún.`,
		
		}).then(()=>{
			swal.close();
		})
	}else if ($(this)[0].name == "details_se"){

		substacks_list.forEach((item)=>{
			if(item.ot_number == id_ot){
				tabla_sub_details.clear();
				tabla_sub_details.rows.add(item.subs_ev);	
				tabla_sub_details.draw();
			};
		});
		$("#titulo_modal_report_subs").text("Detalles de subtareas de evaluación");
		$("#details_process_subs").modal('show');

	}else if($(this)[0].name == "details_sr"){
		substacks_list.forEach((item)=>{
			if(item.ot_number == id_ot){
				tabla_sub_details.clear();
				tabla_sub_details.rows.add(item.subs_sr);	
				tabla_sub_details.draw();
			};
		});
		$("#titulo_modal_report_subs").text("Detalles de subtareas de reparación");
		$("#details_process_subs").modal('show');
	}
});



close_modal_details_sub = () =>{
	$("#titulo_modal_report").text("");
    $("#details_process_subs").modal("hide");
}
