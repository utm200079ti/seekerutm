<?php
// Incluir archivo de conexión a la base de datos
include('conexion.php');

// Asumimos que ya has iniciado sesión
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: /InicioSesion.html");
    exit();
}

$id_usuario = $_SESSION['user_id'];  // Obtener el ID del usuario desde la sesión

// Obtener los datos del formulario
$resumen = $_POST['resumen'];
$titulo = $_POST['titulo'];
$institucion = $_POST['institucion'];
$logros_academicos = $_POST['logros_academicos'];
$idiomas = $_POST['idiomas'];
$herramientas = $_POST['herramientas'];
$habilidades_interpersonales = $_POST['habilidades_interpersonales'];

// Conectar a la base de datos
$conn = new mysqli($host, $user, $password, $db);

// Comprobar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Iniciar transacción
$conn->begin_transaction();

try {
    // Comprobar si ya existe un CV para el usuario
    $sql = "SELECT * FROM curriculum_vitae WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Si ya existe, realizar una actualización
        $sql_update = "UPDATE curriculum_vitae 
                       SET resumen = ?, titulo = ?, institucion = ?, logros_academicos = ?, idiomas = ?, herramientas = ?, habilidades_interpersonales = ? 
                       WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssssi", $resumen, $titulo, $institucion, $logros_academicos, $idiomas, $herramientas, $habilidades_interpersonales, $id_usuario);
        $stmt_update->execute();

        // Notificación y redirección
        echo '<script type="text/javascript">';
        echo 'alert("CV actualizado con éxito.");';
        echo 'window.location.href = "curriculum.php";';
        echo '</script>';
    } else {
        // Si no existe, realizar una inserción
        $sql_insert = "INSERT INTO curriculum_vitae (id_usuario, resumen, titulo, institucion, logros_academicos, idiomas, herramientas, habilidades_interpersonales) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("isssssss", $id_usuario, $resumen, $titulo, $institucion, $logros_academicos, $idiomas, $herramientas, $habilidades_interpersonales);
        $stmt_insert->execute();

        // Notificación y redirección
        echo '<script type="text/javascript">';
        echo 'alert("CV creado con éxito.");';
        echo 'window.location.href = "curriculum.php";';
        echo '</script>';
    }

    // Commit de la transacción
    $conn->commit();

} catch (Exception $e) {
    // Si hay un error, revierte la transacción
    $conn->rollback();
    echo '<script type="text/javascript">';
    echo 'alert("Error al registrar: ' . $e->getMessage() . '");';
    echo 'window.location.href = "curriculum.php";';
    echo '</script>';
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>
