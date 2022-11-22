
$(() => {
    get_notes_ot();
});
let notes = [];

get_notes_ot = () =>{
    notes = [];
    $('#notes-container').comments({
        sendText: 'Deshabilitado',
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
        enableEditing:false,
        enableDeleting:false,
        postCommentOnEnter:false,
        readOnly:true,
    
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