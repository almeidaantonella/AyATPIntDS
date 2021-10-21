function accion(){

    var tipo= document.querySelector('#tipo').value; 
    var libro= document.querySelector('#numeroLibro').value; 
    var nombre_Genero= document.querySelector('#nombreGenero').value;
    var cadena = "tipo="+tipo+"&numeroLibro="+libro+"&nombre="+nombre_Genero;
 

    var solicitud = new XMLHttpRequest();
   
    solicitud.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200){
                        
            var respuesta = JSON.parse(this.responseText);
            var identificador = "#generoNuevo-" + respuesta.numero_Libro;
            var celda = document.querySelector(identificador);

            if (respuesta.resultado == "OK"){

                celda.innerHTML = respuesta.genero;

            } else {
                console.log(respuesta.resultado);
            }
          
        }
    };
    solicitud.open("POST", "accion.php",true);
    solicitud.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    solicitud.send(cadena);
 
}


function modificarGenero(nroLibro){
    document.querySelector('#tipo').value= "m";
    document.querySelector('#tipo_accion').innerHTML= "Cambiar Genero";
    document.querySelector('#numeroLibro').value =nroLibro;
    document.querySelector('#nombreGenero').focus(); 
}

function agregarGenero(nroLibro){
    document.querySelector('#tipo').value= "a";
    document.querySelector('#tipo_accion').innerHTML= "Agregar Genero";
    document.querySelector('#numeroLibro').value =nroLibro;
    document.querySelector('#nombreGenero').focus(); 
}

function buscarGenero(){
    var traerGenero= document.querySelector('#buscarGenero').value; 
    console.log(traerGenero);
}