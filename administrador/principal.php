<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../layouts/navbaradmin.php'; ?>
    
    <div class="container mt-5">
        <div id="dynamic-content">
            <!-- Aquí se cargará el contenido dinámico -->
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function(){
            // Cargar contenido inicial
            $("#dynamic-content").load("solicitudes.php");

            // Evento para manejar los clics en los enlaces de la navbar
            $(".nav-link").click(function(e){
                e.preventDefault(); // Prevenir la recarga de la página
                var targetPage = $(this).data('target');
                $("#dynamic-content").load("../" + targetPage);
            });
        });
    </script>
    <?php include '../layouts/footer.php'; ?>
</body>
</html>

