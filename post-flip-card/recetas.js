const $ = jQuery;
        
getPosts(1);

function getPosts(page){
    $( ".grid-container" ).empty();
    $( ".grid-container" ).append('<div class="lds-ripple"><div></div><div></div></div>');
    $( ".receta-pagination" ).empty();
    $.get("https://imporfrut.cl/new/wp-json/recetas/pagina/"+page, 
        (data, status) => {       
            $( ".grid-container" ).empty();
            insertPosts(data);
            insertPages(data.current_page, data.pages)
        }
    );
}


function insertPosts(data){
    data.posts.forEach((element,index) => {

    
    $( ".grid-container" ).append( `
        
    <div class="card-container">
                <div class="card-receta">
                    <div class="card-side-receta front-receta" id="f-${index}">
                        <div style="background-image: url(${element.img_url});" class="card-img"></div>
                        <h3 class="receta-title">${element.post_title}</h3>
                        <h2 class="yellow">${element.post_excerpt}</h2>
                    </div>
                    <div class="card-side-receta back-receta" id="b-${index}" style="display: none;">
                        <div class="text">
                            <h1 class="receta-title">${element.post_title}</h1>
                            <div class= "post-content">
                                ${element.post_content}
                            </div>                            
                        </div>
                    </div>
                </div>
                <button class="card-btn" id="receta-${index}-btn1">VER RECETA<buttona>
                <button class="card-btn" id="receta-${index}-btn2" style="display: none;">OCULTAR</button>
        </div>

    `);

    document.getElementById("receta-"+index+"-btn1").addEventListener("click", function mostrarReceta () {
            document.querySelector("#b-"+index).setAttribute("style", "display:block");
            setTimeout(() => {
                document.querySelector("#f-"+index).setAttribute("style", "transform: rotateY(-180deg);");
                document.querySelector("#b-"+index).setAttribute("style", "transform: rotateY(0);");
                document.getElementById("receta-"+index+"-btn1").setAttribute("style", "display: none");
                document.getElementById("receta-"+index+"-btn2").setAttribute("style", "display: block");
            },
            100
            );
            
    });
        
    document.getElementById("receta-"+index+"-btn2").addEventListener("click", function ocultarReceta () {
            document.querySelector("#b-"+index).setAttribute("style", "display:none");
            document.querySelector("#b-"+index).setAttribute("style", "transform: rotateY(180deg);");
            document.querySelector("#f-"+index).setAttribute("style", "transform: rotateY(0);");
            document.getElementById("receta-"+index+"-btn1").setAttribute("style", "display: block");
            document.getElementById("receta-"+index+"-btn2").setAttribute("style", "display: none");
            setTimeout(() => {
                document.querySelector("#b-"+index).setAttribute("style", "display:none");
            }, 100);
        })

    });
}

function insertPages(current, total){
    
    for(let i=1; i<=total; i++ ){
        $( ".receta-pagination" ).append( `
            <button onclick="getPosts(${i})" class="${i==current?'active': ''}">${i}</button>
        `);
    }
}
