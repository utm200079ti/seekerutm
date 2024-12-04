// URL del archivo PHP
const url = "obtener_datos.php";

// Fetch para obtener los datos
fetch(url)
    .then(response => {
        if (!response.ok) {
            throw new Error("Error al obtener los datos.");
        }
        return response.json(); // Convertir a JSON
    })
    .then(data => {
        console.log("Datos obtenidos del servidor:", data);

        // Guardar los datos en el cache del Service Worker
        if ('caches' in window) {
            caches.open('mi-cache-datos')
                .then(cache => {
                    const jsonBlob = new Blob([JSON.stringify(data)], { type: 'application/json' });
                    const jsonResponse = new Response(jsonBlob);
                    cache.put('/cache/datos.json', jsonResponse); // Guardar los datos como un archivo virtual
                });
        }
    })
    .catch(error => {
        console.error("Error:", error);
    });


// Lista de vacantes
const vacantes = [
  { id: 1, empresa: "Empresa A", descripcion: "Desarrollador Web", requisitos: "Conocimientos en HTML, CSS, JavaScript", sector: "Tecnología", programa: "TIC" },
  { id: 2, empresa: "Empresa B", descripcion: "Analista Financiero", requisitos: "Excel avanzado, finanzas corporativas", sector: "Finanzas", programa: "MAI" },
  { id: 3, empresa: "Empresa C", descripcion: "Enfermero General", requisitos: "Licenciatura en Enfermería", sector: "Salud", programa: "BIO" },
  { id: 4, empresa: "Empresa D", descripcion: "Docente de Matemáticas", requisitos: "Pedagogía, matemáticas avanzadas", sector: "Educación", programa: "DMI" },
  { id: 5, empresa: "Empresa E", descripcion: "Ingeniero Mecánico", requisitos: "Autodesk, SolidWorks", sector: "Tecnología", programa: "MECA" },
  { id: 6, empresa: "Empresa F", descripcion: "Administrador de Proyectos", requisitos: "Conocimientos en gestión de proyectos", sector: "Finanzas", programa: "GST" },
  { id: 7, empresa: "Empresa G", descripcion: "Técnico en Biotecnología", requisitos: "Laboratorio, biología molecular", sector: "Salud", programa: "BIO" },
  { id: 8, empresa: "Empresa H", descripcion: "Diseñador Gráfico", requisitos: "Photoshop, Illustrator", sector: "Tecnología", programa: "ERV" },
  { id: 9, empresa: "Empresa I", descripcion: "Ingeniero en TIC", requisitos: "Redes, ciberseguridad", sector: "Tecnología", programa: "TIC" },
  { id: 10, empresa: "Empresa J", descripcion: "Contador Público", requisitos: "SAP, declaraciones fiscales", sector: "Finanzas", programa: "MAI" },
  { id: 11, empresa: "Empresa K", descripcion: "Químico Industrial", requisitos: "Química, procesos industriales", sector: "Tecnología", programa: "BIO" },
  { id: 12, empresa: "Empresa L", descripcion: "Coordinador Académico", requisitos: "Gestión educativa", sector: "Educación", programa: "DMI" },
  { id: 13, empresa: "Empresa M", descripcion: "Diseñador de Videojuegos", requisitos: "Unity, Blender", sector: "Tecnología", programa: "ERV" },
  { id: 14, empresa: "Empresa N", descripcion: "Especialista en IA", requisitos: "Python, machine learning", sector: "Tecnología", programa: "TIC" },
  { id: 15, empresa: "Empresa O", descripcion: "Técnico en Mantenimiento", requisitos: "Electrónica, reparación", sector: "Tecnología", programa: "MECA" },
];

// Elementos DOM
const sectorFilter = document.getElementById("sectorFilter");
const programFilter = document.getElementById("programFilter");
const vacantesList = document.getElementById("vacantesList");
const vacanteDetail = document.getElementById("vacanteDetail");

// Renderizar lista de vacantes
const renderVacantes = (vacantesFiltradas) => {
  vacantesList.innerHTML = "";

  vacantesFiltradas.forEach((vacante) => {
    const vacanteItem = document.createElement("div");
    vacanteItem.classList.add("list-group-item");
    vacanteItem.innerHTML = `
      <h5>${vacante.empresa}</h5>
      <p>${vacante.descripcion}</p>
      <button class="btn btn-info btn-sm me-2" onclick="verDetalles(${vacante.id})">Información</button>
      <button class="btn btn-primary btn-sm" onclick="postular(${vacante.id})">Postularse</button>
    `;
    vacantesList.appendChild(vacanteItem);
  });
};

// Mostrar detalles de vacante
const verDetalles = (id) => {
  const vacante = vacantes.find((v) => v.id === id);
  vacanteDetail.innerHTML = `
    <h5>${vacante.empresa}</h5>
    <p><strong>Descripción:</strong> ${vacante.descripcion}</p>
    <p><strong>Requisitos:</strong> ${vacante.requisitos}</p>
    <p><strong>Sector:</strong> ${vacante.sector}</p>
    <p><strong>Programa Educativo:</strong> ${vacante.programa}</p>
  `;
};

// Filtrar vacantes
const aplicarFiltros = () => {
  const sectorValue = sectorFilter.value;
  const programValue = programFilter.value;

  const vacantesFiltradas = vacantes.filter((vacante) => {
    return (
      (sectorValue === "" || vacante.sector === sectorValue) &&
      (programValue === "" || vacante.programa === programValue)
    );
  });

  renderVacantes(vacantesFiltradas);
};

// Inicializar
renderVacantes(vacantes);
sectorFilter.addEventListener("change", aplicarFiltros);
programFilter.addEventListener("change", aplicarFiltros);