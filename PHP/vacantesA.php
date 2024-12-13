<?php include 'dataA.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
      <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="/CSS/Style.css">
</head>
</head>
<body>
    <?php include '../navara.html'?>
    <?php include '../ListaVacantes.html'?>
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
<script src = "/JS/obtenerDatosVaca.js"></script>
</html>