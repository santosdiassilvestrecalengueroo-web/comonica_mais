const CACHE_NAME = "comunica-mais-v1";

const ARQUIVOS = [
    "./",
    "./index.php",
    "./dashboard.php",
    "./css/style.css",
    "./js/script.js",
    "./manifest.json"
];


self.addEventListener("install", function(event) {

    event.waitUntil(

        caches.open(CACHE_NAME)
            .then(function(cache) {

                return cache.addAll(ARQUIVOS);

            })

    );

    self.skipWaiting();

});


self.addEventListener("activate", function(event) {

    event.waitUntil(

        caches.keys().then(function(chaves) {

            return Promise.all(

                chaves
                    .filter(function(chave) {

                        return chave !== CACHE_NAME;

                    })
                    .map(function(chave) {

                        return caches.delete(chave);

                    })

            );

        })

    );

    self.clients.claim();

});


self.addEventListener("fetch", function(event) {

    event.respondWith(

        fetch(event.request)
            .then(function(resposta) {

                return resposta;

            })
            .catch(function() {

                return caches.match(event.request);

            })

    );

});