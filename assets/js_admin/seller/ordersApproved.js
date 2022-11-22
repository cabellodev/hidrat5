$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});




$(() => {
    get_orders_tr();

});


$("#show_tr").on('click', () => {
	
})
currentName="2428628432869191297121313173";
/*
get_orders_tr = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getApproveTechnicalReport`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            $global=[];
            data.forEach((item)=>{
             validation = item.details;
             aux = JSON.parse(validation);
             if(aux){
              if(aux.check_adm){
                     $global.push(item);
              }}
            });

            tabla.clear();
			tabla.rows.add($global);	
			tabla.order( [ 1, 'desc' ] ).draw();
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
*/

get_orders_tr = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getApproveTechnicalReport`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
            $global=[];
            data.forEach((item)=>{
             validation = JSON.parse(item.details);
             interaction = JSON.parse(item.user_interaction);
             if(validation){
              if(validation.check_adm=="true"){
                  report = 
                  {
                      number_ot : item.number_ot,
                      technical : interaction.user_create,
                      date : validation.date_technical_report,
                      enterprise : item.enterprise,
                      component : item.component,
                      state : item.state,
                      service : item.service,
                  }
                  $global.push(report);
              }}
            });
			console.log($global);

            tabla.clear();
			tabla.rows.add($global);	
			tabla.order( [ 1, 'desc' ] ).draw();
		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los reportes técnicos",
			});
		}
	});
	xhr.send();
};




/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $('#table_orders').DataTable({
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
		{
            defaultContent: `<button type='button' name='btn_show' class='btn btn-primary'>
                                 Ver informe
								 <i class="fas fa-search"></i>
                              </button>`,
		},
	
	],
});

/*Función para discriminar en mostrar la información para editar o des/hab un nuevo cliente*/
$("#table_orders").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_show") {
		file = 'assets/upload/technicalReport/technical_report_'+data.number_ot+'.pdf';
        url = host_url + file;
        window.open(url);
	}
});







    

