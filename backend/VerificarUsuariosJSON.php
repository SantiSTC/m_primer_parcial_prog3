<?php
require_once "clases/Usuario.php";
require_once "clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){

$usuario_json = isset($_POST["usuario_json"]) ? $_POST["usuario_json"] : null;

$correo = json_decode($usuario_json)->correo;
$clave = json_decode($usuario_json)->clave;

$resultado = Usuario::TraerUno($correo, $clave);

$obj = new stdClass();
$obj->exito = false;
$obj->mensaje = "Error al verificar usuario.";

if($resultado != null){
    $obj->exito = true;
    $obj->mensaje = "Usuario verificado con exito.";
}

echo json_encode($obj);
}

?> 