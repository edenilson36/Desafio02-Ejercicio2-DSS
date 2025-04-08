<?php
// validacion para que no falle si no hay id
if (!isset($_GET["id"])) {
    echo "<script>alert('no se especificó el id');window.location='index.php'</script>";
    exit;
}

$id = $_GET["id"];

// pedimos el usuario a la api
$url = "http://localhost/Desafio02/Ejercicio2/api/obtener/$id";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($curl);
$result = json_decode($respuesta);
curl_close($curl);

// validamos si no vino ningun usuario con ese id
if (!$result) {
    echo "<script>alert('usuario no encontrado');window.location='index.php'</script>";
    exit;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>editar usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">modificar usuario</h2>
        <a href="index.php" class="btn btn-secondary mb-3">volver</a>

        <form action="editar.php?id=<?= $id ?>" method="POST">
            <input type="hidden" name="id" value="<?= $result->id ?>">
            <div class="form-group">
                <label for="nombre">nombre</label>
                <input type="text" class="form-control" name="nombre" id="nombre" value="<?= $result->nombre ?>" required>
            </div>
            <div class="form-group">
                <label for="email">correo</label>
                <input type="email" class="form-control" name="email" id="email" value="<?= $result->email ?>" required>
            </div>
            <div class="form-group">
                <label for="estado">estado</label>
                <select class="form-control" name="estado" id="estado">
                    <option value="1" <?= $result->estado == 1 ? "selected" : "" ?>>activo</option>
                    <option value="0" <?= $result->estado == 0 ? "selected" : "" ?>>inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">actualizar</button>
        </form>
    </div>
</body>
</html>

<?php
// si se mando el formulario
if (!empty($_POST)) {
    $url = "http://localhost/Desafio02/Ejercicio2/api/editar";
    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $headers = [
        "Accept: application/json",
        "Content-Type: application/json"
    ];
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $data = <<<DATA
    {
        "id": "{$_POST['id']}",
        "nombre": "{$_POST['nombre']}",
        "email": "{$_POST['email']}",
        "estado": {$_POST['estado']}
    }
    DATA;

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    $resp = curl_exec($curl);
    curl_close($curl);

    if ($resp == "Exito") {
        echo "<script>alert('usuario modificado exitosamente');window.location='index.php'</script>";
    } else {
        echo "<script>alert('no se pudo actualizar');window.location='index.php'</script>";
    }
}
?>
