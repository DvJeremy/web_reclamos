<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Libro de Reclamaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <img src="../img/libroreclam.png" alt="Imagen de Libro de Reclamaciones" class="img-fluid mt-4" >
        </div>

        <!-- Campos de búsqueda y filtrado -->
        <br><br><h3 class="form-title">Consultar libro de reclamos</h3>
        <div class="row my-3">
            <div class="col-md-4">
                <input type="text" id="searchCodigo" class="form-control" placeholder="Buscar por Código">
            </div>
            <div class="col-md-4">
                <input type="text" id="searchDNI" class="form-control" placeholder="Buscar por DNI">
            </div>
            <div class="col-md-4">
                <select id="filterYear" class="form-select">
                    <option value="">Filtrar por Año</option>
                    <option value="2019">2019</option>
                    <option value="2020">2020</option>
                    <option value="2021">2021</option>
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                </select>
            </div>
        </div>

        <!-- Tabla de usuarios solicitantes -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>DNI</th>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Facultad</th>
                    <th>Motivo</th>
                </tr>
            </thead>
            <tbody id="usuariosSolicitantesTable">
                <?php
                // Conexión a la base de datos y consulta
                $conn = new mysqli("localhost", "root", "", "reclamos");
                if ($conn->connect_error) {
                    die("Error de conexión: " . $conn->connect_error);
                }

                $sql = "SELECT us.dni, us.Codigo, us.descripcion, us.fecha, us.hora, e.nomEstado, f.nombre AS facultad, m.nombre AS motivo 
                        FROM usuariosolicitante us
                        JOIN estado e ON us.idEstado = e.idEstado
                        JOIN facultad f ON us.idFacultad = f.idFacultad
                        JOIN motivo m ON us.idMotivo = m.idMotivo";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["dni"] . "</td>";
                        echo "<td>" . $row["Codigo"] . "</td>";
                        echo "<td>" . $row["descripcion"] . "</td>";
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td>" . $row["hora"] . "</td>";
                        echo "<td>" . ($row["nomEstado"] ? 'Resuelto' : 'Pendiente') . "</td>";
                        echo "<td>" . $row["facultad"] . "</td>";
                        echo "<td>" . $row["motivo"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='8' class='text-center'>No hay registros</td></tr>";
                }

                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            function filterTable() {
                let codigo = $('#searchCodigo').val().toLowerCase();
                let dni = $('#searchDNI').val().toLowerCase();
                let year = $('#filterYear').val();

                $('#usuariosSolicitantesTable tr').filter(function() {
                    $(this).toggle(
                        ($(this).find('td:eq(0)').text().toLowerCase().indexOf(dni) > -1 || dni === '') &&
                        ($(this).find('td:eq(1)').text().toLowerCase().indexOf(codigo) > -1 || codigo === '') &&
                        ($(this).find('td:eq(3)').text().indexOf(year) > -1 || year === '')
                    );
                });
            }

            $('#searchCodigo, #searchDNI, #filterYear').on('input change', filterTable);
        });
    </script>
</body>
</html>
