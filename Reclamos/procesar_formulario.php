<?php
$servername = "localhost"; 
$username = "root";
$password = "";
$dbname = "reclamos";

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}


// datos del consumidor
$nombre = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$email = $_POST['email'];
$telefono = $_POST['telefono'];
$dni = $_POST['documento'];
$domicilio = $_POST['domicilio'];
$codestudiante = $_POST['codestudiante'];
$facultad = $_POST['facultad'];

// datos del bien contratado
$bien = $_POST['ibien'];
$monto = $_POST['monto'];
$direccion = $_POST['direccion'];
$motivo = $_POST['motivo'];

//datos de la reclamacion
$reclamacion = $_POST['ireclamacion'];
$descripcion = $_POST['descripcion'];
$fechahora = $_POST['fechaHora'];
$observacion = $_POST['observacion'];
$evidencia = $_POST['evidencia'];
$estado = '1';
$codigo = 'A111';

list($fecha, $hora) = explode('T', $fechahora);

$sql = "SELECT * FROM solicitante WHERE solicitante.dni = ?";
$sql2 = $conn->prepare($sql);
$sql2->bind_param("i", $dni);
$sql2->execute();
$result = $sql2->get_result();

// Obtener el número de filas
$rowCount = $result->num_rows;

if($rowCount > 0){
    // El solicitante ya existe, solo inserta en usuariosolicitante
    $sql = "INSERT INTO usuariosolicitante (dni, idSolicitud, idFacultad, idMotivo, bien, descripcion, monto, fecha, hora, idEstado, Codigo, evidencia, Observacion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisssssisss", $dni, $reclamacion, $facultad, $motivo, $bien, $descripcion, $monto, $fecha, $hora, $estado , $codigo, $evidencia, $observacion);
    $stmt->execute();
} else {
    // El solicitante no existe, primero inserta en solicitante, luego en usuariosolicitante
    $sql = "INSERT INTO solicitante (dni, nombre, apellidos, correo, telefono, domicilio, codigoEstudiante, contrasena)
            VALUES (?, ?, ?, ?, ?, ?, ?, 'pass123')";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("issssss", $dni, $nombre, $apellidos, $email, $telefono, $domicilio, $codestudiante);
    $stmt->execute();

    // Luego inserta en usuariosolicitante
    $sql = "INSERT INTO usuariosolicitante (dni, idSolicitud, idFacultad, idMotivo, bien, descripcion, monto, fecha, hora, idEstado, Codigo, evidencia, Observacion)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiiisssssisss", $dni, $reclamacion, $facultad, $motivo, $bien, $descripcion, $monto, $fecha, $hora, $estado, $codigo, $evidencia, $observacion);
    $stmt->execute();
}

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Reclamo registrado correctamente'); window.location.href = '../index.php';</script>";
} else {
    echo "<script>alert('Error al registrar el reclamo: " . $conn->error . "'); window.location.href = 'formulario.php';</script>";
}
?>