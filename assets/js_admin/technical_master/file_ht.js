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
				$("#input_pdf").css("display","none");  
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





//api/getPdf





$("#show_pdf").on("click", showPdf);






