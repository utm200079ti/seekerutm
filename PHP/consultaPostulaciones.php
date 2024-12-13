<?php
include 'dataE.php'; // Corrección: Se agrega el punto y coma
// Recuperar el ID de la vacante desde la URL
if (!isset($_GET['id_vacante']) || empty($_GET['id_vacante'])) {
    http_response_code(400); // Código HTTP 400 (Bad Request)
    echo json_encode(["error" => "Falta el ID de la vacante."]);
    exit();
}

$id_vacante = $_GET['id_vacante'];

// Validar conexión con la base de datos
if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Conexión a la base de datos fallida."]);
    exit();
}

try {
    // Consulta SQL
    $sql = "SELECT * FROM vista_postulaciones WHERE id_vacante = ?";

    // Preparar la consulta
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        error_log("Error al preparar la consulta: " . $conn->error);
        throw new Exception("Error al preparar la consulta.");
    }

    // Vincular parámetros
    $stmt->bind_param("i", $id_vacante);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener el resultado
    $result = $stmt->get_result();

    // Verificar si hay resultados
    if ($result->num_rows > 0) {
        $postulaciones = [];
        while ($row = $result->fetch_assoc()) {
            $postulaciones[] = $row;
        }
        echo json_encode($postulaciones);
    } else {
        error_log("No se encontraron postulaciones para id_vacante: $id_vacante");
        echo json_encode(["error" => "No se encontraron postulaciones."]);
    }

    // Cerrar el statement
    $stmt->close();
} catch (Exception $e) {
    error_log("Error general: " . $e->getMessage());
    http_response_code(500);
    echo json_encode(["error" => "Error al obtener los datos."]);
}


?>

