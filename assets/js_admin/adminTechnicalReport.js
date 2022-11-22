$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
    },
});

$(() => {
    getTechnicalReports();
});


/*Funcion para recuperar las ordenes de trabajo*/
getTechnicalReports = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getTechnicalReportApprove`);
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
const tabla = $('#tableTechnicalReportApprove').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "columnDefs": [
        {
            className: "text-center", "targets": [7] ,
        },
    ],
	columns: [
        { data: "number_ot"}, 
        { data: "technical" }, 
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


$("#tableTechnicalReportApprove").on("click", "button", function () {
    let data = tabla.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn_show") {
        file = 'assets/upload/technicalReport/technical_report_'+data.number_ot+'.pdf';
        url = host_url + file;
        window.open(url);
	}
});







    

