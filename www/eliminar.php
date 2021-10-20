<?php
require_once 'clases/Usuario.php';
require_once 'clases/RepositorioLibroa.php';
require_once 'clases/RepositorioUsuario.php';
require_once 'clases/Cuenta.php';
session_start();
if (isset($_SESSION['usuario']) && isset($_GET['n'])) {
$usuario = unserialize($_SESSION['usuario']);
$rl = new RepositorioLibro();
$libro = $rl->get_one($_GET['n']);
if ($libro->getIdUsuario() != $usuario->getId()) {
die("Error: La cuenta no pertenece al usuario");
}
if ($rl->delete($libro)) {
$mensaje = "Libro eliminado con éxito";
} else {
$mensaje = "Error al eliminar la Libro";
}
header("Location: home.php?mensaje=$mensaje");

} else {
header('Location: index.php');
}
?>