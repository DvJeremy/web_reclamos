<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Administrador </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f7f7f7;
            color: #333;
        }

        .form-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }

        .btn-orange {
            background-color: #ff7f00;
            color: #fff;
            border: none;
        }

        .btn-orange:hover {
            background-color: #e06b00;
        }

        .form-title {
            color: #ff7f00;
            margin-bottom: 20px;
        }
    </style>

</head>
<body>

<div class="d-flex justify-content-center align-items-center min-vh-100">
        

        <div class="form-container col-md-8 col-lg-6">
            <h2 class="text-center form-title">Formulario de Reclamación</h2>
            <img src="../img/libro.png" alt="Libro de reclamacion" class="img-fluid my-3 d-block mx-auto" style="max-width: 150px;">
            <form>
                <!-- Sección 1: Identificación del consumidor reclamante -->
                <div class="mb-4">
                    <h4>Identificación del consumidor reclamante</h4>
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="fechaHora" class="form-label">Fecha/Hora</label>
                        <input type="datetime-local" class="form-control" id="fechaHora" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección Completa</label>
                        <input type="text" class="form-control" id="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento de identidad</label>
                        <input type="text" class="form-control" id="documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono Móvil</label>
                        <input type="text" class="form-control" id="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                </div>

                <!-- Sección 2: Identificación del bien contratado -->
                <div class="mb-4">
                    <h4>Identificación del bien contratado</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="producto" id="producto">
                        <label class="form-check-label" for="producto">
                            Producto
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="servicio" id="servicio">
                        <label class="form-check-label" for="servicio">
                            Servicio
                        </label>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="monto" class="form-label">Monto Reclamado</label>
                        <input type="text" class="form-control" id="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccionBien" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccionBien" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <select class="form-select" id="motivo" required>
                            <option selected disabled value="">Seleccione un motivo...</option>
                            <option value="calidad">Calidad del producto/servicio</option>
                            <option value="entrega">Problemas en la entrega</option>
                            <option value="facturación">Facturación</option>
                            <option value="otro">Otro</option>
                        </select>
                    </div>
                </div>

                <!-- Sección 3: Detalle de la reclamación -->
                <div class="mb-4">
                    <h4>Detalle de la reclamación</h4>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="reclamo" id="reclamo">
                        <label class="form-check-label" for="reclamo">
                            Reclamo
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="queja" id="queja">
                        <label class="form-check-label" for="queja">
                            Queja
                        </label>
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="detalles" class="form-label">Detalles</label>
                        <textarea class="form-control" id="detalles" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pedido" class="form-label">Pedido</label>
                        <textarea class="form-control" id="pedido" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="archivo" class="form-label">Archivo</label>
                        <input class="form-control" type="file" id="archivo" accept=".pdf,.doc,.docx,.jpg,.png">
                    </div>
                </div>

                <!-- Botón de envío -->
                <div class="d-grid">
                    <button type="submit" class="btn btn-orange btn-lg">Enviar Reclamación</button>
                </div>
            </form>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
