<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$nombre = "reclamos";
$usuario = "root";
$contra = "";

$conexion = mysqli_connect($host, $usuario, $contra, $nombre) or die("Error de conexion");

if (isset($_POST['nivel']) && isset($_POST['dificultad']) && isset($_POST['resuelto']) 
    && isset($_POST['tiempo']) && isset($_POST['informado']) && isset($_POST['comentario'])) {

    $nivel = $_POST['nivel'];
    $dificultad = $_POST['dificultad'];
    $resuelto = $_POST['resuelto'];
    $tiempo = $_POST['tiempo'];
    $informado = $_POST['informado'];
    $comentario = $_POST['comentario'];
    
    $consulta = "INSERT INTO formulario(idForm, calificacion, tiempoRespuesta, resuelto, dificultad, sugerenciasMejora, informado) 
                 VALUES(null, '$nivel', '$tiempo', '$resuelto', '$dificultad', '$comentario', '$informado')";
    $resultado = mysqli_query($conexion, $consulta) or die("Error de registro");
    
    echo "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Encuesta Completada</title>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css' rel='stylesheet'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    </head>
    <body>
        <script>
            Swal.fire({
                title: 'Encuesta Completada',
                text: '¡Gracias por completar la encuesta!',
                icon: 'success',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '../index.php';
                }
            });
        </script>
    </body>
    </html>";
} else {
    die("Error: Datos incompletos");
}
?>