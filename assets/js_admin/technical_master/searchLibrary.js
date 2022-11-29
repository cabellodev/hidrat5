
$(()=>{
    
    get_tags_search();
    get_books();
    access_validation();

})

let books = [];
let tags_search= [];


access_validation=()=>{
        
    $.ajax({
		type: "GET",
		url: host_url + "api/access_user", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
           if(result[0].library_active ==0){
            $('#template_library').css('display:none');
            $('#alert-active').show();
                swal({
                    title: "Acceso denegado a la Biblioteca ",
                    icon: "warning",
                    text: "Usted no posee los permisos para realizar acciones sobre las documentaciones de esta sección.Comuniquese con el Super administrador.",
                    button: "OK",
                })
           }else{

            $('#template_library').show();
            $('#alert-active').hide();
            }
           }
            
        },
    
    );

}


get_tags_search=()=>{
        
    $.ajax({
		type: "GET",
		url: host_url + "api/get_tags", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
         
            $('#tags_search').empty();
            spaceTags_search(result);
            
        },
    
    });

}


spaceTags_search= (colection) => {

    colection.forEach(element => {
    union = element.name.replace(/ /g, "");
    html = ` <span class="badge badge-secondary tags-class" style="font-size: 15px" id ="search_${union}" onClick= "selectionTag_search('${element.name}')">${element.name} </span>`;
    $('#tags_search').append(html);
    });    
}


selectionTag_search=(element)=>{
    let repeat = false;
    union = element.replace(/ /g, "");
   
    if($(`#search_${union}`).hasClass('badge-danger')){
            $(`#search_${union}`).removeClass( "badge-danger" ).addClass( "badge-secondary");
                let aux = _.remove(tags_search, (x)=>{
                    return x != element; // se conservan todos los x diferentes de elemento 
                 })
            //vacia la lista de envio
            tags_search=aux; // la rellena con los elementos que quedaron de la eliminacion
            console.log(tags_search);
   
            
      
    }else{
                $(`#search_${union}`).removeClass( "badge-secondary" ).addClass( "badge-danger");
                tags_search.push(element); // agrega a lista de tags que se enviara.
                console.log(tags_search);
               
    }
}

let books_selector=[]; // guarda todos los documentos lanzados por la busqueda
// al final del proceso cololar tags_search= [];
get_books_selection =()=>{
    books_selector=[];
    let data = {};
    
    books.forEach(w=>{ 
    let ok = false;
       tags = w.tags.split(','); 
             tags_search.forEach(y=>{  // recorrido de los tags seleccionados 
                     tags.forEach(x=>{  // comparar con cada uno de los tags del documento
                             if(x==y){ // compara si el elemento seleccionado es igual al que pertenece al documento 
                                ok = true;
                             }
                })
            })
            if(ok){ 
                data = {
                      id: w.id_document,
                      name: w.name,
                      file_name: w.file_name,
                      tags: w.tags,
                      description: w.description,
                }
                books_selector.push(data);

           }
    })
    console.log(books_selector);
    if(books_selector.length == 0){
        swal({
            title: "Sin resultados",
            icon: "error",
            text:"No se han encontrado resultado de su busqueda."
        }).then(()=>{
            get_books();
        })

    }else{

        swal({
          title: "Éxito",
          icon: "success",
          text:"Se han encontrado resultado con éxito."
         }).then(()=>{
                get_tags_search();
                datatable(books_selector);
                tags_search= []
                });

         }

}





get_books =()=>{

    $.ajax({
		type: "GET",
		url: host_url + "api/get_document_active", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
           datatable(result);
           books = result;
          
        },
})

}



const tabla = $("#table-document").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        {className: "text-center", "targets": [1]},
		{className: "text-center", "targets": [2]},
       
    ],
	columns: [
		{ data: "name" },
        { data: "tags" },

		{
			defaultContent: `<button type='button' name='show' class='btn btn-primary'>
                                  Ver
                                  <i class="fas fa-eye"></i>
                              </button>`,
		},
       
      
	],
});


$("#table-document").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "show") {
        let file = data.file_name;
		let url = 'viewDocument'+'?ot='+ file;
		window.location.assign(host_url+url);
       
     }
	}
);

datatable=(data)=>{
    tabla.clear();
    tabla.rows.add(data);
    tabla.draw();
}


$("#btn_search_doc").on("click", get_books_selection);