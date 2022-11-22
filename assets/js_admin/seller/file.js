$(()=>{
	verifyFile();	
});


verifyFile = () =>{
	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getPdf/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			file=xhr.response[0].file_ht;
			verify = Boolean(file);
          if(verify){  
				$("#input_pdf").css("display","none");
				$("#actions").show();
			    }else{ 
				$("#actions").css("display","none"); 
				$("#input_pdf").show();  
				}
		 }
	});

	xhr.send();
}


showPdf =()=>{ 

	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getPdf/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			    
			$file=xhr.response[0].file_ht;
			window.open(`${host_url}assets/upload/${$file}`);
		
        }else { 
			swal({
				title: "Error",
				icon: "error",
				text:  "Error al cargar el archivo ",
			});
		}
	});
	xhr.send();
}


deletePdf =()=>{ 

	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getPdf/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {

		    response =xhr.response[0].file_ht;
			aux = response.toString();
            let data = { pdf : aux }
			$.ajax({
				data: {
					data
				},
				type: "POST",
				url: host_url + `api/deletePdf/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: () => {
					swal({
						title: "Exito",
						icon: "success",
						text: "Se ha eliminado el archivo con éxito.",
					}).then(() => {
				    $("#actions").css("display","none");
					$("#input_pdf").show();
					 swal.close();
					});	 
				},
				error: () => {
					swal({
						title: "Denegado!",
						icon: "error",
						text: "No se ha podido eliminar el archivo. ",
					});
				},
			});  

        }else { 
			swal({
				title: "Error",
				icon: "error",
				text:  "Error al detectar el archivo. ",
			});
		}
	});
	xhr.send();
}





//api/getPdf


editFile = () => {
	event.preventDefault();
    id = $("#ot_number").val();
	let files = $("#pdf")[0].files;//files.length

    if(files.length > 0) {

    $.ajax({
		data: new FormData(document.getElementById("pdfs")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/editPdf/${id}`,
		success: () => {
			swal({
				title: "Exito!",
				icon: "success",
				text: "Se ha guardado el archivo con éxito. ",
				button: "OK",
			}).then(() => {
				$("#input_pdf").css("display","none");
				$("#actions").show();
				
			   });
		},
				
		       // let url = 'adminImages'+'?ot='+ot;
		       // window.open(host_url+url);
		    error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text:  result.responseJSON.msg,
			});
		},
	});

}else{ 
    swal({
        title: "Error",
        icon: "error",
        text: "Cargue un archivo pdf por favor. ",
    });
}
};

$("#upload_pdf").on("click", editFile);
$("#show_pdf").on("click", showPdf);
$("#delete_pdf").on("click", deletePdf);





