<?php
session_start();

include '../PHP/conexion.php';

// Verificar si el usuario está autenticado y es del tipo correcto

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(403); // Código de estado HTTP 403 (Prohibido)
    echo json_encode(["error" => "No tienes permisos para acceder a este recurso."]);
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
    $stmt = $conn->prepare("SELECT * FROM estudiantes WHERE id = ?");
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