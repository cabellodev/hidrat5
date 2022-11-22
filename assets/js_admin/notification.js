$(() => {
    get_new_messages();
    get_notification();
   
  
 });
 
 setInterval(function () {
     get_notification();
 
 }, 15000);
 
 let count_old=0; // contador antiguo de mensajes nuevos. 
 let notifications_all;
 
 
 get_notification =()=> {
   
     $("#charge").removeClass("chargePage");
 
     $.ajax({
     
         type: "GET",
         url: host_url + "api/get_notifications",
         crossOrigin: false,
         dataType: "json",
         success: (result) => {

            let new_messages=0;
            result.notifications.forEach(x=>{
                let aux= JSON.parse(x.states);
                aux.forEach(w=>{
                      if(w.id == result.id_user){
                           if(w.show == 0){
                               new_messages++;
                           }
                      }
                })
            })
             
             $('#card_notification').empty();
             $('#counter').html(new_messages);
             draw_notification(result.notifications,result.new_messages,result.id_user);
             data_table_admin(result.notifications);
             $("#charge").addClass("chargePage");
            
            
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
 
 
 
 get_new_messages=()=> {
     $.ajax({

         type: "GET",
         url: host_url + "api/get_notifications",
         crossOrigin: false,
         dataType: "json",
         success: (result) => {
            let new_messages=0;
            result.notifications.forEach(x=>{
                let aux= JSON.parse(x.states);
                aux.forEach(w=>{
                      if(w.id == result.id_user){
                           if(w.show == 0){
                               new_messages++;
                           }
                      }
                })
            })
           
            count_old=new_messages;
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
 


draw_notification=(data,new_message,user_notification)=>{
    id_user_notification=user_notification;
    notifications_all=data;
  
    let count_news = 0;

    
    if(data.length!=0){
  /*
    if(new_message.length > count_old){sound(); count_old = new_message.length;}else if(new_message.length < count_old){ count_old = new_message.length; }
    
    if(new_message.length == 0){$('#icon-comment').css('color', 'white');}else{ $('#icon-comment').css('color', '#8FF103'); } */

    let limit = 6; // limite de notificaciones a mostrar en ventanilla menor
   
    data.forEach( (x)=> {
        let states = JSON.parse(x.states);
       
       states.forEach(w=>{
       if(w.id == user_notification){
        if( limit >0){
        
        if(w.show == 0 ){
            count_news++;
            html = `<div class="alert alert-danger alert-dismissible fade show" role="alert">
            ${x.message}. | <b>Hora: ${x.date}</b> 
            <button class="btn btn-danger btn-success pull-right "  id="message_${x.id_notification}" value="${x.id_notification}" onClick="changeCheck(${x.id_notification})">
            <i class="far fa-eye" style="color:white; font-size:20px"></i>  
               
            </button>
            <button class="btn btn-primary pull-right "  id="order_${x.id_notification}" value="${x.id_notification}" onClick="directOrderAdmin(${x.ot_id})">
            ${x.ot_id} 
               
            </button>
            </div>`;
            $("#card_notification").append(html);
        }else if(w.show==1){
        
             html = `<div class="alert alert-dark alert-dismissible fade show" role="alert">
             ${x.message}. | <b>Hora: ${x.date} 
             <button class="btn btn-dark pull-right "  id="message_${x.id_notification}" value="${x.id_notification} onClick="changeCheck(${x.id_notification})">
            
             <i class="far fa-eye-slash" style="color:white; font-size:20px"></i>
                   
            </button>
            <button class="btn btn-primary pull-right "  id="order_${x.id_notification}" value="${x.id_notification}" onClick="directOrderAdmin(${x.ot_id})">
            
            ${x.ot_id}
                  
           </button>
                </div>`;
                $("#card_notification").append(html);
            
        }
     }
     limit--;
    }
    }); 

    
 })

 console.log(count_news);
 console.log(count_old);

 if(count_news > count_old){console.log("entre a sonido"); sound(); count_old = count_news;}else if(count_news < count_old){ count_old = count_news; }

    if(count_news == 0){$('#icon-comment').css('color', 'white');}else{ $('#icon-comment').css('color', '#8FF103'); }


}else{
    let html = `<div class="alert alert-dark alert-dismissible fade show" role="alert">
                No hay notificaciones generadas.
                </div>`;
                $("#card_notification").append(html);
            
}
}


changeCheck =(id)=>{

   $("#charge").removeClass("chargePage");
   let array=[];
   notifications_all.forEach(x=>{
        if(x.id_notification== id){
            console.log("entre");
           let aux = JSON.parse(x.states);
           array = aux.map(w =>{
               
            if(w.id == parseInt(id_user_notification)){
                console.log(w.show);
                w.show =1;
            }
            return w;
        })
        }
       
   })

   let data = {states : JSON.stringify(array)}
   console.log(data);

    $.ajax({
        data: { data },
		type: "POST",
		url: host_url + `api/change_notification/${id}`,
		crossOrigin: false,
		dataType: "json",
		success: () => {
            $('#card_notification').empty();
            get_notification();

            $("#charge").addClass("chargePage");
           
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

directOrderAdmin=(id)=>{

    let ot = id;
    let url = 'stagesOrder'+'?ot='+ot;
    window.location.assign(host_url+url);
}

const tabla_notification = $("#table-notifications").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
    "order": [[ 1, "desc" ]],
    columnDefs: [
        { "width": "70%", "targets": 0 }, /*Id */
        {"width": "10%", "targets": 1 },
        {"width": "10%", "targets": 2 },
        {"width": "10%", "targets": 3 },
    ],

	columns: [
		{   
        "render": function (data, type, row){
            
                             if(row.state==0){
                             return `<div class="alert alert-danger alert-dismissible fade show" role="alert">
                             ${row.message}
                                </div>`; 
                             }else if(row.state==1){
                                return `<div class="alert alert-dark alert-dismissible fade show" role="alert">
                                ${row.message}
                                   </div>`;
                             }
                   }
     },// end defaultCon
		{ data: "date" },
        { data: "ot_id" },
		{ data: "author" },
      
	],
});
data_table_admin=(data)=>{
	tabla_notification.clear();
	tabla_notification.rows.add(data);
	tabla_notification.draw();
    
}

//Buttons 

$('#btn_history_notification').on('click',()=>{
    $('#modal_history_notification').modal("show");
});















