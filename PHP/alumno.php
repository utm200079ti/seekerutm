<?php include 'dataA.php'; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
      <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="../CSS/style.css">
</head>
</head>
<body>
    <?php include '../navara.html'?>
    
     <div class="container my-4">
    <h2 class="mb-4">Perfil Estudiante</h2>
    <div class="card">
      <div class="card-body">
      <div class="container my-4">
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($user_name); ?></h2>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_email); ?></p>

            <p><strong>Matricula:</strong> <?php echo $matricula; ?></p>
            <p><strong>Carrera:</strong> <?php echo $carrera; ?></p>

    <a href="../ediPeAl.html" class="btn btn-primary mt-3">Editar Perfil</a>
    <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
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

</html>