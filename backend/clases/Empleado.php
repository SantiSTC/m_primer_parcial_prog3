<?php

class Empleado extends Usuario implements ICRUD {
    public string $foto;
    public float $sueldo;

    public static function TraerTodos(){
        $empleados = array();

        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();
            
            $sql = $conexion->retornarConsulta("SELECT * FROM `empleados`");
            
            if($sql != false){
                $sql->execute();
                $contenido = $sql->fetchAll();

                foreach($contenido as $linea){
                    $empleado = new Empleado();
                    $empleado->id = $linea["id"];
                    $empleado->correo = $linea["correo"];
                    $empleado->clave = $linea["clave"];
                    $empleado->nombre = $linea["nombre"];
                    $empleado->id_perfil = $linea["id_perfil"];
                    $empleado->foto = $linea["foto"];
                    $empleado->sueldo = $linea["sueldo"];

                    $empleados[] = $empleado;
                }
            }
        } catch(PDOException $e){
            echo "Error al agregar a la base de datos: " . $e->getMessage();
        }

        return $empleados;
    }

    public function Agregar(){
        try{
            $nombreFoto = $this->nombre . "." . time() . ".jpg";
            $pathFoto = "./empleados/fotos/" . $nombreFoto;
            $exito = move_uploaded_file($_FILES["foto"]["tmp_name"], $pathFoto);

            if($exito){

                $conexion = AccesoPDO::retornarUnObjetoAcceso();

                $sql = $conexion->retornarConsulta("INSERT INTO `empleados`(`correo`, `clave`, `nombre`, `id_perfil`, `foto`, `sueldo`) VALUES (:correo,:clave,:nombre,:id_perfil,:foto,:sueldo)");
                $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR);
                $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR);
                $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
                $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
                $sql->bindParam(':foto', $nombreFoto, PDO::PARAM_STR);
                $sql->bindParam(':sueldo', $this->sueldo, PDO::PARAM_INT);
    
                $resultado = $sql->execute();
            } else {
                echo "ERROR al guardar al empleado.";
            }

        } catch(PDOException $e){
            echo "Error al agregar a la base de datos: " . $e->getMessage();
            $resultado = false;
        }

        return $resultado;
    }

    public function Modificar(){
        try{
            if($this->foto !== null){
                $pathFoto = "./backend/empleados/fotos/" . basename($this->foto);
                move_uploaded_file($this->foto, $pathFoto);
            }

            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("UPDATE `empleados` SET `id`=:id,`correo`=:correo,`clave`=:clave,`nombre`=:nombre,`id_perfil`=:id_perfil,`foto`=:foto,`sueldo`=:sueldo WHERE `id` = :id");
            $sql->bindParam(':id', $this->id, PDO::PARAM_INT);
            $sql->bindParam(':correo', $this->correo, PDO::PARAM_STR);
            $sql->bindParam(':clave', $this->clave, PDO::PARAM_STR);
            $sql->bindParam(':nombre', $this->nombre, PDO::PARAM_STR);
            $sql->bindParam(':id_perfil', $this->id_perfil, PDO::PARAM_INT);
            $sql->bindParam(':foto', basename($this->foto), PDO::PARAM_STR);
            $sql->bindParam(':sueldo', $this->sueldo, PDO::PARAM_INT);

            $resultado = $sql->execute();
        } catch(PDOException $e){
            echo "Error al modificar: " . $e->getMessage();
            $resultado = false;
        }

        return $resultado;
    }

    public static function Eliminar(int $id){
        try{
            $conexion = AccesoPDO::retornarUnObjetoAcceso();

            $sql = $conexion->retornarConsulta("DELETE FROM `empleados` WHERE `id` = :id");
            $sql->bindParam(':id', $id, PDO::PARAM_INT);

            $resultado = $sql->execute();
        } catch(PDOException $e){
            $resultado = false;
        }

        return $resultado;
    }

}
?>