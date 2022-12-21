$(() => {
get_all_notification();
   
});


setInterval(function () {
    get_news_notifications();
}, 15000);


let count_old=0;
let count_new=0;



get_all_notification = () => { 
    
    $.ajax({
        type: "GET",
        url: host_url + "api/getNotificationByTechnical",
        crossOrigin: false,
        async: false,
        dataType: "json",
        success: (result) => {

         if(result.length !=0){
            messages =JSON.parse(result[0].messages);
            count_old= JSON.parse(result[0].messages).length;
            count_new = count_old; 
            alert_green(messages);
            datatable_notification(JSON.parse(result[0].messages));

         }else{
            datatable_notification(0);
            $("#alert_notification").css('color','white');
            $("#counter").text('0');
         }
        },
        error: (result) => {
            datatable_notification(0);
        },
    });
}



get_news_notifications =()=>{
   
    $.ajax({
        type: "GET",
        url: host_url + "api/getNotificationByTechnical",
        crossOrigin: false,
        async: false,
        dataType: "json",
        success: (result) => {

         if(result.length!=0){

            count_new = JSON.parse(result[0].messages).length;
         
            if(count_new > count_old){
                 messages =JSON.parse(result[0].messages);
                 alert_green(messages);
                 count_old =count_new;
                 sound();
                 datatable_notification(JSON.parse(result[0].messages));
                }
            }else{
                $("#counter").text('0');
                datatable_notification(0);

            }
        }
        ,
        error: (result) => {
             
        },
    });
}

const table_order_search = $("#table_order_search").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "order": [[ 0, "desc" ]],
    columnDefs: [
        { "width": "10%", "targets": 0 }, /*Id */
        { "width": "25%", "targets": 1 }, /*Id */
        { "width": "15%", "targets": 2 }, /*Id */
        { "width": "25%", "targets": 3 }, /*Id */
        { "width": "25%", "targets": 4 }, /*Id */
      
    ],

	columns: [
	
        { data: "id" },
        { data: "client" },
        { data: "component" },
        { data: "description" },
     
        {   defaultContent: "oc",
        "render": function (data, type, row){
                return `<button type='button' class='btn btn-primary' name="details_order">
                  <i class="fas fa-eye">Detalles</i>
                </button>`
        }},
        
	],
});


$("#table_order_search").on("click", "button", function () {
    let data = table_order_search.row($(this).parents("tr")).data();
    if ($(this)[0].name == "details_order") {
        let ot = data.id;
		let url = 'api/stageOrderTechnical'+'?ot='+ot;
		window.location.assign(host_url+url);
	}});

const tabla_notification = $("#table-notifications").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "order": [[ 1, "desc" ]],
    columnDefs: [
        { "width": "20%", "targets": 0 }, /*Id */
        { "width": "30%", "targets": 1 }, /*Id */
        { "width": "20%", "targets": 2 }, /*Id */
        { "width": "30%", "targets": 3 }, /*Id */
    ],

	columns: [
	
        {   defaultContent: "oc",
        "render": function (data, type, row){
          if(row.state){
                return `<div class="alert alert-success"> ${row.message}</div>`; 
          }else{
            return `<div class="alert alert-dark"> ${row.message}</div>`; 
          }
            
        }},
        
        { data: "date" },
        { data: "ot" },
        {   defaultContent: "oc",
        "render": function (data, type, row){
        
            if(row.state){
                return `<button type='button' class='btn btn-primary' name="btn-check">
                  <i class="fas fa-eye"></i>
                </button>`
            }else{
                return `<button type='button' class='btn btn-dark' name="btn-check-out">
                <i class="fas fa-eye"></i>
                </button>`
  
            }
        }},
        
	],
});

$("#table-notifications").on("click", "button", function () {
    let data = tabla_notification.row($(this).parents("tr")).data();
    if ($(this)[0].name == "btn-check") {

        swal({
            title: `Confirmación`,
            icon: "warning",
            text: `¿Dejas consentimiento de haber visto este mensaje"? `,
            buttons: {
                confirm: {
                    text: `Confirmar`,
                    value: "play",
                },
                cancel: {
                    text: "Cancelar",
                    value: "cancelar",
                    visible: true,
                },
            },
        }).then((action) => {
            if (action == "play") {
                check_by_message(data.date)
            } else {
                swal.close();
            }
        });
	}
    }
);


datatable_notification=(data)=>{
	tabla_notification.clear();
	tabla_notification.rows.add(data);
	tabla_notification.draw();
}

sound =()=>{
  
    let url = host_url + "/assets/notification.mp3";
    let sound = new Howl({
        src: [url],
        volume: 4.0,
    
        onend: function () {
            swal({
				title: "Nueva notificación",
				icon: "info",
				text: "Tienes nuevas notificaciones en tu bandeja!. Revisalas! "
			}).then(() => {
				swal.close();
			});
        }
      });
       
        sound.play();
}



check_all =()=>{

 let aux=  messages.map(x=>{
      x.state =false;
      return x;
 });

 data = { message: JSON.stringify(aux) };
 
 $.ajax({
    data: {data},
    type: "POST",
    url: host_url + "api/changeState",
    crossOrigin: false,
    dataType: "json",
    success: (result) => {
        get_all_notification();
        $("#counter").text('0');
        $("#alert_notification").css('color','white');
    }});
 
}


check_by_message =(date)=>{

    let aux=messages.map(x=>{
       x.date==date ? x.state = false : x.state =x.state; // si la fecha es igual , entonces  el mensaje se vuelve visto(false), sino queda tal cual.
       return x;
   });

   data = { message: JSON.stringify(aux) };
  
   
   $.ajax({
      data: {data},
      type: "POST",
      url: host_url + "api/changeState",
      crossOrigin: false,
      dataType: "json",
      success: (result) => {
          get_all_notification();
      }});


}


alert_green=(notifications)=>{
    count_alerts= 0;
    notifications.forEach(x=>{
        if(x.state==true){
            count_alerts++;
        }
    })
    
     if(count_alerts > 0){
        $("#counter").text(count_alerts);
        $("#alert_notification").css('color','#8FF103');
     }else{
        $("#counter").text(count_alerts);
        $("#alert_notification").css('color','white');
     }

}



search_by_orders =()=>{
   search= $("#search_number").val();
   
    if(search !=""){
        
    if(!isNaN(search)){

    $.ajax({
        type: "GET",
        url: host_url + `api/technicalMaster/getOrderById/${search}`,
        crossOrigin: false,
        async: false,
        dataType: "json",
        success: (result) => {
           console.log(result);
            datatable_order_number(result);

        
        },
        error: (result) => {
            datatable_order_number(0);
        },


    });
}else{
    swal({
        title: "Valor númerico",
        icon: "warning",
        text: "El ingreso solo debe ser numérico.Intente nuevamente.",
    });

}

}else{ 
    swal({
        title: "Campo incompleto",
        icon: "warning",
        text: "Ingrese un número de orden para iniciar la búsqueda.",
    });
}


}

datatable_order_number=(data)=>{
	table_order_search .clear();
	table_order_search .rows.add(data);
	table_order_search .draw();
}

$("#list_notifications").on('click',()=>{
    $("#modal_notifications").modal('show');
})

$("#order_search").on('click',()=>{
    $("#modal_search_orders").modal('show');
})
$("#btn-search-ot").on('click',search_by_orders);
$("#btn-check-all").on('click',check_all);





    



















