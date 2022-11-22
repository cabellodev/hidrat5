
$(() => {
	get_Info_orders();
});

const tabla = $("#table-orders").DataTable({
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columns: [
		{ data: "id" },
		{ data: "type_service" },
		{ data: "date_admission" },
		{ data: "description" },
		{ data: "name" },
		{  defaultContent: "No definido",
        "render": function (data, type, row){
                                if(row.date_limit){
                                 return row.date_limit;
								}
							}},
		{
			defaultContent: `<button type='button' name='btn_admin' class='btn btn-primary'>
                                  Administrar 
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
	],
});

let down;
let e_quotation;
let e_aprobation;
let finished;
let reparation;
let evaluation;
let retired;

get_Info_orders= () => {
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}api/counterOrders`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
            data = xhr.response;
            down = data.down;
			e_aprobation = data.e_aprobation;
			finished = data.finished;
			reparation = data.reparation;
			evaluation = data.evaluation;
            e_quotation= data.e_quotation;
			retired= data.retired;
			$("#down").html(down.length);
			$("#e_quotation").html(e_quotation.length);
			$("#finished").html(finished.length);
			$("#e_aprobation").html(e_aprobation.length);
			$("#reparation").html(reparation.length);
            $("#evaluation").html(evaluation.length);
		    $("#retired").html(retired.length);
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

$("#btnevaluation").on("click", () => {
	loadDataModal("Órdenes en evaluación", evaluation);
	$("#modal").modal("show");
});

$("#btnequotation").on("click", () => {
	loadDataModal("Órdenes en espera de cotización", e_quotation);
	$("#modal").modal("show");
});
$("#btneaprobation").on("click", () => {
	loadDataModal("Órdenes en espera de aprobación", e_aprobation);
	$("#modal").modal("show");
});

$("#btnreparation").on("click", () => {
	loadDataModal("Órdenes en reparación", reparation);
	$("#modal").modal("show");
});

$("#btnretired").on("click", () => {
	loadDataModal("Listo para retiro", retired);
	$("#modal").modal("show");
});

$("#btnfinished").on("click", () => {
	loadDataModal("Órdenes terminadas", finished);
	$("#modal").modal("show");
});

$("#btndown").on("click", () => {
	loadDataModal("Órdenes dados de baja", down);
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
