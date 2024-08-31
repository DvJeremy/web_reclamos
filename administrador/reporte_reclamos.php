<?php
// Conectar a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reclamos";
//hola
try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Función para obtener el número total de reclamos
function obtenerTotalReclamos($conn) {
    $stmt = $conn->query("SELECT COUNT(*) as total FROM usuariosolicitante");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['total'];
}

// Función para obtener el número de reclamos críticos
function obtenerReclamosCriticos($conn) {
    $stmt = $conn->query("SELECT COUNT(*) as criticos FROM usuariosolicitante WHERE idEstado = 1");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['criticos'];
}

// Función para obtener el número de reclamos resueltos
function obtenerReclamosResueltos($conn) {
    $stmt = $conn->query("SELECT COUNT(*) as resueltos FROM usuariosolicitante WHERE idEstado = 2");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    return $result['resueltos'];
}

// Función para obtener nombres de facultades y motivos
function obtenerFacultades($conn) {
    $stmt = $conn->query("SELECT idFacultad, nombre FROM facultad");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerMotivos($conn) {
    $stmt = $conn->query("SELECT idMotivo, nombre FROM motivo");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener reclamos críticos con nombres
function obtenerReclamosCriticosDetalles($conn) {
    $stmt = $conn->query("SELECT usuariosolicitante.*, facultad.nombre AS facultadNombre, motivo.nombre AS motivoNombre 
                           FROM usuariosolicitante
                           JOIN facultad ON usuariosolicitante.idFacultad = facultad.idFacultad
                           JOIN motivo ON usuariosolicitante.idMotivo = motivo.idMotivo
                           WHERE idEstado = 1 LIMIT 5");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener reclamos por facultad
function obtenerReclamosPorFacultad($conn) {
    $stmt = $conn->query("
        SELECT facultad.nombre, COUNT(*) as cantidad
        FROM usuariosolicitante
        JOIN facultad ON usuariosolicitante.idFacultad = facultad.idFacultad
        GROUP BY facultad.nombre
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Función para obtener distribución de reclamos en categorías
function obtenerDistribucionCategorias($conn) {
    $stmt = $conn->query("
        SELECT motivo.nombre, COUNT(*) as cantidad
        FROM usuariosolicitante
        JOIN motivo ON usuariosolicitante.idMotivo = motivo.idMotivo
        GROUP BY motivo.nombre
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Obtener datos
$totalReclamos = obtenerTotalReclamos($conn);
$reclamosCriticos = obtenerReclamosCriticos($conn);
$reclamosResueltos = obtenerReclamosResueltos($conn);
$reclamosCriticosDetalles = obtenerReclamosCriticosDetalles($conn);
$reclamosPorFacultad = obtenerReclamosPorFacultad($conn);
$distribucionCategorias = obtenerDistribucionCategorias($conn);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 90%;
            margin: auto;
            padding: 20px;
        }
        .card {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            padding: 15px;
            text-align: center;
            flex: 1;
            min-width: 200px;
        }
        .card h2 {
            margin: 0;
            font-size: 1.5em;
        }
        .card p {
            font-size: 1.1em;
            color: #666;
        }
        .charts {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .chart-container {
            flex: 1;
            min-width: 300px;
            max-width: 600px;
            margin-bottom: 20px;
        }
        .reclamos-criticos {
            margin-top: 20px;
        }
        .reclamos-criticos div {
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #fff;
            margin-bottom: 10px;
            padding: 15px;
        }
        .reclamos-criticos div h4 {
            margin: 0;
            font-size: 1.1em;
        }
        .reclamos-criticos div p {
            margin: 5px 0;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="charts">
            <div class="card">
                <h2>Reclamos Totales</h2>
                <p><?php echo $totalReclamos; ?></p>
            </div>
            <div class="card">
                <h2>Reclamos Pendientes</h2>
                <p><?php echo $reclamosCriticos; ?></p>
            </div>
        </div>
        
        <div class="charts">
            <div class="card">
                <h2>Reclamos Resueltos</h2>
                <p><?php echo $reclamosResueltos; ?></p>
            </div>
        </div>

        <div class="charts">
            <div class="chart-container">
                <canvas id="reclamosPorFacultad"></canvas>
            </div>
            <div class="chart-container">
                <canvas id="distribucionCategorias"></canvas>
            </div>
        </div>

        <div class="reclamos-criticos">
            <h3>Reclamos Críticos Detallados</h3>
            <?php foreach ($reclamosCriticosDetalles as $reclamo): ?>
                <div>
                    <h4>Reclamo <?php echo $reclamo['Codigo']; ?></h4>
                    <p><strong>Facultad:</strong> <?php echo $reclamo['facultadNombre']; ?></p>
                    <p><strong>Motivo:</strong> <?php echo $reclamo['motivoNombre']; ?></p>
                    <p><strong>Descripción:</strong> <?php echo $reclamo['descripcion']; ?></p>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        const ctx1 = document.getElementById('reclamosPorFacultad').getContext('2d');
        const ctx2 = document.getElementById('distribucionCategorias').getContext('2d');

        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($reclamosPorFacultad, 'nombre')); ?>,
                datasets: [{
                    label: 'Reclamos por Facultad',
                    data: <?php echo json_encode(array_column($reclamosPorFacultad, 'cantidad')); ?>,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($distribucionCategorias, 'nombre')); ?>,
                datasets: [{
                    label: 'Distribución de Reclamos por Categoría',
                    data: <?php echo json_encode(array_column($distribucionCategorias, 'cantidad')); ?>,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
</body>
</html>
