<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Postulaciones</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/CSS/style.css"></head>
<body>
<?php include '../navare.html'?>

<div class="container my-4">
        <h2 class="mb-4 text-center">Postulaciones</h2>
        <div class="row">
            <!-- Lista de postulaciones -->
            <div class="col-md-6">
                <h4 class="mb-3">Lista de Postulaciones</h4>
                <ul id="postulacionesLista" class="list-group">
                    <!-- Lista generada dinámicamente -->
                </ul>
            </div>
        </div>
</div>

    <?php include '../Footer.html'?>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            // Obtener el ID de la vacante desde la URL
            const urlParams = new URLSearchParams(window.location.search);
            const idVacante = urlParams.get("id_vacante");

            if (idVacante) {
                // Realizar la consulta mediante fetch
                fetch(`consultaPostulaciones.php?id_vacante=${idVacante}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Error en la respuesta del servidor.");
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }

                        // Llenar la tabla con los datos obtenidos
                        const postulacionesList = document.querySelector("#postulacionesLista");
postulacionesList.innerHTML = ""; // Limpiar cualquier contenido existente

data.forEach(postulacion => {
    const listItem = document.createElement("li");
    listItem.classList.add("postulacion-item"); // Puedes agregar una clase para estilizar los elementos

    listItem.innerHTML = `
        <h3>Postulación #${postulacion.id_postulacion}</h3>
        <ul>
            <li><strong>ID Vacante:</strong> ${postulacion.id_vacante}</li>
            <li><strong>Fecha de Postulación:</strong> ${postulacion.fecha_postulacion}</li>
            <li><strong>Nombre del Usuario:</strong> ${postulacion.nombre_usuario}</li>
            <li><strong>Email del Usuario:</strong> ${postulacion.email_usuario}</li>
            <li><strong>Teléfono del Usuario:</strong> ${postulacion.telefono_usuario}</li>
            <li><strong>Tipo de Usuario:</strong> ${postulacion.tipo_usuario}</li>
            <li><strong>Resumen CV:</strong> ${postulacion.resumen_cv}</li>
            <li><strong>Título CV:</strong> ${postulacion.titulo_cv}</li>
            <li><strong>Institución CV:</strong> ${postulacion.institucion_cv}</li>
            <li><strong>Logros Académicos:</strong> ${postulacion.logros_academicos_cv}</li>
            <li><strong>Idiomas:</strong> ${postulacion.idiomas_cv}</li>
            <li><strong>Herramientas:</strong> ${postulacion.herramientas_cv}</li>
            <li><strong>Habilidades Interpersonales:</strong> ${postulacion.habilidades_interpersonales_cv}</li>
        </ul>
    `;

    postulacionesList.appendChild(listItem);
});

                    })
                    .catch(error => {
                        console.error("Error al obtener los datos:", error);
                        alert("Error al obtener los datos. Por favor, inténtelo de nuevo más tarde.");
                    });
            } else {
                alert("ID de vacante no especificado.");
            }
        });
    </script>
</body>
</html>
