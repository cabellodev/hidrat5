let myState = {
    pdf: null,
    currentPage: 1,
    zoom: 1.4
}

const pdfjsLib = window['pdfjs-dist/build/pdf'];

let file = $("#file").val();
pdfjsLib.getDocument(`./assets/upload/${file}`).then((pdf) => {
    myState.pdf = pdf;
    render();
});

function render() {
    myState.pdf.getPage(myState.currentPage).then((page) => {

        let canvas = document.getElementById("pdf_renderer");
        let ctx = canvas.getContext('2d');
        let viewport = page.getViewport(myState.zoom);
        canvas.width = viewport.width;
        canvas.height = viewport.height;
        page.render({
            canvasContext: ctx,
            viewport: viewport
        });

    });
}


document.getElementById('go_previous')
        .addEventListener('click', (e) => {
            if(myState.pdf == null
               || myState.currentPage == 1) return;
            myState.currentPage -= 1;
            document.getElementById("current_page")
                    .value = myState.currentPage;
            render();
});


document.getElementById('go_next')
        .addEventListener('click', (e) => {
            if(myState.pdf == null 
               || myState.currentPage > myState.pdf
                                               ._pdfInfo.numPages) 
               return;
        
            myState.currentPage += 1;
            document.getElementById("current_page")
                    .value = myState.currentPage;
            render();
        });
        
        
        
document.getElementById('current_page')
        .addEventListener('keypress', (e) => {
            if(myState.pdf == null) return;
        
            // Get key code
            var code = (e.keyCode ? e.keyCode : e.which);
        
            // If key code matches that of the Enter key
            if(code == 13) {
                var desiredPage = 
                        document.getElementById('current_page')
                                .valueAsNumber;
                                
                if(desiredPage >= 1 
                   && desiredPage <= myState.pdf
                                            ._pdfInfo.numPages) {
                        myState.currentPage = desiredPage;
                        document.getElementById("current_page")
                                .value = desiredPage;
                        render();
                }
            }
        });

 document.getElementById('zoom_in')
        .addEventListener('click', (e) => {
            
            if(myState.pdf == null) return;
            if(myState.zoom > 2.0){
                console.log("mayor a 2");
                return; }else{   console.log("menor a 2"); myState.zoom += 0.2;}
            render();
        });


document.getElementById('zoom_out')
        .addEventListener('click', (e) => {
            
            if(myState.pdf == null) return;
            console.log(myState.zoom);
            if(myState.zoom <= 1.4){ return; }else{  myState.zoom -= 0.2;}
            console.log(myState.zoom);
            render();
        });