$(() => {
	get_Info_orders();
});

const tabla = $("#table-orders").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "id" },
		{ data: "date_admission" },
		{ data: "component" },
		{ data: "type_service" },
		{ data: "state" },
	],
});


let process = [];
let ready_retirement;
let finished;
let down;

get_Info_orders= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/counterOrdersByClient`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            data = xhr.response;
			
			if(data.evaluation.length > 0){
				process = process.concat(data.evaluation);
			}

			if(data.e_quotation.length > 0){
				process = process.concat(data.e_quotation);
			}

			if(data.e_aprobation.length > 0){
				process = process.concat(data.e_aprobation);
			}

			if(data.reparation.length > 0){
				process = process.concat(data.reparation);
			}
			console.log(process);

            ready_retirement = data.ready_retirement;
			finished = data.finished;
            down = data.down;

			$(".num").counterUp({delay:10, time:1000});



            $("#process").html(process.length);
            $("#ready_retirement").html(ready_retirement.length);
            $("#finished").html(finished.length);
			$("#down").html(down.length);

			$('.counter').counterUp({
				delay: 5,
				time: 500
			 });

		} else {
			swal({
				title: "Error",
				icon: "error",
				text: "Error al cargar los datos.",
			});
		}
	});
	xhr.send();
};

loadDataModal = (title, data) => {
	$("#titlemodal").html(title);
	tabla.clear();
	tabla.rows.add(data);
	tabla.draw();
};


$("#btnProcess").on("click", () => {
	loadDataModal("Órdenes en proceso", process);
	$("#modal").modal("show");
});

$("#btnRetirement").on("click", () => {
	loadDataModal("Órdenes listas para retiro", ready_retirement);
	$("#modal").modal("show");
});

$("#btnFinished").on("click", () => {
	loadDataModal("Órdenes terminadas", finished);
	$("#modal").modal("show");
});

$("#btnDown").on("click", () => {
	loadDataModal("Órdenes dadas de baja", down);
	$("#modal").modal("show");
});



$("#table-orders").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "btn_admin") {
		let ot = data.id;
		let url = 'stagesOrder'+'?ot='+ot;
		window.location.assign(host_url+url);
	}
});
