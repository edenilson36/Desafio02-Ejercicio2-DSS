<?php
// agarramos el id desde la url
$id = $_GET["id"];

// pedimos los datos del usuario para mostrar en pantalla
$url = "http://localhost/Desafio02/Ejercicio2/api/obtener/$id";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($curl);
$result = json_decode($respuesta);
curl_close($curl);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>eliminar usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">¿seguro que quiere eliminar este usuario?</h2>
        <a href="index.php" class="btn btn-secondary mb-3">cancelar</a>

        <form action="eliminar.php?id=<?= $id ?>" method="POST">
            <input type="hidden" name="id" value="<?= $result->id ?>">
            <div class="form-group">
                <label>nombre</label>
                <input readonly class="form-control" value="<?= $result->nombre ?>">
            </div>
            <div class="form-group">
                <label>correo</label>
                <input readonly class="form-control" value="<?= $result->email ?>">
            </div>
            <div class="form-group">
                <label>estado</label>
                <input readonly class="form-control" value="<?= $result->estado == 1 ? 'activo' : 'inactivo' ?>">
            </div>
            <button type="submit" class="btn btn-danger">confirmar eliminación</button>
        </form>
    </div>
</body>
</html>

<?php
// si se confirma la eliminacion
if (!empty($_POST)) {
    $id = $_POST["id"];
    $url = "http://localhost/Desafio02/Ejercicio2/api/eliminar/$id";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $respuesta = curl_exec($curl);
    curl_close($curl);

    if ($respuesta == "Exito") {
        echo "<script>alert('usuario eliminado');window.location='index.php'</script>";
    } else {
        echo "<script>alert('no se pudo eliminar');window.location='index.php'</script>";
    }
}
?>
