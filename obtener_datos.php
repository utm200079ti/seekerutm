<?php
// Datos de conexión
$host = 'localhost';
$db = 'tu_base_de_datos';
$user = 'tu_usuario';
$password = 'tu_contraseña';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta a la base de datos
    $sql = "SELECT id_vacante, titulo_vacante, descripcion_vacante, programa_vacante, sector_vacante FROM vacantes";
    $stmt = $conn->prepare($sql);
    $stmt->execute();

    // Obtener resultados
    $vacantes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retornar datos en JSON
    header('Content-Type: application/json');
    echo json_encode($vacantes);
} catch (PDOException $e) {
    echo json_encode(["error" => $e->getMessage()]);
}
?>
