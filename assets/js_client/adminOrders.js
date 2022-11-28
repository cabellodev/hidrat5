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

/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const tabla = $("#table_orders").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        {
            className: "text-center", "targets": [5,6],
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
			if(row.tr_details === 1){
				return `<button type='button' onclick="location.href= '${host_url}assets/upload/technicalReport/technical_report_${row.id}.pdf'" class='btn btn-primary'>
				<i class="fas fa-file-signature"></i>
				</button>`
			}else{
				return `<span> N/A </span>`
			}
			}
		 },
		{ defaultContent: "oc",
		   "render": function (data, type, row){
			if(row.ht_details === 1){
				return `<button type='button' onclick="location.href= '${host_url}assets/upload/hydraulicTest${row.id}.pdf'"  class='btn btn-primary'>
				<i class="far fa-file-alt"></i>
				</button>`
			}else{
				return `<span> N/A </span>`
			}
		   }
		},
	],
});


/*Funcion para recuperar las ordenes de trabajo*/
get_orders = () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOrdersByClient`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            let data =xhr.response;
			console.log(data);
            tabla.clear();
			tabla.rows.add(data);	
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