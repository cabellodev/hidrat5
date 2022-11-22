edit_evaluation = () => {

	event.preventDefault();
	let id = $("#id_ot").val();//Image ID 
	let data = {
        date_evaluation :$("#date_evaluation").val(),
        description: $("#description_ev").val(),
        notes: $("#notes").val(),
       
	};

	Object.keys(data).map((d) => $(`.${d}`).hide());
	$.ajax({
		data: {
			data,
		},
		type: "POST",
		url: host_url + `api/editEvaluation/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
            swal({
				title: "Exito",
				icon: "success",
				text: result.msg,
                button: "OK",
			});
		},
		error: () => {
            swal({
				title: "Error",
				icon: "error",
				text: "Complete los datos de la evaluación.",
               
			});
		     
		},
	});
};



$("#btn_edit").on("click", () => {
	edit_evaluation();
});
