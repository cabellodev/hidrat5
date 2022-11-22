

let tags_current = []; //arreglo con los tag actuales 
let tags_send= []; //  arreglo con los tag a guardar 
let color =false;
let tag_create ="";
let elimination = false;
let validation = true;
let files;
let tags_edit=[]; // tag actuales del documento a la hora de editar
let edit_idDocument=0;
let state_doc=0;

$(() => {
	get_tags();
    get_books();
  
});

// trae todos los tags registrados en sistema (los muestra en el DOM)
get_tags=()=>{
        
    $.ajax({
		type: "GET",
		url: host_url + "api/get_tags", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
           
            tags_send= [];
            $('#tags_space').empty();
            tags_group = result;
            drawSpaceTag(tags_group);
            
        },
    
    });

}

// dibuja todos los tags activos en pantalla
drawSpaceTag= (colection) => {

        colection.forEach(element => {
        tags_current.push(element.name);
        union = element.name.replace(/ /g, "");
        html = ` <span class="badge badge-secondary tags-class"id =${union} onClick= "selectionTag('${element.name}')">${element.name} </span>
                <i class="fas fa-edit" id="d_${union}" onclick="edit_modal('${element.name}','${element.id_tag}')"></i>
                <i class="fas fa-trash" id="e_${union}" onclick="delete_tag('${element.name}')"></i>`
        $('#tags_space').append(html);
        });    
}

// cambio de color al momento de elegir un tag 
selectionTag=(element)=>{
    
    union = element.replace(/ /g, "");

    if($(`#${union}`).hasClass('badge-danger')){
                $(`#${union}`).removeClass( "badge-danger" ).addClass( "badge-secondary");
                let aux = _.remove(tags_send, (x)=>{
                    return x != element; // se conservan todos los x diferentes de elemento 

            })
            tags_send=[]   //vacia la lista de envio
            tags_send=aux; // la rellena con los elementos que quedaron de la eliminacion
            console.log(tags_send);
    }else{
                $(`#${union}`).removeClass( "badge-secondary" ).addClass( "badge-danger");
                tags_send.push(element); // agrega a lista de tags que se enviara.
                console.log(tags_send);
                
    }
}


addTagsDom=()=>{
    element="obra"
   
    tags_group.forEach(element => {
    tags_current.push(element);
    union = element.name.replace(/ /g, "");
    html = ` <span class="badge badge-secondary" id = ${union} onClick= "selectionTag('${element.name}');">${element.name} <i class="fas fa-edit" id="e_${union}" onclick="edit_modal('${element.name}','${element.id_tag}')"><i class="fas fa-trash"  id="d_${union}"  onCLick="delete_tag(${element})"></i></span>`
    $('#tags_space').append(html);
     });
    // funcion para la agregar de tag html
}

// carga del archivo o libro al servidor
create_document=()=>{
      
    let name = $("#doc_name").val(); // variable input tag (modal tag)
    let correlative = $("#doc_correlative").val();
    files = $("#oc")[0].files;

    if(files.length > 0) {
    
    if(tags_send.length != 0){
 
    let data = {name : name.toUpperCase(),
                correlative: correlative,
                tags: tags_send.toString()
              }
    $.ajax({
      type: "POST",
      data: { data},
      url: host_url + "api/create_document", //crear tag 
      crossOrigin: false,
      dataType: "json",
      success: (result) => {
          
              edit_file(result.id);
              $("#modal_create_tag").modal("hide");
              $("#doc_name").val('');
              $("#oc").val('');
       
              get_tags();
              get_books();
        
      },
      error: (result)=>{
          swal({
              title: "Error!",
              icon: "error",
              text: result.responseJSON.msg,
              button: "OK",
          })

      },

    });
  }else{ 
      swal({
          title: "Atención",
          icon: "warning",
          text: "Por favor , ingresar tags del documento.",
          button: "OK",
      })

  }
}else{
    swal({
        title: "Atención",
        icon: "warning",
        text: "Cargue por favor el archvivo.",
        button: "OK",
    })

}
}


