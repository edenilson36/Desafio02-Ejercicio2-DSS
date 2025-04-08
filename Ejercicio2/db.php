<?php
// conectar con la base de datos, estos son los datos
$con = mysqli_connect("localhost", "root", "", "usuarios_api");
if (mysqli_connect_errno()) {
    // si no se conecta muestra el error y se para
    echo "Fallo la conexion: " . mysqli_connect_error();
    die();
}

// esta funcion sirve para sacar todos los usuarios
function listar($con) {
    $res = mysqli_query($con, "SELECT * FROM usuarios");
    $rows = mysqli_fetch_all($res); // agarra todos los registros
    mysqli_close($con); // cerramos la conexion
    return $rows;
}

// esta es para insertar datos nuevos
function insertar($con, $nombre, $email, $estado) {
    $stmt = $con->prepare("INSERT INTO usuarios (nombre, email, estado) VALUES (?, ?, ?)");
    $stmt->bind_param('ssi', $nombre, $email, $estado);
    $stmt->execute();
    return "Exito"; // devuelbe texto si todo bien
}

// esta es para editar los datos del usuario
function editar($con, $id, $nombre, $email, $estado) {
    $stmt = $con->prepare("UPDATE usuarios SET nombre=?, email=?, estado=? WHERE id=?");
    $stmt->bind_param('ssii', $nombre, $email, $estado, $id);
    $stmt->execute();
    return "Exito";
}

// esta elimina un usuario por su id
function eliminar($con, $id) {
    $stmt = $con->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    return "Exito";
}
?>
