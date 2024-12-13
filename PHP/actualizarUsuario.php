<?php
// Asumimos que ya has iniciado sesión
session_start();
include '../PHP/conexion.php'; // Conexión a la base de datos

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: /InicioSesion.html");
    exit();
}

// Obtener el ID del usuario autenticado
$userId = $_SESSION['user_id'];

// Consulta para obtener el tipo de usuario
try {
    $stmt = $conn->prepare("SELECT tipo FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $tipoUsuario = $row['tipo'];
    }
    $stmt->close();
} catch (Exception $e) {
    echo "Error al obtener el tipo de usuario: " . $e->getMessage();
}

// Verifica si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos comunes
    $userId = $_SESSION['user_id']; // ID del usuario autenticado
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_BCRYPT) : null; // Hashea la contraseña solo si se proporciona
   

    // Inicia una transacción para garantizar la consistencia de los datos
    $conn->begin_transaction();

    try {
        // Actualiza los datos básicos en la tabla `usuarios`
        if ($password) {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, numero = ?, password = ?, tipo = ? WHERE id = ?");
            $stmt->bind_param("sssssi", $nombre, $email, $numero, $password, $tipoUsuario, $userId);
        } else {
            $stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, numero = ?, tipo = ? WHERE id = ?");
            $stmt->bind_param("sssii", $nombre, $email, $numero, $tipoUsuario, $userId);
        }
        $stmt->execute();
        $stmt->close();

        // Verifica el tipo de usuario para actualizar datos adicionales
        if ($tipoUsuario == "estudiante") {
            $matricula = $_POST['matricula'];
            $carrera = $_POST['carrera'];

            // Actualiza la tabla `estudiantes`
            $stmt = $conn->prepare("UPDATE estudiantes SET matricula = ?, carrera = ? WHERE id = ?");
            $stmt->bind_param("ssi", $matricula, $carrera, $userId);
            $stmt->execute();
            $stmt->close();
        } elseif ($tipoUsuario == "unidad_economica") {
            $nombreUnidad = $_POST['nomUE'];
            $rfc = $_POST['rfc'];
            $localidad = $_POST['localidad'];
            $domicilio = $_POST['domicilio'];
            $telefono = $_POST['telefono'];
            $programa = $_POST['programa'];

            // Actualiza la tabla `unidades_economicas`
            $stmt = $conn->prepare("UPDATE unidades_economicas SET nombre_unidad = ?, rfc = ?, localidad = ?, domicilio = ?, telefono = ?, programa = ? WHERE id = ?");
            $stmt->bind_param("ssssssi", $nombreUnidad, $rfc, $localidad, $domicilio, $telefono, $programa, $userId);
            $stmt->execute();
            $stmt->close();
        }

// Si todo se ejecuta correctamente, confirma la transacción
$conn->commit();

// Redirige según el tipo de usuario
if ($tipoUsuario == "estudiante") {
    echo '<script type="text/javascript">';
    echo 'alert("Actualización exitosa. Cierre e inicie sesion para refeljar cambios");';
    echo 'window.location.href = "../PHP/alumno.php";'; // Redirección para estudiantes
    echo '</script>';
} elseif ($tipoUsuario == "unidad_economica") {
    echo '<script type="text/javascript">';
    echo 'alert("Actualización exitosa");';
    echo 'window.location.href = "../PHP/empresa.php";'; // Redirección para unidades económicas
    echo '</script>';
}
} catch (Exception $e) {
    // Si hay un error, revierte la transacción
    $conn->rollback();

    // Obtén la URL de la página anterior
    $referer = $_SERVER['HTTP_REFERER'];

    echo '<script type="text/javascript">';
    echo 'alert("Error al actualizar: ' . $e->getMessage() . '");';
    echo 'window.location.href = "' . htmlspecialchars($referer) . '";'; // Redirección a la página anterior
    echo '</script>';
}

}
?>