<?php
include 'conexion.php'; // Conexión a la base de datos

if(isset($_POST['codigo']) && isset($_POST['observacion']) && isset($_POST['estado'])) {
    $codigo = $_POST['codigo'];
    $observacion = $_POST['observacion'];
    $estado = $_POST['estado'];

    // Actualizar la fila correspondiente en la base de datos
    $query = "UPDATE usuariosolicitante SET Observacion = ?, idEstado = ? WHERE Codigo = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "sss", $observacion, $estado, $codigo);

    if(mysqli_stmt_execute($stmt)) {
        echo "Actualización exitosa";
    } else {
        echo "Error en la actualización: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>



