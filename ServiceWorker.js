
const CACHE = 'cache-12345';

// Archivos estáticos
const FILES_TO_CACHE = [
    // HTML files
    'Contactanos.html',
    'cv.html',
    'ediPeAl.html',
    'ediPeEm.html',
    'Footer.html',
    'Index.html',
    'InicioSesion.html',
    'listado.txt',
    'ListaVacantes.html',
    'Manifest.json',
    'navar.html',
    'navara.html',
    'navare.html',
    'Nosotros.html',
    'Offline.html',
    'PerfilEmpresa.html',
    'PerfilEstudiante.html',
    'Registrarse.html',
    'ServiceWorker.js',
    'Vacantes.html',
    'vacantesE.html',

    // CSS files
    'CSS/bootstrap.min.css',
    'CSS/Styles.css',
    'CSS/StylesOffline.css',

    // JS files
    'JS/Auth.js',
    'JS/bootstrap.bundle.min.js',
    'JS/obtenerDatosPostulaciones.js',
    'JS/obtenerDatosVaca.js',
    'JS/scriptRegistro.js',
    'JS/Server.js',
    'JS/vacantes.js',

    // Image files
    'IMG/facebook.png',
    'IMG/Instagram.png',
    'IMG/SEEKERUTM.png',
    'IMG/SEKUTM.png',
    'IMG/SEEKUTM.svg',
    'IMG/Tiktok.png',

];


// Instalación del Service Worker
self.addEventListener('install', async event => {
    console.log('Instalando Service Worker...');

    try {
        // Abre el caché
        const cache = await caches.open(CACHE);

        // Intentamos agregar los archivos al caché
        await Promise.all(
            FILES_TO_CACHE.map(async file => {
                try {
                    const response = await fetch(file);
                    if (response.ok) {
                        await cache.put(file, response);
                        console.log(`Archivo almacenado en caché: ${file}`);
                    } else {
                        console.error(`Error al obtener el archivo: ${file}`);
                    }
                } catch (error) {
                    console.error(`No se pudo obtener el archivo: ${file}`, error);
                }
            })
        );

        console.log('Archivos estáticos añadidos al caché');
    } catch (error) {
        console.error('Error al instalar Service Worker:', error);
    }

    event.waitUntil(self.skipWaiting());
});

// Activación del Service Worker
self.addEventListener('activate', async event => {
    console.log('Activando nuevo Service Worker...');

    try {
        const cacheKeys = await caches.keys();
        await Promise.all(
            cacheKeys.map(key => {
                if (key !== CACHE) {
                    console.log(`Eliminando caché antiguo: ${key}`);
                    return caches.delete(key);
                }
            })
        );
    } catch (error) {
        console.error('Error al activar Service Worker:', error);
    }

    event.waitUntil(self.clients.claim());
});

// Fetch y manejo de recursos
self.addEventListener('fetch', event => {
    event.respondWith(
        (async () => {
            const cachedResponse = await caches.match(event.request);
            if (cachedResponse) {
                return cachedResponse; // Si está en el caché, lo servimos
            }

            try {
                const networkResponse = await fetch(event.request);
                const dynamicCache = await caches.open(CACHE);

                if (networkResponse.ok) {
                    dynamicCache.put(event.request, networkResponse.clone());
                }

                return networkResponse; // Servimos la respuesta de la red
            } catch (error) {
                if (event.request.headers.get('accept').includes('text/html')) {
                    // Devolvemos la página offline si está en el caché
                    const offlinePage = await caches.match('./Offline.html');
                    if (offlinePage) {
                        return offlinePage;
                    } else {
                        // Si no encontramos la página offline, devolvemos un error 503
                        return new Response('Página fuera de línea no disponible', {
                            status: 503,
                            statusText: 'Offline page not available'
                        });
                    }
                }
                console.warn('Recurso no disponible en modo offline', error);
            }
        })()
    );
});

// Detectar conexión y desconexión
self.addEventListener('sync', event => {
    if (event.tag === 'syncOffline') {
        event.waitUntil(
            fetch('./Index.html').then(response => {
                if (response.ok) {
                    clients.matchAll().then(clients => {
                        clients.forEach(client => client.navigate('./Index.html')); // Recarga la página principal
                    });
                }
            })
        );
    }
});

// Escucha los eventos de conexión en el navegador
self.addEventListener('message', event => {
    if (event.data === 'online') {
        // Si el navegador vuelve a estar en línea, recargamos la página
        event.source.postMessage({ type: 'reload' });
    }
});
