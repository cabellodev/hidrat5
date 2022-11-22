$(() => {
    get_history_states();
});


/*Constante para rellenar las filas de la tabla: lista de ordenes de trabajo*/
const table_history_states = $('#table_history_states').DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
        { data: "state"},
        { data: "date" },
        { data: "user" },
	],
});

get_history_states = () =>{
	table_history_states.clear();
    let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getHistoryStatesByOrder/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			let data =xhr.response;
            table_history_states.clear();
			table_history_states.rows.add(data);	
			table_history_states.order( [ 1, 'desc' ] ).draw();
		}else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al obtener los estados asociados a la órden de trabajo",
			});
		}
	});
	xhr.send();
}