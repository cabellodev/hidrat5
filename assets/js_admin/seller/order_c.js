$(()=>{
	verifyFile_OC();	
});


verifyFile_OC = () =>{
	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			file=xhr.response[0].correlative_oc;
			verify = Boolean(file);
          if(verify){  
				$("#input_oc").css("display","none");
				$("#actions_oc").show();
			    }else{ 
				$("#actions_oc").css("display","none"); 
				$("#input_oc").show();  
				}
		 }else{
			$("#input_oc").css("display","none");
			$("#actions_oc").css("display","none"); 
		 }
	});

	xhr.send();
}


showOC =()=>{ 

	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {
			    
			$file=xhr.response[0].correlative_oc;
			window.open(`${host_url}assets/upload/purshaseOrder/${$file}`);
		
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


deleteOC =()=>{ 

	id= $("#ot_number").val();
 
	let xhr = new XMLHttpRequest();
	xhr.open("get", `${host_url}/api/getOC/${id}`);
	xhr.responseType = "json";
	xhr.addEventListener("load", () => {
		if (xhr.status === 200) {

		    response =xhr.response[0].correlative_oc;
			aux = response.toString();
            let data = { pdf : aux }
			$.ajax({
				data: {
					data
				},
				type: "POST",
				url: host_url + `api/deleteOC/${id}`,
				crossOrigin: false,
				dataType: "json",
				success: () => {
					swal({
						title: "Exito",
						icon: "success",
						text: "Se ha eliminado el archivo con éxito.",
					}).then(() => {
				    $("#actions_oc").css("display","none");
					$("#input_oc").show();
                    $("#oc").val("");
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


editFileOC = () => {
	event.preventDefault();
    id = $("#ot_number").val();
	let files = $("#oc")[0].files;//files.length

    if(files.length > 0) {

    $.ajax({
		data: new FormData(document.getElementById("ocs")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/editOC/${id}`,
		success: () => {
			swal({
				title: "Exito!",
				icon: "success",
				text: "Se ha guardado el archivo con éxito. ",
				button: "OK",
			}).then(() => {
				$("#input_oc").css("display","none");
				$("#actions_oc").show();
				
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

$("#upload_oc").on("click", editFileOC);
$("#show_oc").on("click", showOC);
$("#delete_oc").on("click", deleteOC);





