<?php
// Asumimos que ya has iniciado sesión y que el usuario está autenticado
session_start();
include '../PHP/conexion.php'; // Asegúrate de tener correctamente configurada la conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: /InicioSesion.html");
    exit();
}

// Recuperar el ID del usuario desde la sesión
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Realizar la consulta a la base de datos
try {
    // Consulta SQL para obtener los datos de la empresa asociada al usuario
    $stmt = $conn->prepare("SELECT * FROM unidades_economicas WHERE id = ?");
    $stmt->bind_param("i", $user_id); // Bind de parámetro para evitar SQL Injection
    $stmt->execute();

    // Obtener los resultados
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();

    // Verificar si se encontró la empresa
    if ($empresa) {
        // Asignar los valores a las variables
        $nombreUnidad = htmlspecialchars($empresa['nombre_unidad']);
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

