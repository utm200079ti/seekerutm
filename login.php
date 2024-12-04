<?php
session_start();
include 'conexion.php'; // Archivo con la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar usuario en la base de datos
    $query = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verificar contraseña
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_name'] = $user['nombre']; // Supongamos que tienes un campo `nombre`
            $_SESSION['user_type'] = $user['tipo'];

            // Redirigir según el tipo de usuario
            if ($user['tipo'] === 'unidad_economica') {
                header("Location: empresa.php");
                exit();
            } elseif ($user['tipo'] === 'estudiante') {
                header("Location: alumno.php");
                exit();
            }
        } else {
            echo "<script>alert('Contraseña incorrecta'); window.location.href = 'inicioSesion.html';</script>";
        }
    } else {
        echo "<script>alert('Usuario no encontrado'); window.location.href = 'inicioSesion.html';</script>";
    }
} else {
    header("Location: inicioSesion.html");
    exit();
}
?>
