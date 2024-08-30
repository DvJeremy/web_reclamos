<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reclamos";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Función para obtener reclamos críticos
function obtenerReclamosCriticos($conn) {
    $stmt = $conn->query("SELECT * FROM usuariosolicitante WHERE tipoReclamo = 'Crítico'"); // Ajustar según criterio de crítico
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para procesar reclamos con IA
function procesarConIA($reclamos) {
    $url = 'https://api.ejemplo.com/analizar_reclamos'; // URL de la API de IA

    $data = json_encode(['reclamos' => $reclamos]);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}

// Obtener reclamos críticos
$reclamosCriticos = obtenerReclamosCriticos($conn);

// Procesar reclamos con la IA
$resultadosIA = procesarConIA($reclamosCriticos);

// Filtrar los resultados para obtener la distribución de categorías
$categorias = [];
if (isset($resultadosIA['categorias'])) {
    foreach ($resultadosIA['categorias'] as $categoria) {
        $categorias[] = [
            'nombre' => $categoria['nombre'],
            'cantidad' => $categoria['cantidad']
        ];
    }
}

// Guardar resultados en el archivo JSON
file_put_contents('resultados_ia.json', json_encode(['categorias' => $categorias]));

// Redirigir al dashboard
header("Location: dashboard.php");
exit();
?>
