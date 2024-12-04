<?php
session_start();

include 'conexion.php';

// Verificar si el usuario está autenticado y es del tipo correcto
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'estudiante') {
    header("Location: inicioSesion.html");
    exit();
}


// Recuperar el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Realizar la consulta a la base de datos
try {
    // Consulta SQL para obtener los datos del alumno asociada al usuario
    $stmt = $conn->prepare("SELECT matricula, carrera FROM estudiantes WHERE id = ?");
    $stmt->bind_param("i", $user_id); // Bind de parámetro para evitar SQL Injection
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();
    $alumno = $result->fetch_assoc();

    // Verificar si se encontró la empresa
    if ($alumno) {
        // Asignar los valores a las variables
        $matricula = htmlspecialchars($alumno ['matricula']);
        $carrera = htmlspecialchars($alumno ['carrera']);;
    } else {
        throw new Exception("Empresa no encontrada.");
    }
} catch (mysqli_sql_exception $e) {
    die("Error al recuperar la empresa: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Estudiante</title>
</head>
<body>
     <div class="container my-4">
    <h2 class="mb-4">Perfil Estudiante</h2>
    <div class="card">
      <div class="card-body">
      <div class="container my-4">
    <h2 class="mb-4">Bienvenido, <?php echo htmlspecialchars($user_name); ?></h2>
    <p><strong>Correo:</strong> <?php echo htmlspecialchars($user_email); ?></p>
            <p><strong>Matricula:</strong> <?php echo $matricula; ?></p>
            <p><strong>Carrera:</strong> <?php echo $carrera; ?></p>
         
      </div>
      <a href="Vacantes.html" class="btn btn-outline-secondary">Abrir Vacantes</a>
    </div>
    <button class="btn btn-primary mt-3">Editar Perfil</button>
    <a href="logout.php" class="btn btn-danger">Cerrar Sesión</a>
  </div>

  <?php include 'ListaVacantes.html'; ?>


</body>
<script>
        // Registrar el Service Worker
        if ('serviceWorker' in navigator) {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('Service Worker registrado con éxito:', registration.scope);
                })
                .catch(error => {
                    console.error('Error al registrar el Service Worker:', error);
                });
        }
    </script>
</html>