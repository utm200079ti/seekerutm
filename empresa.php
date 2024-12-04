<?php
// Asumimos que ya has iniciado sesión y que el usuario está autenticado
session_start();
include 'conexion.php'; // Asegúrate de tener correctamente configurada la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: inicioSesion.html");
    exit();
}

// Recuperar el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Realizar la consulta a la base de datos
try {
    // Consulta SQL para obtener los datos de la empresa asociada al usuario
    $stmt = $conn->prepare("SELECT rfc, localidad, domicilio, telefono, programa FROM unidades_economicas WHERE id = ?");
    $stmt->bind_param("i", $user_id); // Bind de parámetro para evitar SQL Injection
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();

    // Verificar si se encontró la empresa
    if ($empresa) {
        // Asignar los valores a las variables
        $rfc = htmlspecialchars($empresa['rfc']);
        $localidad = htmlspecialchars($empresa['localidad']);
        $domicilio = htmlspecialchars($empresa['domicilio']);
        $telefono = htmlspecialchars($empresa['telefono']);
        $programa = htmlspecialchars($empresa['programa']);
    } else {
        throw new Exception("Empresa no encontrada.");
    }
} catch (mysqli_sql_exception $e) {
    die("Error al recuperar la empresa: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Perfil Empresa</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="style.css"></head>
 <!-- Header -->
  <header class="bg-primary">
    <nav class="navbar navbar-expand-lg navbar-light">
      <div class="container-fluid">
        <a class="navbar-brand" href="#">
          <img src="img/SEEKUTM.png" alt="Logo" class="header-logo">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <a class="nav-link active" href="index.html">Inicio</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Nosotros.html">Nosotros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="Contactanos.html">Contactanos</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="ListaVacantes.html">Vacantes</a>
            </li>
          </ul>
          <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Buscar" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Buscar</button>
          </form>
          <ul class="navbar-nav ms-3">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Cuenta
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="InicioSesion.html">Iniciar Sesión</a></li>
                <li><a class="dropdown-item" href="Registrarse.html">Registrarse</a></li>
                <li><a class="dropdown-item" href="PerfilEstudiante.html">Perfil Estudiante</a></li>
                <li><a class="dropdown-item" href="PerfilEmpresa.html">Perfil Empresa</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Cerrar Sesión</a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </header>

  <!-- Perfil de la Empresa -->
  <div class="container my-4">
    <h2 class="mb-4">Perfil Empresa</h2>
    <div class="card">
      <div class="card-body">
      <div class="container my-4">
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($user_name); ?></h2>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_email); ?></p>
    <p><strong>RFC:</strong> <?php echo $rfc; ?></p>
            <p><strong>Localidad:</strong> <?php echo $localidad; ?></p>
            <p><strong>Domicilio:</strong> <?php echo $domicilio; ?></p>
            <p><strong>Teléfono:</strong> <?php echo $telefono; ?></p>
            <p><strong>Programa:</strong> <?php echo $programa; ?></p>
      </div>
      <a href="Vacantes.html" class="btn btn-outline-secondary">Abrir Vacantes</a>
    </div>
    <button class="btn btn-primary mt-3">Editar Perfil</button>
    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
  </div>

  <footer class="text-center py-4">
    <div class="footer-links mb-3">
      <a href="#">Términos de Uso</a>
      <a href="#">Política de Privacidad</a>
      <a href="#">Accesibilidad</a>
    </div>
    <div class="social-icons">
      <a href="#"><img src="img/facebook.png" alt="Facebook"></a>
      <a href="#"><img src="img/Instagram.png" alt="Twitter"></a>
      <a href="#"><img src="img/Tiktok.png" alt="Instagram"></a>
    </div>
    <p>&copy; 2024 Plataforma Estadías. Todos los derechos reservados.</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
