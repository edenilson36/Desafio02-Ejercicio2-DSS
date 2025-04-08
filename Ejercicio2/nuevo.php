<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Agregar nuevo usuario</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">crear nuevo usuario</h2>
        <a href="index.php" class="btn btn-secondary mb-3">volver</a>

        <form action="nuevo.php" method="POST">
            <div class="form-group">
                <label for="nombre">nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="escriba el nombre" required>
            </div>
            <div class="form-group">
                <label for="email">correo</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="escriba el correo" required>
            </div>
            <div class="form-group">
                <label for="estado">estado</label>
                <select class="form-control" id="estado" name="estado">
                    <option value="1">activo</option>
                    <option value="0">inactivo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">guardar</button>
        </form>
    </div>
</body>
</html>

<?php
// si ya se envio el formulario
if (!empty($_POST)) {
    // aqui llamamos a la api para insertar
    $url = "http://localhost/Desafio02/Ejercicio2/api/insertar";

    $curl = curl_init($url);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    // cabeceras para json
    $headers = array(
        "Accept: application/json",
        "Content-Type: application/json"
    );
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    // obtenemos los valores del formulario
    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $estado = $_POST["estado"];

    // armamos el json que se manda al api
    $data = <<<DATA
    {
        "nombre": "$nombre",
        "email": "$email",
        "estado": $estado
    }
    DATA;

    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

    $resp = curl_exec($curl);
    curl_close($curl);

    // mostramos resultado segun lo que responda el api
    if ($resp == "Exito") {
        echo "<script>alert('usuario agregado correctamente');window.location='index.php'</script>";
    } else {
        echo "<script>alert('no se pudo guardar');window.location='index.php'</script>";
    }
}
?>
