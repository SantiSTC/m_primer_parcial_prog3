<?php
require_once "clases/Usuario.php";
require_once "clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
    $id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : null;

    $usuario = new Usuario();
    $usuario->nombre = $nombre;
    $usuario->correo = $correo;
    $usuario->clave = $clave;
    $usuario->id_perfil = $id_perfil;

    $resultado = $usuario->Agregar();

    $obj = new stdClass();
    $obj->exito = $resultado;
    $obj->mensaje = "Error al agregar al usuario.";

    if($obj->exito){
        $obj->mensaje = "Usuario agregado exitosamente.";
    }

    echo json_encode($obj);
}

?>