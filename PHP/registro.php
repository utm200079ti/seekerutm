<!DOCTYPE html>
<html lang="es">
<?php
// Incluye la conexión a la base de datos
require_once 'conexion.php';

// Verifica si el formulario se envió
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Datos comunes
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $numero = $_POST['numero'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashea la contraseña
    //$tipoUsuario = $_POST['tipoUsuario'];
 	$tipoUsuario = isset($_POST['tipoUsuario']) ? $_POST['tipoUsuario'] : null;

    // Inicia una transacción para garantizar la consistencia de los datos
    $conn->begin_transaction();

    try {
        // Inserta los datos básicos en la tabla `usuarios`
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, numero, password, tipo) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombre, $email, $numero, $password, $tipoUsuario);
        $stmt->execute();
        $idUsuario = $conn->insert_id; // Obtén el ID del usuario recién insertado
        $stmt->close();

        // Verifica el tipo de usuario para insertar datos adicionales
        if ($tipoUsuario == "estudiante") {
            $matricula = $_POST['matricula'];
            $carrera = $_POST['carrera'];

            // Inserta en la tabla `estudiantes`
            $stmt = $conn->prepare("INSERT INTO estudiantes (id, matricula, carrera) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $idUsuario, $matricula, $carrera);
            $stmt->execute();
            $stmt->close();
        } elseif ($tipoUsuario == "unidad_economica") {
            $nombreUnidad = $_POST['nomUE'];
            $rfc = $_POST['rfc'];
            $localidad = $_POST['localidad'];
            $domicilio = $_POST['domicilio'];
            $telefono = $_POST['telefono'];
            $programa = $_POST['programa'];

            // Inserta en la tabla `unidades_economicas`
            $stmt = $conn->prepare("INSERT INTO unidades_economicas (id, nombre_unidad, rfc, localidad, domicilio, telefono, programa) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $idUsuario, $nombreUnidad, $rfc, $localidad, $domicilio, $telefono, $programa);
            $stmt->execute();
            $stmt->close();
        }

        // Si todo se ejecuta correctamente, confirma la transacción
   // Si todo se ejecuta correctamente, confirma la transacción
   $conn->commit();
   echo '<script type="text/javascript">';
   echo 'alert("Registro exitoso");';
   echo 'window.location.href = "../inicioSesion.html";';
   echo '</script>';
   } catch (Exception $e) {
   // Si hay un error, revierte la transacción
   $conn->rollback();
   echo '<script type="text/javascript">';
   echo 'alert("Error al registrar: ' . $e->getMessage() . '");';
   echo 'window.location.href = "../Registrarse.html";';
   echo '</script>';
   }
   }
?>
</html>
