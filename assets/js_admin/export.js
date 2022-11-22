
pdfExport =()=>{

   let data = { 
        number_ot:$('#ot_number').val(),
        date_admission : $('#date_admission').val(),
        enterprise:$('#enterprise').val(),
        service:$('#service').val(),
        problem:$('#problem').val(),
        component :$('#component').val(),
        description:$('#description').val(), 
        priority: $('#priority').val(),

    }

 
    $.ajax({
        data: { data },
        type: "POST",
        url: host_url + "api/exportOT",
        crossOrigin: false,
        async:false,
        dataType: "json",
    
        success: (result) => {
          window.open(host_url+result.msg);
                
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

}


$("#export").on('click', pdfExport);