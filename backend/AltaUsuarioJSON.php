<?php
require_once "clases/Usuario.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;

    $usuario = new Usuario();
    $usuario->nombre = $nombre;
    $usuario->correo = $correo;
    $usuario->clave = $clave;

    $resultado = $usuario->GuardarEnArchivo();
    
    echo json_decode($resultado)->mensaje;
}

?>