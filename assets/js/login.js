$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	}
});

$(() => {
	let msg = $('#msg').val();
	if(msg){
		swal({
			title: "Error!",
			icon: "error",
			text: msg,
			button: "OK"
		})
	}
});

$("#passwd").change(() =>{ 
	let pass = $("#passwd").val();
	if(pass){
		$("#frm_passwd > input").removeClass("is-invalid");
	}else{
		$("#frm_passwd > input").addClass("is-invalid");
	}
});

$("#email").change(() => { 
	let email = $("#email").val();
	let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
	if(email && emailRegex.test(email)){
		$("#frm_email > input").removeClass("is-invalid");
	}else{
		$("#frm_email > input").addClass("is-invalid");
	}
});

$("#email_rec").change(() => { 
	let email = $("#email_rec").val();
	let emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
	if(email && emailRegex.test(email)){
		$("#frm_email_rec > input").removeClass("is-invalid");
	}else{
		$("#frm_email_rec > input").addClass("is-invalid");
	}
});

login = () => {
	let email = $("#email").val();
	let passwd = $("#passwd").val();

	let data = {
		email: email,
		passwd: passwd,
	};
	$.ajax({
		data: {
			data
		},
		type: "POST",
		url: host_url + "Login/login_user",
		crossOrigin: false,
		dataType: "json",
		success: () => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: "Inicio de Sesión exitoso",
				button: "OK"
			}).then(() => {
				window.location.assign(host_url+"api/load_page");
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
					if(msg.passwd){$("#frm_passwd > div").html(msg.passwd); $("#frm_passwd > input").addClass("is-invalid");}
					if(msg.email){$("#frm_email > div").html(msg.email); $("#frm_email > input").addClass("is-invalid");}
				});
			},
			401: (xhr) =>{
				let msg = xhr.responseJSON;
				swal({
					title: "Error",
					icon: "error",
					text: addErrorStyle(msg),
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
};

recovery = () => {
	let email_rec = $("#email_rec").val();
	data = {email_rec: email_rec},
	$.ajax({
		data: {data},
		type: "POST",
		url: host_url + "api/recovery_email",
		crossOrigin: false,
		dataType: "json",
		success: () => {
			swal({
				title: "Éxito!",
				icon: "success",
				text: "Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.",
				button: "OK"
			}).then(() => {
				close_modal_recovery();
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
					if(msg.email){$("#frm_email_rec > div").html(msg.email); $("#frm_email_rec > input").addClass("is-invalid");}
				});
			},
			401: (xhr) => {
				let msg = xhr.responseJSON;
				swal({
					title: "Error",
					icon: "error",
					text: addErrorStyle(msg),
				})
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
}

close_modal_recovery = () =>{
    $("#email_rec").val("");
    $("#frm_email_rec > input").removeClass("is-invalid");
    $('#modal_recovery').modal('hide');
}

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

$("#login").on("click", login);
$("#btn_recovery").on("click", recovery);
