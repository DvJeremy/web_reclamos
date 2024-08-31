<?php
// db.php - Archivo para la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "reclamos";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Procesar el formulario de actualización de reclamo
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['codigo'])) {
    $codigo = $_POST['codigo'];
    $observacion = $_POST['observacion'];
    $estado = $_POST['estado'];

    // Crear consulta SQL para actualizar la observación y el estado
    $sql = "UPDATE usuariosolicitante SET Observacion = ?, idEstado = ? WHERE Codigo = ?";

    // Preparar y ejecutar la consulta
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sii', $observacion, $estado, $codigo);

    if ($stmt->execute()) {
        echo "<script>alert('Reclamo actualizado exitosamente'); window.location.href='';</script>";
    } else {
        echo "<script>alert('Error al actualizar el reclamo: ".$conn->error."');</script>";
    }

    $stmt->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reclamos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="container my-5">
    <div class="table-container">
        <h2 class="text-center mb-4">Reclamos</h2>
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>DNI</th>
                    <th>Nombre del Solicitante</th>
                    <th>Descripción</th>
                    <th>Motivo</th>
                    <th>Fecha y Hora</th>
                    <th>Evidencia</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT u.Codigo, u.dni, CONCAT(s.nombre, ' ', s.apellidos) AS nombre_solicitante, u.descripcion, m.nombre AS motivo, CONCAT(u.fecha, ' ', u.hora) AS fecha_hora, u.evidencia, e.nomEstado AS estado, u.Observacion, u.idEstado
                        FROM usuariosolicitante u
                        JOIN solicitante s ON u.dni = s.dni
                        JOIN motivo m ON u.idMotivo = m.idMotivo
                        JOIN estado e ON u.idEstado = e.idEstado";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        $estado = isset($row['estado']) ? $row['estado'] : '';  // Solucionar el problema de undefined array key
                        echo "<tr>
                                <td>{$row['Codigo']}</td>
                                <td>{$row['dni']}</td>
                                <td>{$row['nombre_solicitante']}</td>
                                <td>{$row['descripcion']}</td>
                                <td>{$row['motivo']}</td>
                                <td>{$row['fecha_hora']}</td>
                                <td><a href='data:application/octet-stream;base64,".base64_encode($row['evidencia'])."' download='{$row['Codigo']}_evidencia'>Descargar</a></td>
                                <td>{$estado}</td>
                                <td><button class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#editModal' data-id='{$row['Codigo']}' data-observacion='{$row['Observacion']}' data-estado='{$row['idEstado']}'>Editar</button></td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='9' class='text-center'>No hay reclamos</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal para editar observación y estado -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Editar Reclamo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editForm" method="POST">
                <div class="modal-body">
                    <input type="hidden" id="codigo" name="codigo">
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" name="observacion" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" id="estado" name="estado" required>
                            <option value="" selected disabled>Seleccione un estado...</option>
                            <?php
                            $estadoSql = "SELECT * FROM estado";
                            $estadoResult = $conn->query($estadoSql);
                            while($estadoRow = $estadoResult->fetch_assoc()) {
                                $estadoValue = $estadoRow['idEstado'];
                                $estadoText = $estadoRow['nomEstado'];
                                echo "<option value='{$estadoValue}'>{$estadoText}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var editModal = document.getElementById('editModal');
        editModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;
            var codigo = button.getAttribute('data-id');
            var observacion = button.getAttribute('data-observacion');
            var estado = button.getAttribute('data-estado');

            var modalBodyInput = editModal.querySelector('.modal-body #codigo');
            modalBodyInput.value = codigo;

            var modalBodyObservacion = editModal.querySelector('.modal-body #observacion');
            modalBodyObservacion.value = observacion;

            var modalBodyEstado = editModal.querySelector('.modal-body #estado');
            modalBodyEstado.value = estado;
        });

        var form = document.getElementById('editForm');
        form.addEventListener('submit', function (event) {
            event.preventDefault();
            var formData = new FormData(form);

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    location.reload();
                }
            };
            xhr.send(formData);
        });
    });
</script>
</body>
</html>
