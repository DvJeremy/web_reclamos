<?php
 
 error_reporting(E_ALL);
ini_set('display_errors', 1);
 
 
 
  $host="localhost";
  $nombre="reclamos";
  $usuario="root";
  $contra="";

  $conexion=mysqli_connect($host,$usuario,$contra,$nombre)or die("Error de conexion");

  if(isset($_POST['nivel']) && isset($_POST['dificultad']) && isset($_POST['resuelto'])
  && isset($_POST['tiempo'])&& isset($_POST['informado']) && isset($_POST['comentario'])){
      
      
    $nivel=$_POST['nivel'];
    $dificultad=$_POST['dificultad'];
    $resuelto=$_POST['resuelto'];
    $tiempo=$_POST['tiempo'];
    $informado=$_POST['informado'];
    $comentario=$_POST['comentario'];	   	   
    $consulta="INSERT INTO formulario(idForm,calificacion,tiempoRespuesta,resuelto,dificultad,sugerenciasMejora,informado) VALUES(null,'$nivel','$tiempo','$resuelto','$dificultad','$comentario','$informado')";
    $resultado=mysqli_query($conexion,$consulta) or die("Error de registro");   
    
    header("location: satisfaccion.php");
  }

