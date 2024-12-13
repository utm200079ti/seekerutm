<?php
session_start();

include '../PHP/conexion.php';

// Verificar si el usuario está autenticado y es del tipo correcto
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(403); // Código de estado HTTP 403 (Prohibido)
    echo json_encode(["error" => "No tienes permisos para acceder a este recurso."]);
    header("Location: /InicioSesion.html");
    exit();
}

// Recuperar el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Realizar la consulta a la base de datos
try {
    // Consulta SQL para obtener los datos del curriculum del usuario
    $stmt = $conn->prepare("SELECT * FROM curriculum_vitae WHERE id_usuario = ?");
    $stmt->bind_param("i", $user_id); // Bind de parámetro para evitar SQL Injection
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();
    $curriculum = $result->fetch_assoc();

    // Verificar si se encontró el curriculum
    if ($curriculum) {
        // Asignar los valores a las variables
        $resumen = htmlspecialchars($curriculum['resumen']);
        $titulo = htmlspecialchars($curriculum['titulo']);
        $institucion = htmlspecialchars($curriculum['institucion']);
        $logros_academicos = htmlspecialchars($curriculum['logros_academicos']);
        $idiomas = htmlspecialchars($curriculum['idiomas']);
        $herramientas = htmlspecialchars($curriculum['herramientas']);
        $habilidades_interpersonales = htmlspecialchars($curriculum['habilidades_interpersonales']);
    } else {
        $resumen = "Sin Datos";
        $titulo = "Sin Datos";
        $institucion = "Sin Datos";
        $logros_academicos = "Sin Datos";
        $idiomas = "Sin Datos";
        $herramientas = "Sin Datos";
        $habilidades_interpersonales = "Sin Datos";
    }
} catch (mysqli_sql_exception $e) {
    die("Error al recuperar el curriculum: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}
?>
