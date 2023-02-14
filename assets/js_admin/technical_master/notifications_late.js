
$( ()=>{

    get_notifications_late();

})


const tabla_late = $("#table-late").DataTable({
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
        { "width": "20%", "targets": 4}, /*Id */
        
    ],

	columns: [
	
        { data: "report"},
        { data: "date_admission" },
        { data: "days_term" },
      
        {   defaultContent: "oc",
        "render": function (data, type, row){
        
            if(row.state){
                return `<button type='button' class='btn btn-danger' name="btn-check">
                  Atrasado
                </button>`
            }
        }},
        { data: "number_ot" },
        
	],
});


datatable_late=(data)=>{
	tabla_late.clear();
	tabla_late.rows.add(data);
	tabla_late.draw();
}

get_notifications_late=()=>{ 
    $.ajax({
        type: "GET",
        url: host_url + `api/notification_late`,
        crossOrigin: false,
        async: false,
        dataType: "json",
        success: (orders) => {
            draw_alert(orders);
        },
        error: (result) => {
            datatable_order_number(0);
        },
    });
}

let alerts_reports = [];

draw_alert =(orders)=>{

    console.log(orders);
    alerts_reports=[];
    let evaluations= orders.evaluations;
    let reparations = orders.reparations;
    let hydraulic_tests = orders.hydraulic_test;
   
    evaluations.forEach( x =>{ 

        if(parseInt(x.dias_cotizacion) < parseInt(x.days_passed)){
            aux = JSON.parse(x.details); // se extrae el valor que tiene approve_technical
            
            if(aux.approve_technical=='false'){
               order = {
                number_ot : x.number_ot ,
                date_admission: x.date_admission,
                days_term: x.dias_cotizacion, // plazo de evaluacion
                report:'Evaluación',
                state : true, //true es atrasado
               }

               alerts_reports.push(order);
            }
        }
    })


    reparations.forEach( x =>{ 

        if(parseInt(x.dias_rep) < parseInt(x.days_passed)){
            
               order = {
                number_ot : x.number_ot ,
                date_admission: x.date_admission,
                days_term: x.dias_rep,//plazo de reparapacion
              
                report:'Reparación',
                state : true, //true es atrasado
               }

               alerts_reports.push(order);
            
        }
    })


    
    hydraulic_tests.forEach( x =>{ 

        

        if(x.date_limit < x.date_current){
            if(x.check_technical == 'false'){
                 console.log("entre");
                order = {
                    number_ot : x.number_ot ,
                    date_admission: x.date_admission,
                    days_term: x.days_term,//plazo de reparapacio
                    report:'Test hidráulico',
                    state : true, //true es atrasado
                   }
    
                   alerts_reports.push(order);
                
            }
            
               
        }
    })


    datatable_late(alerts_reports);

    if(alerts_reports.length == 0 ){
        $("#order_late").css('color', 'white'); 

    }else{
        $("#order_late").css('color', 'orange');
    }

}



$("#order_late").on("click", ()=>{
    $("#modal_late").modal("show");
})

