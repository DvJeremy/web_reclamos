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
            <form action="procesar_formulario.php" method="post">
                <!-- Identificación del consumidor reclamante -->
                <div class="mb-4">
                    <h4>Identificación del consumidor reclamante</h4>
                    <div class="mb-3">
                        <label for="nombres" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>
                    <div class="mb-3">
                        <label for="apellidos" class="form-label">Apellidos</label>
                        <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono Móvil</label>
                        <input type="text" class="form-control" id="telefono" name="telefono" required>
                    </div>
                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento de identidad</label>
                        <input type="text" class="form-control" id="documento" name="documento" required>
                    </div>
                    <div class="mb-3">
                        <label for="domicilio" class="form-label">Domicilio</label>
                        <input type="text" class="form-control" id="domicilio" name="domicilio" required>
                    </div>
                    <div class="mb-3">
                        <label for="codestudiante" class="form-label">Codigo de estudiante</label>
                        <input type="text" class="form-control" id="codestudiante"  name="codestudiante" required>
                    </div>
                    <div class="mb-3">
                        <label for="facultad" class="form-label">facultad</label>
                        <select class="form-select" id="facultad" name="facultad" required>
                            <option selected disabled value="">Seleccione una facultad...</option>
                            <option value="1">Facultad de Ingenieria</option>
                            <option value="2">Facultad de Ciencias Sociales</option>
                        </select>
                    </div>
                </div>

                <!-- Identificación del bien contratado -->
                <div class="mb-4">
                    <h4>Identificación del bien contratado</h4>
                    <div class="mb-3">
                        <label class="form-label">Identificacion del bien contratado</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Producto" name="ibien" required>
                            <label class="form-check-label" for="producto">
                                Producto
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="Servicio" name="ibien" required>
                            <label class="form-check-label" for="servicio">
                                Servicio
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3 mt-3">
                        <label for="monto" class="form-label">Monto Reclamado</label>
                        <input type="text" class="form-control" id="monto" name="monto" required>
                    </div>
                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <select class="form-select" id="motivo" name="motivo" required>
                            <option selected disabled value="">Seleccione un motivo...</option>
                            <option value="1">Error administrativo</option>
                            <option value="2">Mal servicio</option>
                            <option value="3">Desacuerdo con nota</option>
                        </select>
                    </div>
                </div>

                <!-- Detalle de la reclamación -->
                <div class="mb-4">
                    <h4>Detalle de la reclamación</h4>
                    <div class = "mb-3">
                        <label class="form-label">Identificación de la reclamación</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="1" name="ireclamacion" required>
                            <label class="form-check-label" for="reclamo">
                                Reclamo
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" value="2" name="ireclamacion" required>
                            <label class="form-check-label" for="queja">
                                Queja
                            </label>
                        </div>
                    </div>
                        
                    <div class="mb-3 mt-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion" rows="5" name="descripcion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="fechaHora" class="form-label">Fecha/Hora</label>
                        <input type="datetime-local" class="form-control" id="fechaHora" name="fechaHora" required>
                    </div>
                    <div class="mb-3">
                        <label for="observacion" class="form-label">Observación</label>
                        <textarea class="form-control" id="observacion" rows="5" name="observacion" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="evidencia" class="form-label">Evidencia</label>
                        <input class="form-control" type="file" id="evidencia" name="evidencia" accept=".pdf,.doc,.docx,.jpg,.png">
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