edit_document=()=>{ // funcion de edicion de un documento ( modal de edicion - datatable)
      
    let name = $("#doc_name_edit").val(); // variable input tag (modal tag)
    let description ="documento";
    files = $("#oce")[0].files;

    if(files.length > 0) {
    
    if(tags_edit.length != 0){
 
    let data = {name : name.toUpperCase(),
                id:edit_idDocument,
                description: description,             
                tags: tags_edit.toString(),
              }

    console.log(data);

    $.ajax({
      type: "POST",
      data: { data},
      url: host_url + "api/edit_documents", //crear tag 
      crossOrigin: false,
      dataType: "json",
      success: (result) => {
        
            edit_file2(edit_idDocument);
            

      },
      error: (result)=>{
          swal({
              title: "Error!",
              icon: "error",
              text: result.responseJSON.msg,
              button: "OK",
          })

      },

    });
  }else{ 
      swal({
          title: "Atención",
          icon: "warning",
          text: "Por favor , ingresar tags del documento.",
          button: "OK",
      })

  }
}else{
    swal({
        title: "Atención",
        icon: "warning",
        text: "Cargue por favor el archvivo.",
        button: "OK",
    })

}
}





edit_file= (id) => {
	event.preventDefault();

    $.ajax({
		data: new FormData(document.getElementById("ocs")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/edit_document/${id}`,
		success: () => {
            swal({
                title: "Éxito",
                icon: "success",
                text:" El documento se ha creado con éxito."
            }).then(()=>{
                get_books();
            })
		},
		error: () => {
			swal({
                title: "Error",
                icon: "error",
                text:" Ha habido un error al crear el documento."
            })
		},
	});

};

// crear o registrar un nuevo tag
create_tag=()=>{
      
      let tag_create = $("#name_tag").val(); // variable input tag (modal tag)

      let data = {new_tag : tag_create}
      $.ajax({
		type: "POST",
        data: { data },
		url: host_url + "api/createTag", //crear tag 
		crossOrigin: false,
		dataType: "json",
		success: (result) => {

            swal({
				title: "Éxito!",
				icon: "success",
				text: "Tag creado con éxito",
				button: "OK",
			}).then(() => {
                $("#modal_create_tag").modal("hide");
				get_tags();
                
			});

        },
        error: (result)=>{
            swal({
				title: "Error!",
				icon: "error",
				text:  result.responseJSON.msg,
				button: "OK",
			})

        },

      });
    
}


const tabla = $("#table-document").DataTable({
	// searching: true,
	language: {
		url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
	},
	columnDefs: [
        {className: "text-center", "targets": [1]},
		{className: "text-center", "targets": [2]},
        {className: "text-center", "targets": [3]},
        {className: "text-center", "targets": [4]},

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
        {
			defaultContent: `<button type='button' name='edit' class='btn btn-primary'>
                                  Editar
                                  <i class="fas fa-edit"></i>
                              </button>`,
		},
        {  defaultContent: "oc",
        "render": function (data, type, row){
                           if(row.state == 0 ){
                           return  `<button type='button' name='deshab' class='btn btn-success'>
                                         Activado
                                         <i class="fas fa-power-off"></i>
                                    </button>`;
                           }else{

                           return `<button type='button' name='deshab' class='btn btn-dark'>
                                            Desactivado
                                         <i class="fas fa-power-off"></i>
                                    </button>`;
                           }

        }



        },
	
		
	],
});


$("#table-document").on("click", "button", function () {
	let data = tabla.row($(this).parents("tr")).data();
	if ($(this)[0].name == "show") {
        let file = data.file_name;
		let url = 'viewDocument'+'?ot='+ file;
		window.location.assign(host_url+url);
       
     }else if($(this)[0].name == "edit"){
        $("#modal_edit_document").modal("show");
         tags_edit=[];
         aux= data.tags.split(',');       
         tags_edit = aux;
         edit_idDocument=data.id_document;
         tag_current();
         get_tags_edit();
        $("#doc_name_edit").val(data.name);
        $("#doc_correlative_edit").val(data.correlative);

     }else if($(this)[0].name == "deshab"){
        let message= "";
        data.state == 1 ? message ="Deshabilitar": message ="Habilitar";
        
        swal({ 
            title: `${message} documento`,
            icon: "warning",
            text: `¿Seguro que desea ${message.toLowerCase()} el documento: "${data.name}"?.`,
            buttons: {
                confirm: {
                    text: `${message}`,
                    value: "exec",
                },
                cancel: {
                    text: "Cancelar",
                    value: "cancelar",
                    visible: true,
                },
            },
        }).then((action) => {
            if (action == "exec") {
                data.state == 1 ? state_doc = 0 :state_doc=1;
                change_state_document(state_doc,data.id_document);
            }else{
                swal.close();
    
            }
        });
            
     }
	}
);

change_state_document=(state,id)=>{

     data = {
         state: state,
         id:parseInt(id)
     }

     $.ajax({
        type: "POST",
        data: { data},
        url: host_url + "api/change_state_document", //crear tag 
        crossOrigin: false,
        dataType: "json",
        success: (result) => {
            
            swal({
                title: "Éxito",
                icon: "success",
                text:"Cambio de estado realizado con éxito",
            }).then(()=>{
                get_tags();
                get_books();
            });
                
        },
        error: (result)=>{
            swal({
                title: "Error!",
                icon: "error",
                text: result.responseJSON.msg,
                button: "OK",
            })
  
        },
  
      });



}



// lista de documentos en pantalla 
datatable=(data)=>{
         tabla.clear();
		 tabla.rows.add(data);
	     tabla.draw();
}


//obetener tods los documentos registrados
let books = [];
get_books =()=>{

    $.ajax({
		type: "GET",
		url: host_url + "api/get_document/", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
           books=[];
           datatable(result);
           books = result;
         
            
        },
        error: ()=>{
        }
})

}

// visualizar el documento especifico 
show_document = (id)=>{

    $.ajax({
		type: "GET",
		url: host_url + `api/view_document/${id}`,
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
        console.log("todo bien");
        },
        error: (result)=>{
        console.log("todo bien");
        }
})

}


// eliminar un tag 
delete_tag = (element)=> {
    swal({
        title: `Eliminación de etiqueta`,
        icon: "warning",
        text: `¿Seguro que desea eliminar la etiqueta: "${element}"?`,
        buttons: {
            confirm: {
                text: "Eliminar etiqueta",
                value: "exec",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
    
    if (action == "exec") {
    validation_delete(element);
    if(validation){
    data ={ tag_delete: element}
    $.ajax({
		type: "POST",
        data: { data },
		url: host_url + "api/delete_tags", //crear tag 
		crossOrigin: false,
		dataType: "json",
		success: (result) => {
            tagDeleteDom(element);
        },

        error: ()=>{
            swal({


				title: "Error!",
				icon: "error",
				text: "No se ha podido llevar a cabo la operacion.",
				button: "OK",
			})
        },
      });
    }else{
        swal({
            title: "Error!",
            icon: "error",
            text: "No se podido eliminar debido a que hay documentos asociados a esta etiqueta.",
            button: "OK",
        })
    }
    
    }else{ swal.close();}
    });
}

let id_tag = 0;
let old_name ="";

edit_modal =(element,id)=>{  // apertura del modal 
   old_name=element;
    swal({
        title: `Edición de etiqueta`,
        icon: "warning",
        text: `¿Seguro que desea editar la etiqueta: "${element}"?. Está acción se amplicará a todos los documentos con este tag.`,
        buttons: {
            confirm: {
                text: "Editar tag",
                value: "exec",
            },
            cancel: {
                text: "Cancelar",
                value: "cancelar",
                visible: true,
            },
        },
    }).then((action) => {
        if (action == "exec") {
            id_tag = id;
            $("#modal_edit_tag").modal("show");
        }else{
            swal.close();

        }
    });

}


tagEditDom=()=>{
    
    data = {id:id_tag , new_name:$("#new_name_tag").val()}
    console.log(data);
    $.ajax({
		type: "POST",
        data:{data},
		url: host_url + "api/edit_tag", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
            swal({
                title: "Exito",
                icon: "success",
                text:result.msg,
            }).then(()=>{
                $("#modal_edit_tag").modal("hide");
                get_tags();
                edit_all_books(old_name,data.new_name);
                old_name="";
                get_books();
            });

        },error:(result)=>{
            swal({
                title: "Corrección",
                icon: "info",
                text:result.responseJSON.msg,
            })

        }
    
    });
}


edit_all_books=(name ,new_name)=>{

    get_books();
    // aqui cambiaremos el nombre antiguo de tag por el nuevo puesto en la edicion .
    let aux=[];
    let is_isnot= false
    console.log(books);
    books.forEach( (w) => {
        tags = w.tags.split(",");

         is_isnot= false;
         aux=[];
         console.log(tags);
            tags.forEach( (x) => {
                    //guarda temporaltente los tag para ver si se guardan o no dependiendo de si se encuentro o no el tag en el arreglo.
                   if(x == name){
                       is_isnot=true;
                       aux.push(new_name);
                   }else{ 
                       aux.push(x);
                   }
              })

            
              if(is_isnot){
                     
                       data= {id:w.id_document ,tags: aux.toString()}
                       
                         $.ajax({
                            type: "POST",
                            data:{data},
                             url: host_url + "api/update_tags", //crear tag 
                            crossOrigin: false,
                            async: false,
                             dataType: "json",
                            success: (result) => {
                                console.log("..");
                             },error:(result)=>{
                                console.log(".");
                            }
                         });
                }
      })
        

}

// se eliminand de pantalla el tag borrado y se conservan los demas a enviar 
tagDeleteDom =(element)=>{ 
    union = element.replace(/ /g, "");
    $(`#${union}`).remove();
    $(`#e_${union}`).remove();
    $(`#d_${union}`).remove();
    let aux = _.remove(tags_send, (x)=>{
        return x != element; // se conservan todos los x diferentes de elemento 
    })
    tags_send=[]   //vacia la lista de envio
    tags_send=aux;
}

//validar si el tag se puede o no eliminar , ya que puede ser utilizado por algun documento registrado.

validation_delete =(element)=>{

    validation=true;
    $.ajax({
		type: "GET",
		url: host_url + "api/get_document", //crear tag 
		crossOrigin: false,
        async:false,
		dataType: "json",
		success: (result) => {
          
          result.forEach( (w) => {
          tags = w.tags.split(",");
          tags.forEach( (x) => {
                console.log(x);
                if(x == element){   
                    validation=false;
                }
              })
           })
       
         },
       
      });

}


//-------------------------------------------------------------------------------------EDICION DE DOCUMENTO-------------------------------------------------------------------------------------------------------------

tag_current=()=>{
    $('#tags_space_edit').empty();
    tags_edit.forEach(element => {
    union = element.replace(/ /g, "");
    html = ` <span class="badge badge-secondary" id ="d_id_${union}">${element} <i class="fas fa-trash"  id="d_edit_${union}"  onCLick="delete_edit_tag('${element}')"></i></span>`
    $('#tags_space_edit').append(html);
     });
    // funcion para la agregar de tag html
}



delete_edit_tag =(element)=>{ 
    union = element.replace(/ /g, "");
    $(`#d_id_${union}`).remove();
    $(`#d_edit_${union}`).remove();
    let aux = _.remove(tags_edit, (x)=>{
         return x != element; // se conservan todos los x diferentes de elemento 
    })
       //actualiza el array aux_tag_edit con el elemento eliminado
    $(`#space_${union}`).removeClass( "badge-danger" ).addClass( "badge-secondary");
    tags_edit=aux;
   
}




get_tags_edit=()=>{
        
    $.ajax({
		type: "GET",
		url: host_url + "api/get_tags", //crear tag 
		crossOrigin: false,
        async: false,
		dataType: "json",
		success: (result) => {
            console.log(result);
            $('#tags_add_edit').empty();
            spaceTags_edit(result);
            
        },
    
    });

}



selectionTag_edit=(element)=>{
    let repeat = false;
    union = element.replace(/ /g, "");
   
    if($(`#space_${union}`).hasClass('badge-danger')){
            $(`#space_${union}`).removeClass( "badge-danger" ).addClass( "badge-secondary");
                let aux = _.remove(tags_edit, (x)=>{
                    return x != element; // se conservan todos los x diferentes de elemento 
                 })
            //vacia la lista de envio
            tags_edit=aux; // la rellena con los elementos que quedaron de la eliminacion
            console.log(tags_edit);
            tag_current_new(tags_edit);
            
      
    }else{
                $(`#space_${union}`).removeClass( "badge-secondary" ).addClass( "badge-danger");
                
                tags_edit.forEach(x=>{ if(x == element){  repeat=true; } });

                if(repeat){
                    swal({
                        title: "Corección",
                        icon: "info",
                        text:"Este nombre ya esta incluido en los tags actuales del documento."
                    }).then(() => {
                        $(`#space_${union}`).removeClass( "badge-danger" ).addClass( "badge-secondary");
                    });

                }else{
                tags_edit.push(element); // agrega a lista de tags que se enviara.
                console.log(tags_edit);
                tag_current_new(tags_edit);
                }    
    }
}




spaceTags_edit= (colection) => {

    colection.forEach(element => {
    console.log(element);
    union = element.name.replace(/ /g, "");
    html = ` <span class="badge badge-secondary tags-class" id ="space_${union}" onClick= "selectionTag_edit('${element.name}')">${element.name} </span>`;
    $('#tags_add_edit').append(html);
    });    
}



tag_current_new =(colection)=>{ // funcion que actualiza los tags actuales una vez que se selecciona un nuevo tag.
    $('#tags_space_edit').empty();
    colection.forEach(element => {
    union = element.replace(/ /g, "");
    html = ` <span class="badge badge-secondary" id ="d_id_${union}">${element} <i class="fas fa-trash"  id="d_edit_${union}"  onCLick="delete_edit_tag('${element}')"></i></span>`
    $('#tags_space_edit').append(html);
     });
    // funcion para la agregar de tag html
}


edit_file2= (id) => {
	event.preventDefault();

    $.ajax({
		data: new FormData(document.getElementById("ocse")),
		processData: false,
		contentType: false,
		cache: false,
		type: "post",
		url: `${host_url}api/edit_document2/${id}`,
		success: () => {

            swal({
                title: "Éxito",
                icon: "success",
                text:" El documento se ha actualizado con exito."
            }).then(()=>{
                $("#modal_edit_document").modal("hide");
                get_books();
            })
		},
		error: () => {
			swal({
                title: "Error",
                icon: "error",
                text:" Ha habido un error al actualizar el documento."
            })
		},
	});

};








   








    













//-------------------------------------------------------------------------------------BOTONES DE ACCIÓN-------------------------------------------------------------------------------------------------------------

$(".custom-file-input").on("change", function() {
	var fileName = $(this).val().split("\\").pop();
	$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
  });


$("#btn_create").on("click", ()=>{
    $("#modal_create").modal("show");
})

$("#btn_create_tag").on("click", ()=>{
    $("#modal_create_tag").modal("show");
})

$("#btn_edit_tag").on("click",tagEditDom);
$("#btn_save_tag").on("click",create_tag);
$("#btn_create_doc").on("click",create_document);
$("#btn_edit_document").on("click",edit_document);








