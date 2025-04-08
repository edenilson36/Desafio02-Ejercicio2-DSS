<?php
// aqui hago una peticion a la ruta que me devuelve todos los usuarios
$url = "http://localhost/Desafio02/Ejercicio2/api/listar";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
$respuesta = curl_exec($curl);
$result = json_decode($respuesta);
curl_close($curl); // cerrar curl despues de usarlo
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuarios</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"/>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">usuarios registrados</h2>

        <!-- boton nuevo -->
        <a href="nuevo.php" class="btn btn-success mb-3">nuevo usuario</a>

        <!-- tabla -->
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>nombre</th>
                    <th>correo</th>
                    <th>estado</th>
                    <th>acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php if (is_array($result)): ?>
                    <?php foreach ($result as $usuario): ?>
                        <tr>
                            <td><?= $usuario[0] ?></td>
                            <td><?= $usuario[1] ?></td>
                            <td><?= $usuario[2] ?></td>
                            <td><?= $usuario[3] == 1 ? "activo" : "inactivo" ?></td>
                            <td>
                                <a href="editar.php?id=<?= $usuario[0] ?>" class="btn btn-sm btn-warning">editar</a>
                                <a href="eliminar.php?id=<?= $usuario[0] ?>" class="btn btn-sm btn-danger">eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-danger">no se pudo cargar la lista de usuarios</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
