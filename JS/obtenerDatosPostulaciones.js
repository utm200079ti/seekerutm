document.addEventListener("DOMContentLoaded", () => {
    let postulaciones = [];
    const postList = document.getElementById("postList");
    const vacanteDetail = document.getElementById("vacanteDetail");

    // Función para renderizar la lista de postulaciones
    const renderverPost = (postulaciones) => {
        postList.innerHTML = ""; // Limpiar la lista antes de renderizar
        postulaciones.forEach((post) => {
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            listItem.innerHTML = `
                <h5>${post.vacante_titulo}</h5>
                <p><strong>Empresa:</strong> ${post.empresa_nombre}</p>
                <p><strong>Estado:</strong> ${post.vacante_estado}</p>
                <button class="btn btn-primary btn-sm" onclick="verPost(${post.postulacion_id})">Ver Detalles</button>
            `;
            postList.appendChild(listItem);
        });
    };

    // Función para mostrar detalles de una postulación
    const verPost = (id) => {
        const postulacion = postulaciones.find((p) => p.postulacion_id === id);

        if (!postulacion) {
            alert("Postulación no encontrada.");
            return;
        }

        vacanteDetail.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${postulacion.vacante_titulo} - ${postulacion.empresa_nombre}</h5>
                <p><strong>Descripción:</strong> ${postulacion.vacante_descripcion}</p>
                <p><strong>Programa:</strong> ${postulacion.vacante_programa}</p>
                <p><strong>Sector:</strong> ${postulacion.vacante_sector}</p>
                <p><strong>Requisitos:</strong> ${postulacion.vacante_requisitos}</p>
                <p><strong>Ubicación:</strong> ${postulacion.vacante_ubicacion}</p>
                <p><strong>Duración:</strong> ${postulacion.vacantes_duracion}</p>
                <p><strong>Estado:</strong> ${postulacion.vacante_estado}</p>
                <p><strong>Fecha de Publicación:</strong> ${postulacion.vacante_publicacion}</p>
                <hr>
                <p><strong>Empresa:</strong> ${postulacion.empresa_nombre}</p>
                <p><strong>RFC:</strong> ${postulacion.empresa_rfc}</p>
                <p><strong>Domicilio:</strong> ${postulacion.empresa_domicilio}</p>
                <p><strong>Teléfono:</strong> ${postulacion.empresa_telefono}</p>
            </div>
        `;
    };

    // Fetch de los datos desde PHP
    fetch("../PHP/obtenerDatosPostulaciones.php")
        .then((response) => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then((data) => {
            if (data.error) {
                console.error("Error recibido del servidor:", data.error);
            } else {
                postulaciones = data; // Guardar los datos en la variable global
                renderverPost(postulaciones); // Renderizar la lista de postulaciones
            }
        })
        .catch((error) => {
            console.error("Error al obtener los datos:", error);
        });

    // Exponer la función verPost al ámbito global
    window.verPost = verPost;
});
