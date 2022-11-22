

editarImage = () => {
	event.preventDefault();
	let id = $("#id_e").val();//Image ID 
	let files = $("#file_e")[0].files;
	let data = {
		name: $("#name_e").val(),
		file: files.length,
	};
   


	Object.keys(data).map((d) => $(`.${d}`).hide());
	$.ajax({
		data: {
			data,
		},
		type: "POST",
		url: host_url + `api/editImage/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
			let id = result.id;
			uploadImage_e(id);
		},
		error: (result) => {
			
			$("#file_e").show();
			$("#file").show();
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.err ,
			})
		},
	});
};



uploadImage_e = (id) => {
    ot= $("#id").val();
   
	$.ajax({
		data: new FormData(document.getElementById("foto_e")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/upImage/${id}`,
		success: () => {
			swal({
				title: "Exito!",
				icon: "success",
				text: "Se ha guardado la imagen ",
				button: "OK",
			}).then(() => {
				$("#editImage").modal("hide");
				getImages();
				$(".custom-file-label").removeClass("selected").html("Chosee");
				$("#file_e").show();
		     	$("#file").show();
			
			});
		},
		error: () => {
			swal({
				title: "Error",
				icon: "error",
				text: "Ha ocurrido un error",
			});
		},
	});
};

$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });

$("#editButton").on('click', editarImage);