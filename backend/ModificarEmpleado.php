<?php
require_once "clases/Usuario.php";
require_once "clases/ICRUD.php";
require_once "clases/Empleado.php";
require_once "./clases/AccesoPDO.php";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $empleado_json = isset($_POST["empleado_json"]) ? $_POST["empleado_json"] : null;
    $foto = isset($_FILES["foto"]) ? $_FILES["foto"] : null;

    $empleado_data = json_decode($empleado_json);

    if($empleado_data && $foto){
        $empleado = new Empleado();
        $empleado->id = $empleado_data->id;
        $empleado->nombre = $empleado_data->nombre;
        $empleado->correo = $empleado_data->correo;
        $empleado->clave = $empleado_data->clave;
        $empleado->id_perfil = $empleado_data->id_perfil;
        $empleado->foto = $foto["name"];
        $empleado->sueldo = $empleado_data->sueldo;

        $resultado = $empleado->Modificar();

        $obj = new stdClass();
        $obj->exito = $resultado;
        $obj->mensaje = "Error al modificar al empleado.";

        if($resultado){
            $obj->mensaje = "Empleado modificado correctamente.";
        }

        echo json_encode($obj);
    } else {
        $obj = new stdClass();
        $obj->exito = false;
        $obj->mensaje = "Error en los datos recibidos.";

        echo json_encode($obj);
    }
}

?>