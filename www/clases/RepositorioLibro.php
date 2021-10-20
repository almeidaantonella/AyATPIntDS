<?php
require_once '.env.php';
require_once 'clases/Usuario.php';
require_once 'clases/Libro.php';

class RepositorioLibro
{
    private static $conexion = null;

    public function __construct(){
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

    public function get_all(Usuario $usuario){

        $idUsuario = $usuario ->getId();
        $q = "SELECT ID_Libro, Titulo, Genero, Autor FROM biblioteca WHERE id_Usuario = ?";

        try {
                $query = self::$conexion->prepare($q);
                $query->bind_param("i", $idUsuario);
                $query->bind_result($numeroLibro, $titulo, $genero, $autor);


                if ($query->execute()){
                    $listaLibros = array();
                        while ($query->fetch()){
                            $listaLibros[] = new Libro($usuario, $titulo, $genero, $autor, $numeroLibro);
                            
                        }
                        return $listaLibros;
                }
                return false;
        } catch(Exception $e){
            return false;
        }
  
    }
    
    public function get_one($numero)
    {
        $q = "SELECT saldo, id_usuario FROM cuentas WHERE numero = ?";
        try {
            $query = self::$conexion->prepare($q);
            $query->bind_param("i", $numero);
            $query->bind_result($saldo, $idUsuario);

            if ($query->execute()) {
                if ($query->fetch()) {
                    $ru = new RepositorioUsuario();
                    $usuario = $ru->get_one($idUsuario);
                    return new Cuenta($usuario, $saldo, $numero);
                }
            }
            return false;
        } catch(Exception $e) {
            return false;
        }
    }

    public function delete(Cuenta $cuenta)
    {
        $n = $cuenta->getNumero();
        $q = "DELETE FROM cuentas WHERE numero = ?";
        $query = self::$conexion->prepare($q);
        $query->bind_param("i", $n);
        return ($query->execute());
    }

    public function actualizarSaldo(Cuenta $cuenta)
    {
        $n = $cuenta->getNumero();
        $s = $cuenta->getSaldo();

        $q = "UPDATE cuentas SET saldo = ? WHERE numero = ?";

        $query = self::$conexion->prepare($q);
        $query->bind_param("ii", $s, $n);

        return $query->execute();
    }
}
