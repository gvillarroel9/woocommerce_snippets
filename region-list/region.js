
var regiones = [
    { name: "Todas"}, 
    { name: "Región Metropolitana"},
    { name: "XV Arica & Parinacota"},
    { name: "I Tarapacá"},
    { name: "II Antofagasta"},
    { name: "III Atacama"},
    { name: "IV Coquimbo"},
    { name: "V Valparaíso"},
    { name: "VI O'Higgins"},
    { name: "VII Maule"},
    { name: "XVI Ñuble"},
    { name: "VIII Biobío"},
    { name: "IX Araucanía"},
    { name: "XIV Los Ríos"},
    { name: "X Los Lagos"},
    { name: "XI Aisén"},
    { name: "XII Magallanes & Antártica"}
]

var providers = [
    {name: "Fruteria Don Jorge", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 1, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Variedades Fruteria", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 2, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Tus Mangos", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 3, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Fruta donde lo pongas", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 4, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Es Rico, es Fruta", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 1, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "La mejor de Todas", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 3, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "El rincon del sabor", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 3, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Jugueria Don Ramon", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 4, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
    {name: "Abasto Frutal", address:"Av. Salvador 95, Providencia", phone: "+56 9 75830741", idRegion: 2, imgUrl: "https://i.pinimg.com/originals/1d/2d/77/1d2d77f8525b62bef6be8bf5b2c382e8.jpg"},
]


var currentProviders = [

]

var currentRegionId = 0;

getProviders(1);


function paginate(array, page_size, page_number) {
    // human-readable page numbers usually start with 1, so we reduce 1 in the first argument
    
    currentProviders = array.slice((page_number - 1) * page_size, page_number * page_size);
    insertProviders();
}


function insertPages(current, total){
    $( ".receta-pagination" ).empty();   
    for(let i=1; i<=Math.ceil(total); i++ ){
        $( ".receta-pagination" ).append( `
            <button onclick="getProviders(${i})" class="${i==current?'active': ''}">${i}</button>
        `);
    }
}

function filterRegion(id){
    currentRegionId = id;
    getProviders(1);
}


function getProviders(page){
    
    if(currentRegionId>0){        
        let filter = providers.filter((provider) => provider.idRegion == currentRegionId);
        console.log(filter)
        paginate(filter,5,page);
        insertPages(page,filter.length/5);
    }else{
        paginate(providers,5,page);
        insertPages(page,providers.length/5);
    }
}


function insertProviders(){
    $( ".provider-list" ).empty();  
    currentProviders.forEach((prov) => {
        $('.provider-list').append(`
            <div class="provider">
                <div class="provider-img" style="background-image: url(${prov.imgUrl})">

                </div>
                <div class="provider-info">
                    <h1>${prov.name}</h1>
                    <label>Dirección:</label>
                    <h3>${prov.address}</h3>
                    <label>Contacto:</label>
                    <h3>${prov.phone}</h3>
                </div>
            </div>
            <hr class="solid">
        `)
    })
}




regiones.forEach((region, index) => {
    jQuery('.region-list').append(`<li onclick="filterRegion(${index})">${region.name}</li>`);
    jQuery('.dropdown-content').append(`<a onclick="filterRegion(${index})" >${region.name}</a>`);
})

document.querySelector(".dropdown").addEventListener("mouseover", 
    function () {
        document.querySelector('.dropdown-content').style.display = 'block'
    }
);

document.querySelector(".dropdown").addEventListener("mouseout", 
    function () {
        document.querySelector('.dropdown-content').style.display = 'none'
    }
);

document.querySelectorAll(".dropdown-content a").forEach(
    (elem)=>{
        elem.addEventListener("click", function ($event) {            
            document.querySelector('.dropbtn').innerHTML =$event.target.innerHTML; 
            document.querySelector('.dropdown-content').style.display = 'none'
        })
    }
);


