
$(() => {
    get_notes_ot();
});
let notes = [];

get_notes_ot = () =>{
    notes = [];
    $('#notes-container').comments({
     
        editText: 'Modificar',
        editedText: 'Editado',
        saveText: 'Actualizar',
        deleteText: 'Eliminar',
        noCommentsText: 'No hay notas',
        youText: 'Tú',
        enableReplying: false,
        enableUpvoting: false,
        enableAttachments: false,
        enableNavigation: false,
    
        fieldMappings: {
            id: 'id',
            created: 'date_created',
            modified: 'date_modified',
            content: 'content',
            fullname: 'user',
            createdByCurrentUser: 'createdByCurrentUser',
          },
    
        getComments: function(success, error) {
            id= $("#ot_number").val();
            let xhr = new XMLHttpRequest();
            xhr.open("get", `${host_url}/api/getNotesByOrder/${id}`);
            xhr.responseType = "json";
            xhr.addEventListener("load", () => {
                if (xhr.status === 200) {
                    if(notes.length == 0){
                        let data = JSON.parse(xhr.response[0][0].record);
                        $.each(data, function(i, item) {
                            if(item.user == xhr.response[1]){
                                note = {
                                    id : item.id,
                                    date_created: item.date_created,
                                    date_modified: item.date_modified,
                                    content: item.content,
                                    user: item.user,
                                    createdByCurrentUser: item.createdByCurrentUser,
                                }
                            }else{
                                note = {
                                    id : item.id,
                                    date_created: item.date_created,
                                    date_modified: item.date_modified,
                                    content: item.content,
                                    user: item.user,
                                    createdByCurrentUser: '',
                                }
                            }
                            notes.push(note);
                            note = '';
                        });
                    }
                    success(notes);
                    }
                else if (xhr.status === 400) {
                    notes = [];
                    success(notes);
                }
                else {
                    swal({
                        title: "Error",
                        icon: "error",
                        text: "Error al obtener las notas asociadas a la órden de trabajo",
                    });
                }
            });
            xhr.send();
        },
        postComment: function(commentJSON, success, error) {
            let notas = [];
            if(notes.length == 0) notas = false; else notas = notes;
            data = {
                id : commentJSON.id,
                content: commentJSON.content,
                user: commentJSON.user,
                createdByCurrentUser: commentJSON.createdByCurrentUser,
                notes: notas,
                ot_id: $("#ot_number").val(),
            } 
            $.ajax({
                type: "POST",
                url: host_url + "api/createNote",
                data: {data},
                dataType: "json",
                success: (note) => {
                    swal({
                        title: "Éxito!",
                        icon: "success",
                        text: "Nueva nota agregada con éxito.",
                        button: "OK",
                    }).then(() => {
                        note_update = {
                            id : note.id,
                            date_created: note.date_created,
                            date_modified: note.date_modified,
                            content: note.content,
                            user: note.user,
                            createdByCurrentUser: note.createdByCurrentUser,
                        }
                        notes.push(note_update);
                        success(note);
                    });
                }, 
                statusCode: {
                 405: (xhr) =>{
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
        },

        putComment: function(commentJSON, success, error) {
            let id_update;

            for(i=0; i< notes.length ;i++){
                if(notes[i].id == commentJSON.id){
                    notes[i].date_modified = commentJSON.date_modified;
                    notes[i].content = commentJSON.content;
                    id_update = i;
                };
            }            

            data = {
                notes: notes,
                ot_id: $("#ot_number").val(),
            } 
         
            $.ajax({
                type: "POST",
                url: host_url + "api/updateNote",
                data: {data},
                dataType: "json",
                success: () => {
                    swal({
                        title: "Éxito!",
                        icon: "success",
                        text: "Nota actualizada con éxito.",
                        button: "OK",
                    }).then(() => {
                        success(notes[id_update]);
                        id_update=0;
                    });
                }, 
                statusCode: {
                 405: (xhr) =>{
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
        },
        deleteComment: function(commentJSON, success, error) {
            for(i=0; i< notes.length ;i++){
                if(notes[i].id == commentJSON.id){
                    notes = jQuery.grep(notes, function(value) {
                        return value != notes[i];
                    });
                };
            }

            let aux;
            if(notes.length == 0){
                aux = '';
            }else {
                aux = notes;
            }
         
            data = {
                notes: aux,
                ot_id: $("#ot_number").val(),
            } 
            $.ajax({
                type: "POST",
                url: host_url + "api/deleteNote",
                data: {data},
                dataType: "json",
                success: () => {
                    swal({
                        title: "Éxito!",
                        icon: "success",
                        text: "Nota eliminada con éxito.",
                        button: "OK",
                    }).then(() => {
                        success(success);
                    });
                }, 
                statusCode: {
                 405: (xhr) =>{
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
        },
    });
}



/*Función para manejo de errores*/
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