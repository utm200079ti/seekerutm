<?php
session_start();
// Habilitar el manejo de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

include 'conexion.php';

// Verificar si el usuario está autenticado y es del tipo correcto

if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(403); // Código de estado HTTP 403 (Prohibido)
    echo json_encode(["error" => "No tienes permisos para acceder a este recurso."]);
    header("Location: inicioSesion.html");
    exit();
}



// Recuperar el ID del usuario desde la sesión
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];


// Validar conexión
if (!$conn) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos.']);
    exit();
}

// Leer el contenido de la solicitud
$data = json_decode(file_get_contents('php://input'), true);

// Validar que se envió el ID de la vacante
if (!isset($data['id_vacante'])) {
    echo json_encode(['success' => false, 'message' => 'No se proporcionó el ID de la vacante.']);
    exit();
}

// ID de la vacante y usuario (asegúrate de tener la sesión del usuario activa)
$id_vacante = $data['id_vacante'];
$user_id = $_SESSION['user_id'];

// Insertar la postulación en la base de datos
$sql = "INSERT INTO postulaciones (id_usuario, id_vacante, fecha_postulacion) VALUES (?, ?, NOW())";

$stmt = $conn->prepare($sql);
if ($stmt) {
    $stmt->bind_param('ii', $user_id, $id_vacante);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Postulación registrada correctamente.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al registrar la postulación: ' . $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
}

$conn->close();
?>
