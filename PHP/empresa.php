<?php include '../PHP/dataE.php' ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Empresa</title>
    <link rel="stylesheet" href="../CSS/bootstrap.min.css">
  <link rel="stylesheet" href="/CSS/style.css">
</head>
<body>
  
 <?php include '../navare.html'?>
  <!-- Titulo de la paguina  -->
<div class="container my-4">
<div class="container my-4">
  <h2 class="mb-4">Perfil Empresa</h2>
  <div class="container my-4">
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($user_name); ?></h2>
  </div>
</div>

<div class="row">
  <!-- Lista infromacion del perfil -->
      <div class="col-md-6">
        <h3>Detalles del Perfil</h3>
        <div style="max-height: 500px; overflow-y: auto;">
        <p><strong>Nombre de la empresa: </strong> <?php echo $nombreUnidad; ?></p>
        <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_email); ?></p>
        <p><strong>RFC:</strong> <?php echo $rfc; ?></p>
        <p><strong>Localidad:</strong> <?php echo $localidad; ?></p>
        <p><strong>Domicilio:</strong> <?php echo $domicilio; ?></p>
        <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
        <p><strong>Programa:</strong> <?php echo $programa; ?></p>
      </div>
      <div> <a href="../Vacantes.html" class="btn btn-outline-secondary">Abrir Vacantes</a> </div>
      <a href="../ediPeEm.html" class="btn btn-primary mt-3">Editar Perfil</a>
      <a href="logout.php" class="btn btn-danger mt-3">Cerrar Sesión</a>
</div>

      
    </div>
  </div>


 <?php include '../Footer.html'?>

  <script src="../JS/bootstrap.bundle.min.js"></script>
</body>
</html>
