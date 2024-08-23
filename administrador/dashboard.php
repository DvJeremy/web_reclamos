<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Reclamos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Estilos personalizados */
        .card {
            margin: 20px 0;
        }
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        .critical-claims {
            max-height: 300px;
            overflow-y: auto;
        }
    </style>
</head>
<body>
<div class="container-fluid">
    <!-- Título del Dashboard -->
    <div class="row">
        <div class="col-12 text-center my-4">
            <h1>Dashboard de Reclamos</h1>
        </div>
    </div>

    <!-- Contadores -->
    <div class="row text-center">
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">Total de Reclamos</h5>
                    <p class="card-text" id="totalReclamos">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">Reclamos Resueltos</h5>
                    <p class="card-text" id="reclamosResueltos">0</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h5 class="card-title">Reclamos Críticos</h5>
                    <p class="card-text" id="reclamosCriticos">0</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Reclamos por Facultad
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="reclamosPorFacultad"></canvas> <!-- ID debe coincidir -->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Estado de los Reclamos
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="estadoReclamos"></canvas> <!-- ID debe coincidir -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reclamos Críticos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    Reclamos Críticos Identificados por IA
                </div>
                <div class="card-body critical-claims" id="listaCriticos">
                    <!-- Reclamos críticos se mostrarán aquí -->
                    <p>Cargando reclamos críticos...</p>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- Script personalizado -->
    <script>
        // Datos de ejemplo para los gráficos y contadores
        // Datos de ejemplo para los gráficos y contadores
const reclamos = [
    { id: 1, solicitante: 'Carlos López', facultad: 'Ingeniería', motivo: 'Error en el horario', descripcion: 'El horario de clases se superpone con otras materias.', estado: 'Pendiente' },
    { id: 2, solicitante: 'María Pérez', facultad: 'Ciencias Sociales', motivo: 'Mala atención', descripcion: 'El servicio de atención al estudiante es deficiente.', estado: 'Resuelto' },
    { id: 3, solicitante: 'Juan Gómez', facultad: 'Medicina', motivo: 'Notas incorrectas', descripcion: 'Las notas finales no coinciden con las evaluaciones realizadas.', estado: 'En Proceso' },
    { id: 4, solicitante: 'Ana Torres', facultad: 'Artes', motivo: 'Infraestructura', descripcion: 'Las instalaciones de la facultad están en mal estado.', estado: 'Crítico' },
    { id: 5, solicitante: 'Luis Martinez', facultad: 'Ingeniería', motivo: 'Reclamo repetido', descripcion: 'Este es un reclamo repetido', estado: 'Crítico' },
    { id: 6, solicitante: 'Laura Fernández', facultad: 'Medicina', motivo: 'Problema en examen', descripcion: 'Hubo un error en el examen final.', estado: 'Resuelto' },
    { id: 7, solicitante: 'Marta Sánchez', facultad: 'Ciencias Sociales', motivo: 'Problema administrativo', descripcion: 'El sistema administrativo no procesa mi matrícula.', estado: 'Resuelto' },
    { id: 8, solicitante: 'Pedro Ramírez', facultad: 'Artes', motivo: 'Horarios incompatibles', descripcion: 'No puedo asistir a todas mis clases por conflictos de horario.', estado: 'Pendiente' },
    { id: 9, solicitante: 'Andrea Castillo', facultad: 'Ingeniería', motivo: 'Problema en evaluación', descripcion: 'La evaluación no reflejó el contenido enseñado.', estado: 'En Proceso' },
    { id: 10, solicitante: 'Fernando Díaz', facultad: 'Ciencias Sociales', motivo: 'Error en inscripción', descripcion: 'No pude inscribirme en la materia.', estado: 'Resuelto' }
];

// Calcular los totales correctos
const totalReclamos = reclamos.length;
const totalResueltos = reclamos.filter(r => r.estado.toLowerCase() === 'resuelto').length;
const totalCriticos = reclamos.filter(r => r.estado.toLowerCase() === 'crítico').length;

// Actualizar los contadores
document.getElementById('totalReclamos').innerText = totalReclamos;
document.getElementById('reclamosResueltos').innerText = totalResueltos;
document.getElementById('reclamosCriticos').innerText = totalCriticos;

// Datos de ejemplo para los gráficos
const datosReclamosPorFacultad = {
    labels: ['Ingeniería', 'Ciencias Sociales', 'Medicina', 'Artes'],
    datasets: [{
        label: 'Número de Reclamos',
        data: [
            reclamos.filter(r => r.facultad === 'Ingeniería').length,
            reclamos.filter(r => r.facultad === 'Ciencias Sociales').length,
            reclamos.filter(r => r.facultad === 'Medicina').length,
            reclamos.filter(r => r.facultad === 'Artes').length
        ],
        backgroundColor: [
            'rgba(54, 162, 235, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(75, 192, 192, 0.6)',
            'rgba(153, 102, 255, 0.6)'
        ],
        borderColor: [
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)'
        ],
        borderWidth: 1
    }]
};

const datosEstadoReclamos = {
    labels: ['Resueltos', 'Pendientes', 'En Proceso', 'Críticos'],
    datasets: [{
        label: 'Estado de Reclamos',
        data: [
            totalResueltos,
            reclamos.filter(r => r.estado.toLowerCase() === 'pendiente').length,
            reclamos.filter(r => r.estado.toLowerCase() === 'en proceso').length,
            totalCriticos
        ],
        backgroundColor: [
            'rgba(75, 192, 192, 0.6)',
            'rgba(255, 206, 86, 0.6)',
            'rgba(255, 159, 64, 0.6)',
            'rgba(255, 99, 132, 0.6)'
        ],
        borderColor: [
            'rgba(75, 192, 192, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 99, 132, 1)'
        ],
        borderWidth: 1
    }]
};

// Crear los gráficos
new Chart(document.getElementById('reclamosPorFacultad'), {
    type: 'bar',
    data: datosReclamosPorFacultad,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Reclamos por Facultad'
            }
        }
    }
});

new Chart(document.getElementById('estadoReclamos'), {
    type: 'pie',
    data: datosEstadoReclamos,
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'top'
            },
            title: {
                display: true,
                text: 'Estado de los Reclamos'
            }
        }
    }
});

// Mostrar reclamos críticos
const reclamosCriticos = reclamos.filter(r => r.estado.toLowerCase() === 'crítico');
const listaCriticos = document.getElementById('listaCriticos');
listaCriticos.innerHTML = '';
reclamosCriticos.forEach(r => {
    const item = document.createElement('p');
    item.textContent = `ID: ${r.id}, Solicitante: ${r.solicitante}, Facultad: ${r.facultad}, Motivo: ${r.motivo}, Descripción: ${r.descripcion}`;
    listaCriticos.appendChild(item);
});


    </script>
</body>
</html>
