<?php
require_once 'clases/Usuario.php';
require_once 'clases/Libro.php';
require_once 'clases/RepositorioLibro.php';

session_start();
if (isset($_SESSION['usuario'])) {
    $usuario = unserialize($_SESSION['usuario']);
    $nomApe = $usuario->getNombreApellido();
    $rl = new RepositorioLibro();
    $libros = $rl->get_all($usuario);


} else {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width">
        <title>Sistema de Libros</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    </head>
    <body class="container">
      <div class="jumbotron text-center">
      <h1>Prestamos de Libros</h1>
      </div>    
      <div class="text-center">
        <h3>Listado de Libros</h3>
          <table class="table table-striped">
            <tr>
            <th>Numero de Libro</th><th>Titulo del Libro</th><th>Genero</th><th>Autor</th><th>Modificar</th><th>Agregar</th><th>Eliminar</th>
            </tr>

            <?php
            if (count($libros)== 0) {
              echo "<tr><td colspan ='7'> No tiene Libros cargados</td></tr>";
            } else {
              foreach ($libros as $unLibro){
                $l = $unLibro->getId();
                  echo "<tr>";
                  echo "<td>$l</td>";
                  echo "<td>".$unLibro->getTitulo()."</td>";
                  echo "<td id ='generoNuevo-$l'>".$unLibro->getGenero()."</td>";
                  echo "<td>".$unLibro->getAutor()."</td>";
                  echo "<td><button type='button' onclick='modificarGenero($l)'> Modificar Genero</button></td>";
                  echo "<td><button type='button' onclick='agregarGenero($l)'> Agregar Genero</button></td>";
                  echo "<td><a href='eliminar.php?l=$l'>Eliminar</a></td>";
                  echo "<tr>";
              }
            }

            ?>
          </table>
          
          <div id="accion">
            <h4 id="tipo_accion"> Acción</h4>
            <input type="hidden" id="tipo">
            <input type="hidden" id="numeroLibro">
            <label for="nombre">Nombre del nuevo Genero </label>
            <input type="text" id="nombreGenero"><br>
            <button type="button" onclick="accion();">Realizar Acción</button>
          </div><hr>

        <a class="btn btn-primary" href="crear_libro.php">Agregar Libro</a>

        <p><a href="logout.php">Cerrar sesión</a></p>
      </div> 
    </body>

    <script type="text/javascript" src="js/my-app.js"></script>

</html>

