<?php 
require_once "clases/Usuario.php";
require_once "clases/ICRUD.php";
require_once "clases/Empleado.php";
require_once "./clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $id = isset($_POST["id"]) ? $_POST["id"] : null;

    if($id){
        $respuesta = Empleado::Eliminar($id);

        $obj = new stdClass();
        $obj->exito = $respuesta;
        $obj->mensaje = $respuesta ? "Se ha eliminado correctamente al usuario." : "Error al eliminar al usuario.";
        
        echo json_encode($obj);
    } else {
        $obj = new stdClass();
        $obj->exito = $false;
        $obj->mensaje = "Error al recibir ID.";

        echo json_encode($obj);
    }
}
?>