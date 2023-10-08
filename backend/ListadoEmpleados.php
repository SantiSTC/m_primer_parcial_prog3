<?php
require_once "clases/Usuario.php";
require_once "clases/ICRUD.php";
require_once "clases/Empleado.php";
require_once "clases/AccesoPDO.php";

$empleados = Empleado::TraerTodos();

echo "<h1>Listado de Empleados</h1>
        <table border='1'>
        <thead>
        <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Correo</th>
        <th>ID Perfil</th>
        <th>Sueldo</th>
        <th>Foto</th>
        </tr>
        </thead>
        <tbody>";

foreach ($empleados as $empleado):
echo "<tr>
        <td>{$empleado->id}</td>
        <td>{$empleado->nombre}</td>
        <td>{$empleado->correo}</td>
        <td>{$empleado->id_perfil}</td>
        <td>{$empleado->sueldo}</td>
        <td><img src='./empleados/fotos/{$empleado->foto}' width='50' height='50'></td>
        </tr>";
endforeach;
echo "</tbody>
        </table>";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Empleados</title>
  </head>
  <body>
      
  </body>
</html>