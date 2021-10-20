<?php
require_once '.env.php';
require_once 'clases/Usuario.php';
require_once 'clases/Libro.php';

class RepositorioLibro
{
    private static $conexion = null;

    public function __construct()
    {
        if (is_null(self::$conexion)) {
            $credenciales = credenciales();
            self::$conexion = new mysqli(   $credenciales['servidor'],
                                            $credenciales['usuario'],
                                            $credenciales['clave'],
                                            $credenciales['base_de_datos']
                                        );
            if(self::$conexion->connect_error) {
                $error = 'Error de conexión: '.self::$conexion->connect_error;
                self::$conexion = null;
                die($error);
            }
            self::$conexion->set_charset('utf8'); 
        }
    }
    public function guardar (Libro $libro)  {
        $titulo = $libro->getTitulo();
        $genero = $libro-> getGenero();
        $autor = $libro -> getAutor();
        $idUsuario = $libro-> getIdUsuario();

        $q = "INSERT INTO biblioteca (Titulo, Genero, Autor, Id_Usuario)";
        $q.= "VALUES (?, ?, ?, ?)";

        try {
 
                $query = self::$conexion->prepare($q);

                $query->bind_param("sssi", $titulo, $genero, $autor, $idUsuario);

                    //VAMOS A INTENTAR EJECUTAR LA CONSULTA (QUERY)
                        if ($query->execute()){

                            return self::$conexion->insert_id;

                        } else {
                            return false;
                        }
            } catch (Exception $e){

                return false;

               } 
    }

}