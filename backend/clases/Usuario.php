<?php

class Usuario {
    public int $id;
    public string $nombre;
    public string $correo;
    public string $clave;
    public int $id_perfil;
    public string $perfil;

    private $pathUsuarios = "./archivos/usuarios.json";

    // public function __construct($id, $nombre, $correo, $clave, $id_perfil, $perfil){
    //     $this->id = $id;
    //     $this->nombre = $nombre;
    //     $this->correo = $correo;
    //     $this->clave = $clave;
    //     $this->id_perfil = $id_perfil;
    //     $this->perfil = $perfil;
    // }

    public function ToJSON(){
        $obj = new stdClass();

        $obj->nombre = $this->nombre;
        $obj->correo = $this->correo;
        $obj->clave = $this->clave;

        return json_encode($obj);
    }

    public function GuardarEnArchivo(){
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al guardar.";

        $archivo = fopen($this->pathUsuarios, "a");
        $retorno = fwrite($archivo, $this->ToJSON() . "\n\r");

        if($retorno > 0){
            $obj->exito = true;
            $obj->mensaje = "Guardado con exito.";
        }

        fclose($archivo);
        return json_encode($obj);
    }

    public static function TraerTodosJSON(){
        $usuarios = array();
        $pathUsuarios = "./archivos/usuarios.json";

        if(file_exists($pathUsuarios)){
            $contenido = file_get_contents($pathUsuarios);

            if($contenido !== false){
                $lineas = explode("\n\r", $contenido);

                foreach($lineas as $linea){
                    $data = json_decode($linea);

                    if($data != null){
                        $usuario = new Usuario();
                        $usuario->nombre = $data->nombre;
                        $usuario->correo = $data->correo;
                        $usuario->clave = $data->clave;

                        $usuarios[] = $usuario;
                    }
                }
            }
        }

        return $usuarios;
    }

    public function Agregar(){
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("INSERT INTO `usuarios`(`id`, `correo`, `clave`, `nombre`, `id_perfil`) VALUES (:id,:correo,:clave,:nombre,:id_perfil)");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR);
            $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR);
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
        
            $resultado = $sql->execute();
        } catch (PDOException $e){
            echo "Error al agregar a la base de datos: " . $e->getMessage();
            $resultado = false;
        }

        return $resultado;
    }

    public static function TraerTodos(){
        $usuarios = array();
        
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();
            
            $sql = $conexion->retornarConsulta("SELECT * FROM `usuarios`");

            if($sql != false){
                $sql->execute();
                $contenido = $sql->fetchAll();

                foreach($contenido as $linea){
                    $usuario = new Usuario();
                    $usuario->id = $linea["id"];
                    $usuario->correo = $linea["correo"];
                    $usuario->clave = $linea["clave"];
                    $usuario->nombre = $linea["nombre"];
                    $usuario->id_perfil = $linea["id_perfil"];

                    $usuarios[] = $usuario;
                }
            }

        } catch (PDOException $e){
            echo "Error al agregar a la base de datos: " . $e->getMessage();
        }

        return $usuarios;
    }

    public static function TraerUno(string $correo, string $clave){
        $usuarios = Usuario::TraerTodos();
        $usuarioEncontrado = null;

        foreach($usuarios as $usuario){
            if($usuario->correo == $correo && $usuario->clave == $clave){
                $usuarioEncontrado = $usuario;
            }
        }

        return $usuarioEncontrado;
    }
}


?>