<?php
// Habilitar el manejo de errores
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Configurar las cabeceras para devolver JSON
header('Content-Type: application/json; charset=utf-8');

// Iniciar la sesión
session_start();
include 'conexion.php'; // Conexión a la base de datos

// Validar sesión de usuario
if (!isset($_SESSION['user_id']) || empty($_SESSION['user_id'])) {
    http_response_code(403); // Código HTTP 403 (Prohibido)
    echo json_encode(["error" => "No tienes permisos para acceder a este recurso."]);
    exit();
}

// Recuperar el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];

// Validar conexión con la base de datos
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Conexión a la base de datos fallida."]);
    exit();
}

try {
    // Consulta SQL
    $sql = "SELECT * FROM `vacantes` WHERE id_ue= ?;";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        throw new Exception("Error al preparar la consulta: " . $conn->error);
    }

    // Vincular parámetros
    $stmt->bind_param("i", $user_id);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        // Crear un arreglo para almacenar los resultados
        $vacantes = [];

        // Recorrer los resultados y agregarlos al arreglo
        while ($row = $result->fetch_assoc()) {
            $vacantes[] = $row;
        }

        // Devolver los datos como JSON
        echo json_encode($vacantes);
    } else {
        echo json_encode(["error" => "No se encontraron registros."]);
    }

    // Cerrar el statement
    $stmt->close();
} catch (Exception $e) {
    // Manejar errores de la consulta
    http_response_code(500);
    error_log("Error en la consulta: " . $e->getMessage()); // Registro en log
    echo json_encode(["error" => "Error al obtener los datos: " . $e->getMessage()]);
}


?>

