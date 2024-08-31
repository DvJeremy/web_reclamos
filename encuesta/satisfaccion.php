<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <div class="container card border shadow p-3 mb-5 bg-body-tertiary rounded mt-5">
        <form action="/encuesta/enviarEncuesta.php" method="post">
            <div class="row">
              <h3 class="card-title text-center mb-4 text-orange">Formulario de Satisfacción</h3>
              <div class="col-md-6">
                   
                 <label class="form-label"  for="">1. ¿Cómo se siente con el proceso de reclamo?</label>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="nivel" value="Nada Satisfecho" id="flexRadioDefault1">
                     <label class="form-check-label" for="flexRadioDefault1">
                        Nada Satisfecho
                     </label>
                  </div>
                  <div class="form-check ">
                     <input class="form-check-input" type="radio" name="nivel" value="Poco Satisfecho" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                        Poco Satisfecho
                     </label>
                  </div>
                  <div class="form-check ">
                     <input class="form-check-input" type="radio" name="nivel" value="Neutral" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                        Neutral
                     </label>
                  </div>
                  <div class="form-check ">
                     <input class="form-check-input" type="radio" name="nivel" value="Muy Satisfecho" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                        Muy Satisfecho
                     </label>
                  </div>
                  <div class="form-check mb-3">
                     <input class="form-check-input" type="radio" name="nivel" value="Totalmente Satisfecho" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                        Totalmente satisfecho
                     </label>
                  </div>

                  </div>
                  <label class="form-label"  for="">2. ¿Tuvo alguna dificultad al presentar su reclamo?</label>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="dificultad" value="Si" id="flexRadioDefault2" >
                     <label class="form-check-label" for="flexRadioDefault2">
                      Si
                     </label>
                  </div>
                  <div class="form-check mb-3">
                     <input class="form-check-input" type="radio" name="dificultad" value="No" id="flexRadioDefault2" >
                     <label class="form-check-label" for="flexRadioDefault2">
                        No
                     </label>
                  </div>
            
                  <label class="form-label"  for="">3. ¿Su problema fue resuelto efectivamente?</label>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="resuelto" value="Si" id="flexRadioDefault2" >
                     <label class="form-check-label" for="flexRadioDefault2">
                      Si
                     </label>
                  </div>
                  <div class="form-check mb-3">
                     <input class="form-check-input" type="radio" name="resuelto" value="No" id="flexRadioDefault2" >
                     <label class="form-check-label" for="flexRadioDefault2">
                        No
                     </label>
                  </div>
                  <div class="form-floating mb-3">
                     <input class="form-control" type="number" name="tiempo" id="campo_nombre" placeholder="Escribe el tiempo en días" min="0" step="1">
                     <label class="form-label" for="campo_nombre">4. Tiempo en días que tardó en resolverse el reclamo</label>
                  </div>
             </div>

                <div class="col-md-6">
                  <label class="form-label"  for="">5. ¿Le mantuvieron informado(a) durante el proceso de resolución de su reclamo?</label>
                  <div class="form-check">
                     <input class="form-check-input" type="radio" name="informado" value="Si" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                      Si
                     </label>
                  </div>
                  <div class="form-check mb-3">
                     <input class="form-check-input" type="radio" name="informado" value="No" id="flexRadioDefault2">
                     <label class="form-check-label" for="flexRadioDefault2">
                        No
                     </label>
                  </div>
                    <label class="form-label"  for="campo_nombre">6. Comentario / Sugerencia de mejora</label>
                    <textarea col="20" rows="6" class="form-control" name="comentario"></textarea>
                    <div class="col-md-4 offset-md-4 text-center">
                       <button class="btn btn-success btn-lg mt-5" type="submit">Enviar</button>
                    </div>
                 </div>

               
           
            </div>

         </form>
    </div>
     
</body>
</html>