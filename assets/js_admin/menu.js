$(() => {});

$(document).on({
	ajaxStart: function () {
		$("body").addClass("loading");
	},
	ajaxStop: function () {
		$("body").removeClass("loading");
	}
});

cerrarSesion = () => {
	$.ajax({
		data: null,
		type: "POST",
		url: host_url + "api/logout",
		crossOrigin: false,
		dataType: "json",
		success: () => {
			window.location.assign(host_url+"home/login");
		},
		error: () => {
			swal({
				title: "Error",
				icon: "error",
				text: "Ocurrio un error al cerra Sesión"
			});
		}
	});
}

$("#logout").on("click", cerrarSesion);
