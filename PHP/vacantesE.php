<?php include 'dataE.php'?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mis Vacantes</title>
  <link href="../CSS/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
  
<?php include '../navare.html';?>

<div class="container my-4">
        <h2 class="mb-4 text-center">Mis Vacantes</h2>
        <div class="row">
            <!-- Lista de postulaciones -->
            <div class="col-md-6">
                <h4 class="mb-3">Lista de Postulaciones</h4>
                <ul id="postList" class="list-group">
                    <!-- Lista generada dinámicamente -->
                </ul>
            </div>
            <!-- Detalles de la vacante -->
            <div class="col-md-6">
                <h4 class="mb-3">Detalles de la Vacante</h4>
                <div id="vacanteDetail" class="card">
                    <!-- Detalles generados dinámicamente -->
                </div>
            </div>
        </div>
    </div>

 <?php include '../Footer.html'?>


  <script src="../JS/bootstrap.bundle.min.js"></script>
<script src = "../JS/obtenerDatosVaca.js"></script>
</body>
</html>