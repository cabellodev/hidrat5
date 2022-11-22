$("#passwd").change(() =>{ 
	let pass = $("#passwd").val();
	if(pass){
		$("#frm_passwd > input").removeClass("is-invalid");
	}else{
		$("#frm_passwd > input").addClass("is-invalid");
	}
});

$("#passwd_rep").change(() =>{ 
	let pass = $("#passwd_rep").val();
	if(pass){
		$("#frm_passwd_rep > input").removeClass("is-invalid");
	}else{
		$("#frm_passwd_rep > input").addClass("is-invalid");
	}
});

$("#frm_passwd_rep a").on('click', function(event) {
	event.preventDefault();
	if($('#frm_passwd_rep input').attr("type") == "text"){
		$('#frm_passwd_rep input').attr('type', 'password');
		$('#frm_passwd_rep i').addClass( "fa-eye-slash" );
		$('#frm_passwd_rep i').removeClass( "fa-eye" );
	}else if($('#frm_passwd_rep input').attr("type") == "password"){
		$('#frm_passwd_rep input').attr('type', 'text');
		$('#frm_passwd_rep i').removeClass( "fa-eye-slash" );
		$('#frm_passwd_rep i').addClass( "fa-eye" );
	}
});

$("#frm_passwd a").on('click', function(event) {
	event.preventDefault();
	if($('#frm_passwd input').attr("type") == "text"){
		$('#frm_passwd input').attr('type', 'password');
		$('#frm_passwd i').addClass( "fa-eye-slash" );
		$('#frm_passwd i').removeClass( "fa-eye" );
	}else if($('#frm_passwd input').attr("type") == "password"){
		$('#frm_passwd input').attr('type', 'text');
		$('#frm_passwd i').removeClass( "fa-eye-slash" );
		$('#frm_passwd i').addClass( "fa-eye" );
	}
});

login = () => {
	let email = $("#email").val();
	let passwd = $("#passwd").val();
	let passwd_rep = $("#passwd_rep").val();

	if(passwd === passwd_rep){
		let data = {
			email: email,
			passwd: passwd,
			passwd_rep: passwd_rep,
		};
	
		$.ajax({
			data: {
				data
			},
			type: "POST",
			url: host_url + "api/new_password",
			crossOrigin: false,
			dataType: "json",
			success: () => {
				swal({
					title: "Éxito!",
					icon: "success",
					text: "La contraseña se actualizó con éxito",
					button: "OK"
				}).then(() => {
					window.location.assign(host_url+"home/login");
				});
			},
			statusCode: {
				400: (xhr) => {
					let msg = xhr.responseJSON;
					swal({
						title: "Error",
						icon: "error",
						text: addErrorStyle(msg),
					}).then(() => {
						if(msg.passwd){$("#div_err_pass").html(msg.passwd); $("#frm_passwd > input").addClass("is-invalid");}
						if(msg.passwd_rep){$("#div_err_pass_rep").html(msg.passwd_rep); $("#frm_passwd_rep > input").addClass("is-invalid");}
					});
				},    
				404: (xhr) =>{
					let msg = xhr.responseJSON;
					swal({
						title: "Error",
						icon: "error",
						text: addErrorStyle(msg),
					});
				},
			},
			error: () => {
				swal({
					title: "Error",
					icon: "error",
					text: "No se pudo encontrar el recurso",
				}).then(() => {
					$("body").removeClass("loading");
				});
			},
		});
	}else{
		swal({
			title: "Error!",
			icon: "error",
			text: "Las contraseñas no coinciden",
			button: "OK"
		})
	}
};

addErrorStyle = errores => {
	let arrayErrores = Object.keys(errores);
	let cadena_error = "";
	let size = arrayErrores.length;
	let cont = 1;
	arrayErrores.map(err => {
		if(size!= cont){
			cadena_error += errores[`${err}`] +'\n'+'\n';
		}else{
			cadena_error += errores[`${err}`];
		}
		cont++;
	});
	return cadena_error;
};

$("#update").on("click", login);