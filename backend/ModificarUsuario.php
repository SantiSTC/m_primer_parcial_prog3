<?php
require_once "clases/Usuario.php";
require_once "clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : null;

    $usuario_data = json_decode($usuario_json);

    if($usuario_data){
        $usuario = new Usuario();
        $usuario->id = $usuario_data->id;
        $usuario->nombre = $usuario_data->nombre;
        $usuario->correo = $usuario_data->correo;
        $usuario->clave = $usuario_data->clave;
        $usuario->id_perfil = $usuario_data->id_perfil;

        $respuesta = $usuario->Modificar();

        $obj = new stdClass();
        $obj->exito = $respuesta;
        $obj->mensaje = $respuesta ? "Se ha modificado correctamente al usuario." : "Error al modificar al usuario.";
        
        echo json_encode($obj);
    } else {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error al decodificar el JSON de usuario.";

        echo json_encode($obj);
    }
}

?>