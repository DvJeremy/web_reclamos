<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reclamos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];
    $sql = "SELECT Codigo, Observacion, idEstado FROM usuariosolicitante WHERE Codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $codigo);
    $stmt->execute();
    $result = $stmt->get_result();
    $reclamo = $result->fetch_assoc();
    echo json_encode($reclamo);
}

$conn->close();
?>
