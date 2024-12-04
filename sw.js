// Nombre del caché
const CACHE_NAME = 'mi-app-cache-v1';
const DATA_CACHE_NAME = 'mi-app-data-cache-v1';

// Archivos estáticos que se deben guardar en caché
const FILES_TO_CACHE = [
    '/',
    '/index.html', 
    '/styles.css', 
    '/Vacantes.js',  // Asegúrate de que este sea el nombre correcto
    '/img/SEEKUTM.png'      // Asegúrate de que la ruta y nombre sean correctos
];

// Evento de instalación
self.addEventListener('install', event => {
    event.waitUntil(
        caches.open(CACHE_NAME).then(cache => {
            console.log('[Service Worker] Cargando archivos estáticos en caché');
            return Promise.all(
                FILES_TO_CACHE.map(url => {
                    return fetch(url)
                        .then(response => {
                            if (response.ok) {
                                cache.put(url, response);
                            } else {
                                console.error(`[Service Worker] Error al cargar: ${url}`);
                            }
                        })
                        .catch(error => {
                            console.error(`[Service Worker] Error al obtener el archivo: ${url}`, error);
                        });
                })
            );
        })
    );
    self.skipWaiting(); // Activa el Service Worker inmediatamente
});

// Evento de activación
self.addEventListener('activate', event => {
    event.waitUntil(
        caches.keys().then(cacheNames => {
            return Promise.all(
                cacheNames.map(cacheName => {
                    if (cacheName !== CACHE_NAME && cacheName !== DATA_CACHE_NAME) {
                        console.log('[Service Worker] Eliminando caché antiguo:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
    self.clients.claim(); // Controla las páginas inmediatamente
});

// Evento de fetch (captura de solicitudes)
self.addEventListener('fetch', event => {
    // Verifica si es una solicitud a la API de datos
    if (event.request.url.includes('convertir_datos.php')) {
        event.respondWith(
            caches.open(DATA_CACHE_NAME).then(cache => {
                return fetch(event.request)
                    .then(response => {
                        // Si la respuesta es válida, guarda en el caché
                        if (response.status === 200) {
                            cache.put(event.request.url, response.clone());
                        }
                        return response;
                    })
                    .catch(() => {
                        // Si hay un error, intenta obtenerlo del caché
                        return cache.match(event.request);
                    });
            })
        );
        return;
    }

    // Manejo para archivos estáticos
    event.respondWith(
        caches.match(event.request).then(response => {
            return response || fetch(event.request);
        })
    );
});
