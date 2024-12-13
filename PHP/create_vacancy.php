<?php
session_start();
include '../PHP/conexion.php'; // Archivo con la conexión a la base de datos

// Verificar si el usuario está autenticado y es del tipo correcto
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'unidad_economica') {
    header("Location: ../InicioSesion.html");
    exit();
}

// Recuperar datos del usuario desde la sesión
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];

// Recuperar el id de la empresa asociada al usuario
try {


    // Asumimos que $conn es la conexión ya establecida en 'conexion.php'
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE nombre = ?");
    $stmt->bind_param("s", $user_name); // Bind de parámetro para evitar SQL Injection
    $stmt->execute();

    // Verificar si la consulta devolvió resultados
    $result = $stmt->get_result();
    $empresa = $result->fetch_assoc();  // En MySQLi, usamos fetch_assoc()

    if ($empresa) {
        $id_empresa = $empresa['id']; // Obtener el id de la empresa
    } else {
        throw new Exception("Empresa no encontrada.");
    }
} catch (mysqli_sql_exception $e) {
    die("Error al recuperar la empresa: " . $e->getMessage());
} catch (Exception $e) {
    die($e->getMessage());
}


     // Captura los datos del formulario
     $titulo = $_POST['titulo'];
     $descripcion = $_POST['descripcion'];
     $requisitos = $_POST['requisitos'];
     $sector = $_POST['sector'];
     $programa = $_POST['programa'];
     $estado = 'abierta'; // El estado siempre es 'abierta' en este caso

var_dump($titulo, $descripcion, $requisitos, $sector, $programa, $estado);
try{

// Consulta SQL con los 7 parámetros
$sql = "INSERT INTO vacantes (id_ue, titulo_vacante, descripcion_vacante, requisitos_vacante, sector_vacante, programa_vacante, estado_vacante) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

// Enlazar los parámetros con el tipo adecuado
$stmt->bind_param('issssss', $id_empresa, $titulo, $descripcion, $requisitos, $sector, $programa, $estado);

// Ejecutar la consulta
$stmt->execute();


    // Mensaje de éxito
    echo "Vacante registrada con éxito.";
    echo '<script type="text/javascript">';
    echo 'alert("Registro exitoso");';
    echo 'window.location.href = "../PHP/empresa.php";';
    echo '</script>';
    // Redirigir o mostrar mensaje adicional si lo deseas
    // header('Location: lista_vacantes.php');
} catch (mysqli_sql_exception $e) {
    echo '<script type="text/javascript">';
    echo 'alert("Error al registrar: ' . $e->getMessage() . '");';
    echo 'window.location.href = "../PHP/vacantes.php";';
    echo '</script>';
}

?>