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
	columns: [
		{ data: "id" },
		{ data: "date" },
		{ data: "component" },
		{ data: "service" },
		{ data: "state" },
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