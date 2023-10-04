<?php
require_once "clases/Usuario.php";

$usuarios = Usuario::TraerTodosJSON();

foreach($usuarios as $linea){
    echo $linea->ToJSON() . "<br>";
}

?>