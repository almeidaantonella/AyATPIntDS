<?php
require_once 'clases/Usuario.php';
require_once 'clases/RepositorioLibro.php';
require_once 'clases/RepositorioUsuario.php';
require_once 'clases/Libro.php';


session_start();
if (isset($_SESSION['usuario']) && isset($_POST['nombreGenero'])) {
    
$usuario = unserialize($_SESSION['usuario']);
$rl = new RepositorioLibro();
$libro = $rl->get_one($_POST['numero_Libro']);
echo $libro;

}


if ($_POST['tipo'] == 'm'){
    $li = $libro->modificarGenero($_POST['nombreGenero']);
}else if ($_POST['tipo'] == 'a'){
    $li = $libro->actualizarGenero($_POST['nombreGenero']);
}

if ($li){
    $rl->actualizarGenero($libro);
    $respuesta['resultado'] = "OK";
} else {
    $respuesta['resultado'] = "Error al realziar la operación";
} 

$respuesta['numero_Libro'] = $libro->getId();
$respuesta['nombreGenero'] = $libro->getGenero();
echo json_encode($respuesta);

?>