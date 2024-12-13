<?php include '../PHP/dataAcv.php'; ?>
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
     <div class="container my-4">
    <h2 class="mb-4">Perfil Estudiante</h2>
    <div class="card">
      <div class="card-body">
      <div class="container my-4">
    <h2 class="mb-4">Mi Curriculum, <?php echo htmlspecialchars($user_name); ?></h2>

    <p><strong>Resumen Profesional o Objetivo:</strong> <?php echo $resumen; ?></p>
    <p><strong>Título o Grado Obtenido:</strong> <?php echo $titulo; ?></p>
    <p><strong>Instituciones Educativas:</strong> <?php echo $institucion; ?></p>
    <p><strong>Distinciones o Logros Académicos:</strong> <?php echo $logros_academicos; ?></p>
    <p><strong>Idiomas (con nivel de dominio):</strong> <?php echo $idiomas; ?></p>
    <p><strong>Herramientas y Software Específicos:</strong> <?php echo $herramientas; ?></p>
    <p><strong>Habilidades Interpersonales:</strong> <?php echo $habilidades_interpersonales; ?></p>

    <a href="../cv.html" class="btn btn-primary mt-3">Editar Curriculum</a>
    
  </div>
    <?php include '../Footer.html' ?> 
</body>
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
      <script src="../JS/bootstrap.bundle.min.js"></script>
      <script src="../JS/obtenerDatosPostulaciones.js"></script>

</html>