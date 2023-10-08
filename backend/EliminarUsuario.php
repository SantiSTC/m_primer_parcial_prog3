<?php
require_once "clases/Usuario.php";
require_once "clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["accion"]) && $_POST["accion"] == "borrar"){
    if(isset($_POST["id"])){
        $id = $_POST["id"];
        
        $resultado = Usuario::Eliminar($id);
        
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al eliminar el usuario.";

        if ($resultado) {
            $obj->exito = true;
            $obj->mensaje = "Usuario eliminado con éxito.";
        }

        echo json_encode($obj);
    } else {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Acción no válida.";
        
        echo json_encode($obj);
    }

}