$(()=>{
    $("#alert").hide();
    $('.title').hide();
    $('.title2').hide();
    fillYear();
});

let global_period ;

let valores = [{"id":1,"ot":"8000"},{"id":2,"ot":"5000"},{"id":2,"ot":"5000"},
{"id":3,"ot":"5000"},{"id":4,"ot":"5000"},{"id":5,"ot":"5000"},{"id":6,"ot":"5000"},
{"id":7,"ot":"5000"},{"id":8,"ot":"5000"}];

$("#periodo").on('change',()=>{
let valor = $("#periodo").val();
if(valor==1){
  $("#observation").val("");
  $("#sugerence").val("");
}else if(valor==2){
  $("#observation2").val("");
  $("#sugerence2").val("");
}
open_modal(valor);
});

open_modal =(valor)=>{
  valor == 1? $("#search_year").modal('show'):$("#search_month").modal('show');
  
}



close_modal_2=()=>{
  $("#search_year").modal('hide');
  $("#periodo").val("");
  $(".year").val("");
}

close_modal_1=()=>{
  $("#search_month").modal('hide');
  $("#periodo").val("");
  $(".year").val("");
  $("#month").val("");
}


get_avg = () => {

   let search = $("#periodo").val();
   global_period = search;

   let data={};
   if(search==1){
    data = { year : $("#year1").val() ,period : $("#periodo").val()}
   }else{
    data = { year : $("#year").val(), month: $("#month").val() , period : $("#periodo").val()}
  }
   
  month_avg(data);
  
}

const tabla = $("#table-kpi-production").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	
	columns: [
		{ data: "id" },
	],
});

month_avg=(data)=>{
  console.log("entre ajax");
  console.log(data);
  $.ajax({
      data: { data },
      type: "POST",
      url: host_url + "module_kpi/kpi/avgProduction",
      crossOrigin: false,
      dataType: "json",
      success: (result) => {
          
          avg = parseInt(result[0].kpi_production);
       
          
     if(data.period == 2){
       
          let ots = JSON.parse(result[0].ot_production);
          let count_ot = ots.length;
          $("#search_month").modal('hide');
          $(".title2").hide();
          $("#periodo").val("");
          cleanModal();
          drawProduction(avg);
          dataTable(ots);
          fillInput(data.year ,data.month,count_ot,avg,data.period);
          
         }else {
            
          let count_ot = result.length;
          console.log(count_ot);

          let sum = 0;
          let sumOt = 0;

          /*Recorre cada mes encontrado en ese año */
          result.forEach((item)=>{
            sum = sum + parseInt(item.kpi_production);
            a = JSON.parse(item.ot_production);
            console.log(a);

            b = a.length;
            console.log(b);
            
            sumOt = sumOt + b;        
          });
          console.log(sum);
          let avg = sum/count_ot;


          console.log(avg);

          $("#search_year").modal('hide');
          $(".title").hide();
          $("#periodo").val("");
          cleanModal();
          drawProduction(avg);
          fillInput(data.year ,0, sumOt, avg,data.period);

          }

          
      },
      error: (result) => {   
          swal({
              title: "Error",
              icon: "error",
              text: "No se encuentran registros en este período.",
          }).then(()=>{  
              swal.close();
              cleanModal();
           });
      },
  });
}

cleanModal =()=>{
$(".year").val("");
$("#month").val("");
}

dataTable =(data)=>{

  tabla.clear();
  tabla.rows.add(data);	
  tabla.draw();

}


$("#btn_month").on("click", get_avg);
$("#btn_year").on("click", get_avg);



fillInput=(year, month, ot , avg ,period )=>{

  if(period==2){

  $(".title").show();
  $("#year_info").val(year);
  $("#month_info").val(convertirMes(month));
  $("#ot_info").val(ot);
  $("#avg_info").val(avg);

  }else if(period==1){
    $(".title2").show();
    $("#year_info_2").val(year);
    $("#ot_info_2").val(ot);
    $("#avg_info_2").val(avg);

  }
  
}


