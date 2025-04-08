<?php
// cabecera para que responda en formato json
header("Content-Type: application/json");

// aqui se verifica si hay una operacion
if (isset($_GET['opc'])) {
    include("db.php"); // se incluye el archivo de la base

    switch ($_GET['opc']) {
        // listar los usuarios
        case "listar":
            $datos = listar($con);
            echo json_encode($datos); // devuelve todo en json
            break;

        // insertar datos nuevos
        case "insertar":
            $data = json_decode(file_get_contents("php://input"));
            // se verifica que no vayan vacios
            if (!empty($data->nombre) && !empty($data->email)) {
                echo insertar($con, $data->nombre, $data->email, $data->estado);
            } else {
                echo json_encode(["error" => "faltan datos"]);
            }
            break;

        // editar usuario
        case "editar":
            $data = json_decode(file_get_contents("php://input"));
            if (!empty($data->id) && !empty($data->nombre) && !empty($data->email)) {
                echo editar($con, $data->id, $data->nombre, $data->email, $data->estado);
            } else {
                echo json_encode(["error" => "faltan datos"]);
            }
            break;

        // eliminar usuario por id
        case "eliminar":
            if (isset($_GET['id'])) {
                echo eliminar($con, $_GET['id']);
            } else {
                echo json_encode(["error" => "id no proporcionado"]);
            }
            break;

        case "obtener":
            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                $res = mysqli_query($con, "SELECT * FROM usuarios WHERE id = $id");
                $row = mysqli_fetch_assoc($res);
                echo json_encode($row);
            } else {
                echo json_encode(["error" => "no se especificó el id"]);
            }
            break;
                
    }
}
?>
