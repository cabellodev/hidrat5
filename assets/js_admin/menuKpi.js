$(() => {
	getData();
});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	},
});





getData = ()=> { 

    let data = [{ order: 1 , name: 'Cotización'},{ order: 2 , name: 'Producción'}];
    tabla.clear();
    tabla.rows.add(data);	
    tabla.draw();

}


const tabla = $("#table-menukpi").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "order" },
		{ data: "name" },
		{
			defaultContent: `<button type='button' name='search' class='btn btn-primary'>
                                  Consultar
                                  <i class="fas fa-search"></i>
                              </button>`,
		},
		
	],
});




$("#table-menukpi").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "search") {
       if(data.order == 1){
        window.open(host_url+'module_kpi/kpiQuotation', '_self');
       } else if(data.order==2){
        window.open(host_url+'module_kpi/kpiProduction', '_self');
       }
        
	} 
});