pdf_report =()=> {
  console.log(global_period);
  html2canvas ($ ('#gaugeChart').get(0),{ letterRendering: 1,allowTaint: true, useCORS: true }).then (function (canvas) {
    let image = canvas.toDataURL("image/png");
    let send = { base64: image};
    $.ajax({
      data: { send },
      type: "POST",
      url: host_url + "module_kpi/kpi/convertImage",
      crossOrigin: false,
      dataType: "json",
  
      success: (result) => {
       
       let data = {};
    
       if (global_period == 2){
          data  =  { year: $("#year_info").val(), month: $("#month_info").val(), counter:$("#ot_info").val() , avg : $("#avg_info").val() , observations : $("#observation").val(),periodo : global_period  , base64:result.msg , sugerence: $("#sugerence").val(),kpi:2}
          console.log(data);  
      }else if ( global_period ==1 ) {
          data = { year: $("#year_info_2").val(),counter:$("#ot_info_2").val() , avg : $("#avg_info_2").val() , observations:$("#observation2").val(),periodo : global_period,base64:result.msg ,sugerence: $("#sugerence2").val(),kpi:2}
          console.log(data);
      }
     
      $.ajax({
        data: { data },
        type: "POST",
        url: host_url + "module_kpi/kpi/report",
        crossOrigin: false,
        dataType: "json",
    
        success: (result) => {
         
         
          window.open(host_url+result.msg);
          
         /*  clean_report(result.msg);   */
        },
        error: (result) => {   
          swal({
            title: "",
            icon: "info",
            text: "Complete el campo de observaciones para generar reporte.",
        }).then(()=>{  
            swal.close();
           
         });
        }});
        
      },
      error: (result) => {   
        console.log("error");
      }});
   
    });
}
$("#pdf_report").on("click",pdf_report);
$("#pdf_report2").on("click", pdf_report);


convertirMes = (valor )=>{ 

  let mes ="";
  let meses = [{ mes:'Enero'},{ mes:'Febrero'},{ mes:'Marzo'},{ mes:'Abril'}
  ,{ mes:'Mayo'},{ mes:'Junio'},{ mes:'Julio'},{ mes:'Agosto'}
  ,{ mes:'Septiembre'},{ mes:'Octubre'},{ mes:'Noviembre'},{ mes:'Diciembre'}];

  meses.forEach((item,index)=>{
      if(index == ((parseInt(valor)-1))){ mes = item.mes ;}
  });

  return mes;
}

fillYear =()=> { 

  $.ajax({
		type: "GET",
		url: host_url + "module_kpi/kpi/getYears",
		crossOrigin: false,
		dataType: "json",

		success: (result) => {
           let data = result;
          data.forEach((i)=>{
               console.log(i.year);
               $(".year").append('<option value="' + i.year + '">' + i.year + '</option>');
          });
		},
		error: (result) => { console.log("error"); }
  
  });
}

clean_report=(report)=>{
  let data ={ clean :report}
  $.ajax({
    data: { data },
    type: "POST",
    url: host_url + "module_kpi/kpi/clean",
    crossOrigin: false,
    dataType: "json",

    success: (result) => {
      console.log("borrado");
            
    },
    error: (result) => {   
      console.log("error");
    }});
}




function drawProduction(avg) {

  var data = google.visualization.arrayToDataTable([
    ['Label', 'Value'],
    ['Producción',0],
   
  ]);

  var options = {
    width: 350,height: 300,
    greenFrom: 0, greenTo: 5,
    yellowFrom:5, yellowTo: 10,
    redFrom: 10, redTo: 15,
    min:0, max:15
    
  };

  var chart = new google.visualization.Gauge(document.getElementById('gaugeChart'));

  chart.draw(data, options);

    data.setValue(0, 1, avg);
    //data.setValue(0, 1, Math.round(Math.random()*10));
    chart.draw(data, options);
}

google.charts.load('current', {'packages':['gauge']});
google.charts.setOnLoadCallback(drawProduction);