// Obtener y procesar vacantes desde el servidor
fetch('../PHP/obtenerDatosVacantes.php')
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos recibidos:', data);
        procesarVacantes(data); // Llamada a la función para procesar los datos
    })
    .catch(error => {
        console.error('Error al obtener los datos:', error);
    });

// Definir la función procesarVacantes
let vacantes = []; // Array donde almacenaremos las vacantes

const procesarVacantes = (data) => {
    vacantes = data; // Guardamos las vacantes en la variable global vacantes
    renderVacantes(vacantes); // Renderizamos las vacantes inicialmente

    // Generar las opciones de filtro con los datos cargados
    generarOpcionesFiltros(
        vacantes,
        ["empresa", "localidad", "sector", "programa"], // Claves para filtrar
        [empresaFilter, localidadFilter, sectorFilter, programaFilter] // Elementos select
    );
};

// Elementos DOM
const empresaFilter = document.getElementById("empresaFilter");
const localidadFilter = document.getElementById("localidadFilter");
const sectorFilter = document.getElementById("sectorFilter");
const programaFilter = document.getElementById("programaFilter");
const vacantesList = document.getElementById("vacantesList");
const applyFiltersButton = document.getElementById("applyFilters");

// Función para contar ocurrencias
const contarOcurrencias = (array, key) => {
    const counts = {};
    array.forEach(item => {
        counts[item[key]] = (counts[item[key]] || 0) + 1;
    });
    return counts;
};

// Función para generar opciones de filtro por múltiples claves
const generarOpcionesFiltros = (vacantes, keys, selectElements) => {
    keys.forEach((key, index) => {
        const counts = contarOcurrencias(vacantes, key); // Contar ocurrencias de cada clave
        const opciones = Object.keys(counts).map(value => {
            return { value, count: counts[value] };
        });

        // Limpiar el select actual
        selectElements[index].innerHTML = '<option value="">Todos</option>';

        // Generar opciones según las ocurrencias
        opciones.forEach(opcion => {
            if (opcion.count >= 4) {
                selectElements[index].innerHTML += `<option value="${opcion.value}">${opcion.value}</option>`;
            }
        });

        // Agregar opción "Otros"
        selectElements[index].innerHTML += '<option value="otros">Otros</option>';
    });
};

// Función para renderizar las vacantes filtradas
const renderVacantes = (vacantesFiltradas) => {
    vacantesList.innerHTML = "";
    if (vacantesFiltradas.length === 0) {
        vacantesList.innerHTML = "<p>No se encontraron vacantes con los filtros seleccionados.</p>";
        return;
    }

    vacantesFiltradas.forEach(vacante => {
        const vacanteItem = document.createElement("div");
        vacanteItem.classList.add("list-group-item");
        vacanteItem.innerHTML = `
            <h4>${vacante.titulo} - ${vacante.empresa}</h4>
            <p><strong>Localidad:</strong> ${vacante.localidad}</p>
            <p><strong>Programa:</strong> ${vacante.programa}</p>
            <p><strong>Fecha de Publicación:</strong> ${vacante.fecha_publicacion}</p>
            <p><strong>Estado:</strong> ${vacante.estado}</p>
            <button class="btn btn-info btn-sm me-2" onclick="verDetalles(${vacante.id})">Información</button>
        `;
        vacantesList.appendChild(vacanteItem);
    });
};

// Mostrar detalles de vacante
const verDetalles = (id) => {
    const vacante = vacantes.find((v) => v.id === id);
    vacanteDetail.innerHTML = `
        <h5>Empresa: ${vacante.empresa}</h5>
        <p><strong>RFC:</strong> ${vacante.rfc}</p>
        <p><strong>Localidad:</strong> ${vacante.localidad}</p>
        <p><strong>Domicilio:</strong> ${vacante.domicilio}</p>
        <p><strong>Teléfono:</strong> ${vacante.tel}</p>
        <hr>
        <h5>Detalles de la Vacante</h5>
        <p><strong>Título:</strong> ${vacante.titulo}</p>
        <p><strong>Descripción:</strong> ${vacante.descripcion}</p>
        <p><strong>Programa:</strong> ${vacante.programa}</p>
        <p><strong>Sector:</strong> ${vacante.sector}</p>
        <p><strong>Requisitos:</strong> ${vacante.requisitos}</p>
        <p><strong>Ubicación:</strong> ${vacante.ubicacion}</p>
        <p><strong>Duración:</strong> ${vacante.duracion}</p>
        <p><strong>Fecha de Publicación:</strong> ${vacante.fecha_publicacion}</p>
        <p><strong>Estado:</strong> ${vacante.estado}</p>
        <button class="btn btn-primary btn-sm" onclick="postular(${vacante.id})">Postularme</button>
    `;
};

//Postular En vacante
const postular = (id) => {
    fetch('../PHP/postular.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id_vacante: id }),
    })
        .then((response) => {
            if (!response.ok) {
                throw new Error('Error en la solicitud: ' + response.status);
            }
            return response.json();
        })
        .then((data) => {
            if (data.success) {
                alert('¡Te has postulado con éxito!');
            } else {
                alert('Error al postularse: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
            alert('Hubo un problema al postularse. Inténtalo más tarde.');
        });
};

// Aplicar filtros
const aplicarFiltros = () => {
    const empresaValue = empresaFilter.value;
    const localidadValue = localidadFilter.value;
    const sectorValue = sectorFilter.value;
    const programaValue = programaFilter.value;

    const vacantesFiltradas = vacantes.filter(vacante => {
        return (
            (empresaValue === "" || vacante.empresa === empresaValue) &&
            (localidadValue === "" || vacante.localidad === localidadValue) &&
            (sectorValue === "" || vacante.sector === sectorValue) &&
            (programaValue === "" || vacante.programa === programaValue)
        );
    });

    renderVacantes(vacantesFiltradas);
};

// Evento para aplicar los filtros al hacer clic en el botón
applyFiltersButton.addEventListener("click", aplicarFiltros);
