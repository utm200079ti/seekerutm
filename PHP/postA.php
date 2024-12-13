<?php include 'dataA.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
      <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="/CSS/style.css">
</head>
</head>
<body>
    <?php include '../navara.html'?>
    <header class="header">
        <h1>Postulaciones del Usuario</h1>
    </header>
    <!-- Main Content -->
    <div class="container my-4">
        <h1 class="mb-4">Postulaciones</h1>
        <div class="row">
            <div class="col-md-6">
                <ul id="postList" class="list-group">
                    <!-- Lista de postulaciones generada dinámicamente -->
                </ul>
            </div>
            <div class="col-md-6">
                <div id="vacanteDetail" class="card">
                    <!-- Detalles de la vacante generados dinámicamente -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../Footer.html' ?> 
     
</body>
<script src="../JS/bootstrap.bundle.min.js"></script>
      <script src="../JS/obtenerDatosPostulaciones.js"></script>

<script>
        // Registrar el Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('../ServiceWorker.js')
                .then(registration => {
                    console.log('Service Worker registrado con éxito:', registration.scope);
                })
                .catch(error => {
                    console.error('Error al registrar el Service Worker:', error);
                });
        }
    </script>

    </html>
