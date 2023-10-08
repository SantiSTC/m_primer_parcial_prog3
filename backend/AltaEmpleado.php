<?php
require_once "clases/Usuario.php";
require_once "clases/ICRUD.php";
require_once "clases/Empleado.php";
require_once "./clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $correo = isset($_POST["correo"]) ? $_POST["correo"] : null;
    $clave = isset($_POST["clave"]) ? $_POST["clave"] : null;
    $nombre = isset($_POST["nombre"]) ? $_POST["nombre"] : null;
    $id_perfil = isset($_POST["id_perfil"]) ? $_POST["id_perfil"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"]["name"] : "";
    $sueldo = isset($_POST["sueldo"]) ? $_POST["sueldo"] : null;

    $empleado = new Empleado();
    $empleado->nombre = $nombre;
    $empleado->correo = $correo;
    $empleado->clave = $clave;
    $empleado->id_perfil = $id_perfil;
    $empleado->foto = $foto;
    $empleado->sueldo = $sueldo;

    $resultado = $empleado->Agregar();

    $obj = new stdClass();
    $obj->exito = $resultado;
    $obj->mensaje = "Error al agregar al empleado.";

    if($obj->exito){
        $obj->mensaje = "Empleado agregado exitosamente.";
    }

    echo json_encode($obj);
}

?>