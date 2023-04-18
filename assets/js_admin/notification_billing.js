

$(document).ready(function() {
    get_user();
    
});

let id_user_notification=0;
let all_users=[]
 
 get_user =()=> {

    get_id(); // recupera el id del usuario actual 
    $.ajax({
	
		type: "GET",
		url: host_url + "api/get_user_notifications",
		crossOrigin: false,
		async: false,
		dataType: "json",
		success: (result) => {
             all_users=result.users;
           console.log(all_users);
		},
      
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});
}

get_id=()=> {
    $.ajax({
	
		type: "GET",
		url: host_url + "api/get_id_user",
		crossOrigin: false,
		async: false,
		dataType: "json",
		success: (result) => {
            id_user_notification=result.id_user;
		},
      
		error: (result) => {
			swal({
				title: "Error",
				icon: "error",
				text: result.responseJSON.msg,
			});
		},
	});
}


