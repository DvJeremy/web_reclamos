<?php
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

function obtenerCalificaciones($conn)
{
    $stmt = $conn->query("SELECT calificacion, COUNT(*) as cantidad FROM formulario GROUP BY calificacion");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerTiempoRespuesta($conn)
{
    $stmt = $conn->query("SELECT MIN(tiempoRespuesta) as minTiempo, MAX(tiempoRespuesta) as maxTiempo, AVG(tiempoRespuesta) as mediaTiempo FROM formulario");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function obtenerDificultad($conn)
{
    $stmt = $conn->query("SELECT dificultad, COUNT(*) as cantidad FROM formulario GROUP BY dificultad");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerResuelto($conn)
{
    $stmt = $conn->query("SELECT resuelto, COUNT(*) as cantidad FROM formulario GROUP BY resuelto");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerInformado($conn)
{
    $stmt = $conn->query("SELECT informado, COUNT(*) as cantidad FROM formulario GROUP BY informado");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function obtenerSugerenciasMejora($conn)
{
    $stmt = $conn->query("SELECT sugerenciasMejora FROM formulario");
    $sugerencias = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $palabras = [];
    foreach ($sugerencias as $sugerencia) {
        $words = explode(' ', strtolower($sugerencia['sugerenciasMejora']));
        foreach ($words as $word) {
            if (strlen($word) > 2) {
                if (isset($palabras[$word])) {
                    $palabras[$word]++;
                } else {
                    $palabras[$word] = 1;
                }
            }
        }
    }
    arsort($palabras);
    return $palabras;
}

$calificaciones = obtenerCalificaciones($conn);
$tiempoRespuesta = obtenerTiempoRespuesta($conn);
$dificultad = obtenerDificultad($conn);
$resuelto = obtenerResuelto($conn);
$informado = obtenerInformado($conn);
$sugerenciasMejora = obtenerSugerenciasMejora($conn);
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
            padding: 10px;
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
            gap: 20px;
            justify-content: space-between;
        }

        .charts-container {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .chart-container {
            flex: 1;
            margin: 10px;
        }

        .nube-palabras {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
            height: auto;
            overflow: hidden;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 5px;
        }

        .nube-palabras span {
            position: relative;
            white-space: nowrap;
            display: inline-block;
            line-height: 1.2;
            color: #333;
            margin: 5px;
        }
    </style>
</head>

<body>
    <div class="container">
    </div>
    <div class="charts-container">
        <div class="chart-container">
            <canvas id="calificaciones"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="dificultad"></canvas>
        </div>
    </div>
    <div class="card">
        <h2>Palabras más repetidas en las sugerencias de mejora</h2>
        <div id="nubePalabras" class="nube-palabras"></div>
    </div>
    <div class="card">
        <h2>Tiempo de Respuesta</h2>
        <p>Mínimo: <?php echo $tiempoRespuesta['minTiempo']; ?> días</p>
        <p>Máximo: <?php echo $tiempoRespuesta['maxTiempo']; ?> días</p>
        <p>Media: <?php echo round($tiempoRespuesta['mediaTiempo'], 2); ?> días</p>
    </div>
    <div class="charts-container">
        <div class="chart-container">
            <canvas id="resuelto"></canvas>
        </div>
        <div class="chart-container">
            <canvas id="informado"></canvas>
        </div>
    </div>

    <script>
        const ctx1 = document.getElementById('calificaciones').getContext('2d');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: <?php echo json_encode(array_column($calificaciones, 'calificacion')); ?>,
                datasets: [{
                    label: 'Índice de satisfacción en la resolución de reclamaciones de los usuarios',
                    data: <?php echo json_encode(array_column($calificaciones, 'cantidad')); ?>,
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ctx2 = document.getElementById('dificultad').getContext('2d');
        new Chart(ctx2, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($dificultad, 'dificultad')); ?>,
                datasets: [{
                    label: '',
                    data: <?php echo json_encode(array_column($dificultad, 'cantidad')); ?>,
                    backgroundColor: [
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                    ],
                    borderColor: [
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'N° usuarios que tuvieron alguna dificultad para presentar su reclamo'
                    },
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        const ctx3 = document.getElementById('resuelto').getContext('2d');
        new Chart(ctx3, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($resuelto, 'resuelto')); ?>,
                datasets: [{
                    label: '',
                    data: <?php echo json_encode(array_column($resuelto, 'cantidad')); ?>,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'N° usuarios que tuvieron su reclamo resuelto'
                    },
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        const ctx4 = document.getElementById('informado').getContext('2d');
        new Chart(ctx4, {
            type: 'pie',
            data: {
                labels: <?php echo json_encode(array_column($informado, 'informado')); ?>,
                datasets: [{
                    label: '',
                    data: <?php echo json_encode(array_column($informado, 'cantidad')); ?>,
                    backgroundColor: [
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                    ],
                    borderColor: [
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(75, 192, 192, 1)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'N° usuarios que fueron informados sobre el estado de su reclamo'
                    },
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw;
                            }
                        }
                    }
                }
            }
        });

        const nubePalabras = document.getElementById('nubePalabras');
        const palabras = <?php echo json_encode($sugerenciasMejora); ?>;
        for (const [word, count] of Object.entries(palabras)) {
            const span = document.createElement('span');
            span.style.fontSize = `${Math.min(count * 15, 36)}px`;
            span.textContent = word;
            nubePalabras.appendChild(span);
        }
    </script>
</body>

</html>
