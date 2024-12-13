document.addEventListener("DOMContentLoaded", () => {
    let vacantes = [];
    const vacanteList = document.getElementById("postList");
    const vacanteDetail = document.getElementById("vacanteDetail");

    // Función para renderizar la lista de vacantes
    const renderVacantes = (vacantes) => {
        vacanteList.innerHTML = ""; // Limpiar la lista antes de renderizar
        vacantes.forEach((vacante) => {
            const listItem = document.createElement("li");
            listItem.classList.add("list-group-item");
            listItem.innerHTML = `
                <h5>${vacante.titulo_vacante}</h5>
                <p><strong>Programa:</strong> ${vacante.programa_vacante}</p>
                <button class="btn btn-primary btn-sm view-details-btn" data-id="${vacante.id_vacante}">
                    Ver Detalles
                </button>
            `;
            vacanteList.appendChild(listItem);
        });

        // Agregar eventos a los botones "Ver Detalles"
        document.querySelectorAll(".view-details-btn").forEach((button) => {
            button.addEventListener("click", (e) => {
                const id = parseInt(e.target.dataset.id, 10);
                verVacante(id);
            });
        });
    };

    // Función para mostrar detalles de una vacante
    const verVacante = (id) => {
        const vacante = vacantes.find((v) => v.id_vacante === id);

        if (!vacante) {
            alert("Vacante no encontrada.");
            return;
        }

        vacanteDetail.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${vacante.titulo_vacante}</h5>
                <p><strong>Descripción:</strong> ${vacante.descripcion_vacante}</p>
                <p><strong>Programa:</strong> ${vacante.programa_vacante}</p>
                <p><strong>Sector:</strong> ${vacante.sector_vacante || "No especificado"}</p>
                <p><strong>Requisitos:</strong> ${vacante.requisitos_vacante || "No especificado"}</p>
                <p><strong>Ubicación:</strong> ${vacante.ubicacion || "No especificada"}</p>
                <p><strong>Duración:</strong> ${vacante.duracion || "No especificada"}</p>
                <p><strong>Estado:</strong> ${vacante.estado_vacante || "No especificado"}</p>
                <button id="consultarBtn" class="btn btn-primary">
                    Ver Postulaciones
                </button>
            </div>
        `;

        // Asegúrate de que el botón exista antes de agregar el evento
        const consultarBtn = document.getElementById("consultarBtn");
        if (consultarBtn) {
            consultarBtn.addEventListener("click", () => {
                const vacanteId = vacante.id_vacante; // Obtener el ID de la vacante actual
                window.location.href = `../PHP/mostrarPostulaciones.php?id_vacante=${vacanteId}`;
            });
        }
    };

    


    // Fetch de los datos desde PHP
    const fetchVacantes = async () => {
        try {
            const response = await fetch("/PHP/obtenerDatosVaca.php");
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            if (data.error) {
                console.error("Error recibido del servidor:", data.error);
                return;
            }

            vacantes = data; // Guardar los datos en la variable global
            renderVacantes(vacantes); // Renderizar la lista de vacantes
        } catch (error) {
            console.error("Error al obtener los datos:", error);
        }
    };

    // Llamar a la función para obtener datos
    fetchVacantes();
});
