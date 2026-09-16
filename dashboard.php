<?php
session_start();

if (!isset($_SESSION["utilizador_id"])) {
    header("Location: index.php");
    exit;
}

$nome = $_SESSION["utilizador_nome"];
?>
<!DOCTYPE html>
<html lang="pt-AO">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Comunica+ | Comunicação Assistiva</title>

    <!-- Bootstrap -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <!-- Bootstrap Icons -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: #f3f6fb;
            font-family: Arial, sans-serif;
            transition: .3s;
        }

        .navbar {
            background: #0d6efd;
        }

        .logo {
            font-size: 1.4rem;
            font-weight: bold;
        }

        .hero {
            padding: 35px 15px;
            text-align: center;
        }

        .hero h1 {
            font-weight: 800;
        }

        .card {
            border: 0;
            border-radius: 18px;
            box-shadow: 0 5px 20px rgba(0,0,0,.08);
            margin-bottom: 25px;
        }

        .card-header {
            font-weight: bold;
            font-size: 1.1rem;
            padding: 18px;
        }

        textarea {
            font-size: 20px !important;
            border-radius: 12px !important;
            resize: vertical;
        }

        .main-button {
            min-height: 65px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 12px;
        }

        .phrase-button {
            width: 100%;
            min-height: 75px;
            font-size: 17px;
            font-weight: bold;
            border-radius: 12px;
        }

        .mic-button {
            width: 230px;
            height: 75px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: bold;
        }

        .recording {
            animation: pulse 1s infinite;
        }

        @keyframes pulse {

            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }

        }

        .history-item {
            padding: 15px;
            margin-bottom: 10px;
            border-left: 5px solid #0d6efd;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .status {
            border-radius: 10px;
            padding: 12px;
            text-align: center;
            font-weight: bold;
        }

        footer {
            margin-top: 50px;
            padding: 25px;
        }

        /* MODO ESCURO */

        body.dark {
            background: #121212;
            color: white;
        }

        body.dark .card {
            background: #1e1e1e;
            color: white;
        }

        body.dark .card-header {
            color: white;
        }

        body.dark textarea,
        body.dark select {
            background: #292929;
            color: white;
            border-color: #555;
        }

        body.dark .history-item {
            background: #292929;
            color: white;
        }

        body.dark .text-muted {
            color: #bbb !important;
        }

        body.dark footer {
            background: #000 !important;
        }

        @media(max-width: 576px) {

            textarea {
                font-size: 18px !important;
            }

            .main-button {
                width: 100%;
                margin-bottom: 8px;
            }

            .phrase-button {
                font-size: 15px;
            }

        }

    </style>
</head>

<body>

<!-- ================= NAVBAR ================= -->

<nav class="navbar navbar-dark shadow">

    <div class="container">

        <span class="navbar-brand logo">
            <i class="bi bi-chat-heart-fill"></i>
            Comunica+
        </span>

        <div class="d-flex align-items-center gap-2">

            <span class="text-white">
                <i class="bi bi-person-circle"></i>
                Olá, <strong><?= htmlspecialchars($nome) ?></strong>
            </span>

            <a href="logout.php" class="btn btn-light btn-sm">
                <i class="bi bi-box-arrow-right"></i>
                Terminar sessão
            </a>

            <button
                id="themeButton"
                class="btn btn-light"
                title="Alterar tema"
            >
                <i class="bi bi-moon-fill"></i>
            </button>

        </div>

    </div>

</nav>

<!-- ================= HERO ================= -->

<section class="hero">

    <div class="container">

        <h1>
            Comunicação Assistiva
        </h1>

        <p class="text-muted">

            Escreva para falar ou fale para transformar sua voz em texto.

        </p>

    </div>

</section>


<main class="container">


<!-- =====================================================
     TEXTO PARA VOZ
===================================================== -->

<div class="card">

    <div class="card-header bg-primary text-white">

        <i class="bi bi-volume-up-fill"></i>

        Texto → Voz

    </div>


    <div class="card-body">

        <label class="form-label fw-bold">

            Escreva sua mensagem

        </label>


        <textarea
            id="textInput"
            class="form-control"
            rows="5"
            maxlength="1000"
            placeholder="Digite aqui a mensagem que deseja falar..."
        ></textarea>


        <div class="text-end text-muted mt-2">

            <small>

                <span id="characterCount">0</span> / 1000

            </small>

        </div>


        <div class="row mt-3">

            <div class="col-md-4 mb-2">

                <button
                    id="speakButton"
                    class="btn btn-success main-button w-100"
                >

                    <i class="bi bi-volume-up-fill"></i>

                    FALAR

                </button>

            </div>


            <div class="col-md-4 mb-2">

                <button
                    id="stopButton"
                    class="btn btn-danger main-button w-100"
                >

                    <i class="bi bi-stop-fill"></i>

                    PARAR

                </button>

            </div>


            <div class="col-md-4 mb-2">

                <button
                    id="clearButton"
                    class="btn btn-secondary main-button w-100"
                >

                    <i class="bi bi-trash"></i>

                    LIMPAR

                </button>

            </div>

        </div>


        <!-- CONFIGURAÇÕES -->

        <div class="row mt-4">

            <div class="col-md-7">

                <label class="form-label fw-bold">

                    Escolher voz

                </label>

                <select
                    id="voiceSelect"
                    class="form-select"
                >

                    <option>

                        Carregando vozes...

                    </option>

                </select>

            </div>


            <div class="col-md-5">

                <label class="form-label fw-bold">

                    Velocidade:

                    <span id="speedValue">

                        1.0

                    </span>

                </label>


                <input
                    id="speed"
                    type="range"
                    class="form-range"
                    min="0.5"
                    max="2"
                    step="0.1"
                    value="1"
                >

            </div>

        </div>

    </div>

</div>



<!-- =====================================================
     FRASES RÁPIDAS
===================================================== -->

<div class="card">

    <div class="card-header bg-success text-white">

        <i class="bi bi-lightning-fill"></i>

        Frases rápidas

    </div>


    <div class="card-body">

        <div class="row g-3">


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Preciso de ajuda."
                >

                    🆘

                    <br>

                    Preciso de ajuda

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Estou com fome."
                >

                    🍽️

                    <br>

                    Estou com fome

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Estou com sede."
                >

                    🥤

                    <br>

                    Estou com sede

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Estou com dor."
                >

                    ❤️

                    <br>

                    Estou com dor

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Preciso ir ao banheiro."
                >

                    🚻

                    <br>

                    Preciso ir ao banheiro

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Obrigado."
                >

                    🙏

                    <br>

                    Obrigado

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Por favor, espere um momento."
                >

                    ⏳

                    <br>

                    Espere um momento

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Não estou entendendo."
                >

                    ❓

                    <br>

                    Não estou entendendo

                </button>

            </div>


            <div class="col-6 col-md-4">

                <button
                    class="btn btn-outline-primary phrase-button"
                    data-text="Sim."
                >

                    ✅

                    <br>

                    Sim

                </button>

            </div>


        </div>

    </div>

</div>



<!-- =====================================================
     VOZ PARA TEXTO
===================================================== -->

<div class="card">

    <div class="card-header bg-warning">

        <i class="bi bi-mic-fill"></i>

        Voz → Texto

    </div>


    <div class="card-body text-center">

        <p class="text-muted">

            Clique no microfone e fale.

        </p>


        <button
            id="microphoneButton"
            class="btn btn-primary mic-button"
        >

            <i class="bi bi-mic-fill"></i>

            INICIAR MICROFONE

        </button>


        <div
            id="microphoneStatus"
            class="status alert alert-secondary mt-4"
        >

            Microfone desligado.

        </div>


        <textarea
            id="speechText"
            class="form-control text-start mt-3"
            rows="5"
            readonly
            placeholder="O texto reconhecido aparecerá aqui..."
        ></textarea>


        <div class="row mt-3">

            <div class="col-md-6 mb-2">

                <button
                    id="useSpeechButton"
                    class="btn btn-success main-button w-100"
                >

                    <i class="bi bi-arrow-up-circle"></i>

                    USAR TEXTO

                </button>

            </div>


            <div class="col-md-6 mb-2">

                <button
                    id="clearSpeechButton"
                    class="btn btn-secondary main-button w-100"
                >

                    <i class="bi bi-trash"></i>

                    LIMPAR

                </button>

            </div>

        </div>

    </div>

</div>



<!-- =====================================================
     HISTÓRICO
===================================================== -->

<div class="card">

    <div class="card-header bg-dark text-white">

        <div class="d-flex justify-content-between align-items-center">

            <span>

                <i class="bi bi-clock-history"></i>

                Histórico

            </span>


            <button
                id="clearHistoryButton"
                class="btn btn-danger btn-sm"
            >

                <i class="bi bi-trash"></i>

                Apagar

            </button>

        </div>

    </div>


    <div class="card-body">

        <div id="history">

        </div>

    </div>

</div>

</main>



<!-- ================= FOOTER ================= -->

<footer class="bg-dark text-white text-center">

    <div class="container">

        <strong>

            Comunica+

        </strong>

        <br>

        <small>

            Sistema de Comunicação Assistiva

        </small>

    </div>

</footer>



<script>

/* =====================================================
   ELEMENTOS
===================================================== */

const textInput =
    document.getElementById("textInput");

const characterCount =
    document.getElementById("characterCount");

const speakButton =
    document.getElementById("speakButton");

const stopButton =
    document.getElementById("stopButton");

const clearButton =
    document.getElementById("clearButton");

const voiceSelect =
    document.getElementById("voiceSelect");

const speed =
    document.getElementById("speed");

const speedValue =
    document.getElementById("speedValue");

const microphoneButton =
    document.getElementById("microphoneButton");

const microphoneStatus =
    document.getElementById("microphoneStatus");

const speechText =
    document.getElementById("speechText");

const useSpeechButton =
    document.getElementById("useSpeechButton");

const clearSpeechButton =
    document.getElementById("clearSpeechButton");

const historyContainer =
    document.getElementById("history");

const clearHistoryButton =
    document.getElementById("clearHistoryButton");

const themeButton =
    document.getElementById("themeButton");


/* =====================================================
   TEXTO → VOZ
===================================================== */

let voices = [];


function loadVoices() {

    voices =
        window.speechSynthesis.getVoices();


    voiceSelect.innerHTML = "";


    if (voices.length === 0) {

        const option =
            document.createElement("option");

        option.textContent =
            "Nenhuma voz disponível";

        voiceSelect.appendChild(option);

        return;

    }


    voices.forEach(
        (voice, index) => {

            const option =
                document.createElement("option");

            option.value = index;

            option.textContent =
                `${voice.name} — ${voice.lang}`;

            voiceSelect.appendChild(option);

        }
    );


    /* Selecionar português */

    const portuguese =
        voices.findIndex(
            voice =>
                voice.lang
                    .toLowerCase()
                    .startsWith("pt")
        );


    if (portuguese >= 0) {

        voiceSelect.value =
            portuguese;

    }

}


window.speechSynthesis.onvoiceschanged =
    loadVoices;

loadVoices();


/* =====================================================
   FALAR
===================================================== */

function speak(text) {

    text = text.trim();


    if (!text) {

        alert(
            "Escreva uma mensagem primeiro."
        );

        textInput.focus();

        return;

    }


    if (
        !("speechSynthesis" in window)
    ) {

        alert(
            "Seu navegador não suporta síntese de voz."
        );

        return;

    }


    window.speechSynthesis.cancel();


    const utterance =
        new SpeechSynthesisUtterance(text);


    const selectedVoice =
        voices[
            Number(voiceSelect.value)
        ];


    if (selectedVoice) {

        utterance.voice =
            selectedVoice;

        utterance.lang =
            selectedVoice.lang;

    } else {

        utterance.lang =
            "pt-AO";

    }


    utterance.rate =
        Number(speed.value);

    utterance.pitch = 1;

    utterance.volume = 1;


    utterance.onstart =
        function () {

            speakButton.innerHTML =
                '<i class="bi bi-volume-up-fill"></i> FALANDO...';

            speakButton.disabled =
                true;

        };


    utterance.onend =
        function () {

            speakButton.innerHTML =
                '<i class="bi bi-volume-up-fill"></i> FALAR';

            speakButton.disabled =
                false;

        };


    utterance.onerror =
        function () {

            speakButton.innerHTML =
                '<i class="bi bi-volume-up-fill"></i> FALAR';

            speakButton.disabled =
                false;

            alert(
                "Não foi possível reproduzir a voz."
            );

        };


    window.speechSynthesis.speak(
        utterance
    );


    addHistory(text);

}


/* =====================================================
   BOTÃO FALAR
===================================================== */

speakButton.onclick =
    function () {

        speak(textInput.value);

    };


/* =====================================================
   PARAR
===================================================== */

stopButton.onclick =
    function () {

        window.speechSynthesis.cancel();

        speakButton.innerHTML =
            '<i class="bi bi-volume-up-fill"></i> FALAR';

        speakButton.disabled =
            false;

    };


/* =====================================================
   LIMPAR
===================================================== */

clearButton.onclick =
    function () {

        textInput.value = "";

        updateCounter();

        textInput.focus();

    };


/* =====================================================
   CONTADOR
===================================================== */

function updateCounter() {

    characterCount.textContent =
        textInput.value.length;

}


textInput.addEventListener(
    "input",
    updateCounter
);


/* =====================================================
   VELOCIDADE
===================================================== */

speed.addEventListener(
    "input",
    function () {

        speedValue.textContent =
            speed.value;

    }
);


/* =====================================================
   FRASES RÁPIDAS
===================================================== */

document
    .querySelectorAll(".phrase-button")
    .forEach(
        button => {

            button.addEventListener(
                "click",
                function () {

                    const phrase =
                        this.dataset.text;

                    textInput.value =
                        phrase;

                    updateCounter();

                    speak(phrase);

                }
            );

        }
    );


/* =====================================================
   VOZ → TEXTO
===================================================== */

const SpeechRecognition =
    window.SpeechRecognition ||
    window.webkitSpeechRecognition;


let recognition = null;

let isListening = false;


if (SpeechRecognition) {

    recognition =
        new SpeechRecognition();


    recognition.lang =
        "pt-AO";


    recognition.continuous =
        true;


    recognition.interimResults =
        true;


    recognition.onstart =
        function () {

            isListening = true;


            microphoneButton.innerHTML =
                '<i class="bi bi-stop-circle-fill"></i> PARAR MICROFONE';


            microphoneButton.classList
                .remove("btn-primary");


            microphoneButton.classList
                .add("btn-danger");


            microphoneButton.classList
                .add("recording");


            microphoneStatus.className =
                "status alert alert-success mt-4";


            microphoneStatus.textContent =
                "🎤 Microfone ativo. Fale agora...";

        };


    recognition.onresult =
        function (event) {

            let finalText = "";

            let temporaryText = "";


            for (
                let i = event.resultIndex;
                i < event.results.length;
                i++
            ) {

                const result =
                    event.results[i];


                const transcript =
                    result[0].transcript;


                if (
                    result.isFinal
                ) {

                    finalText +=
                        transcript + " ";

                } else {

                    temporaryText +=
                        transcript;

                }

            }


            if (finalText) {

                speechText.value +=
                    finalText;

            }


            if (temporaryText) {

                microphoneStatus.textContent =
                    "🎤 Ouvindo: " +
                    temporaryText;

            }

        };


    recognition.onerror =
        function (event) {

            console.log(
                "Erro de reconhecimento:",
                event.error
            );


            microphoneStatus.className =
                "status alert alert-danger mt-4";


            if (
                event.error ===
                "not-allowed"
            ) {

                microphoneStatus.textContent =
                    "❌ Permissão do microfone recusada. Autorize o microfone no navegador.";

            } else if (
                event.error ===
                "no-speech"
            ) {

                microphoneStatus.textContent =
                    "⚠️ Nenhuma fala detectada.";

            } else {

                microphoneStatus.textContent =
                    "❌ Erro: " +
                    event.error;

            }

        };


    recognition.onend =
        function () {

            isListening = false;


            microphoneButton.innerHTML =
                '<i class="bi bi-mic-fill"></i> INICIAR MICROFONE';


            microphoneButton.classList
                .remove("btn-danger");


            microphoneButton.classList
                .add("btn-primary");


            microphoneButton.classList
                .remove("recording");


            microphoneStatus.className =
                "status alert alert-secondary mt-4";


            microphoneStatus.textContent =
                "Microfone desligado.";

        };


    microphoneButton.onclick =
        function () {

            if (isListening) {

                recognition.stop();

            } else {

                speechText.value = "";

                try {

                    recognition.start();

                } catch (error) {

                    console.log(error);

                }

            }

        };


} else {

    microphoneButton.disabled =
        true;


    microphoneStatus.className =
        "status alert alert-danger mt-4";


    microphoneStatus.textContent =
        "❌ Este navegador não suporta reconhecimento de voz. Use Google Chrome ou Microsoft Edge.";

}


/* =====================================================
   USAR TEXTO RECONHECIDO
===================================================== */

useSpeechButton.onclick =
    function () {

        const text =
            speechText.value.trim();


        if (!text) {

            alert(
                "Nenhum texto foi reconhecido."
            );

            return;

        }


        textInput.value =
            text;


        updateCounter();


        textInput.focus();

    };


/* =====================================================
   LIMPAR TEXTO DE VOZ
===================================================== */

clearSpeechButton.onclick =
    function () {

        speechText.value = "";

    };


/* =====================================================
   HISTÓRICO
===================================================== */

let history =
    JSON.parse(
        localStorage.getItem(
            "comunicaHistory"
        )
    ) || [];


function addHistory(text) {

    const item = {

        text: text,

        date:
            new Date().toLocaleString(
                "pt-AO"
            )

    };


    history.unshift(item);


    /*
       Limitar histórico a 50 mensagens
    */

    if (history.length > 50) {

        history =
            history.slice(0, 50);

    }


    localStorage.setItem(
        "comunicaHistory",
        JSON.stringify(history)
    );


    renderHistory();

}


/* =====================================================
   MOSTRAR HISTÓRICO
===================================================== */

function renderHistory() {

    historyContainer.innerHTML = "";


    if (history.length === 0) {

        historyContainer.innerHTML = `

            <div class="text-center text-muted">

                Nenhuma mensagem ainda.

            </div>

        `;

        return;

    }


    history.forEach(
        (item, index) => {

            const div =
                document.createElement("div");


            div.className =
                "history-item";


            const text =
                document.createElement("div");


            text.className =
                "fw-bold";


            text.textContent =
                item.text;


            const date =
                document.createElement("small");


            date.className =
                "text-muted";


            date.textContent =
                item.date;


            const button =
                document.createElement("button");


            button.className =
                "btn btn-sm btn-primary mt-2";


            button.innerHTML =
                '<i class="bi bi-volume-up"></i> Falar novamente';


            button.onclick =
                function () {

                    textInput.value =
                        item.text;

                    updateCounter();

                    speak(item.text);

                };


            div.appendChild(text);

            div.appendChild(date);

            div.appendChild(
                document.createElement("br")
            );

            div.appendChild(button);


            historyContainer.appendChild(div);

        }
    );

}


/* =====================================================
   APAGAR HISTÓRICO
===================================================== */

clearHistoryButton.onclick =
    function () {

        if (
            history.length === 0
        ) {

            return;

        }


        if (
            confirm(
                "Deseja apagar todo o histórico?"
            )
        ) {

            history = [];


            localStorage.removeItem(
                "comunicaHistory"
            );


            renderHistory();

        }

    };


/* =====================================================
   TEMA
===================================================== */

themeButton.onclick =
    function () {

        document.body.classList.toggle(
            "dark"
        );


        const dark =
            document.body.classList.contains(
                "dark"
            );


        if (dark) {

            localStorage.setItem(
                "comunicaTheme",
                "dark"
            );


            themeButton.innerHTML =
                '<i class="bi bi-sun-fill"></i>';

        } else {

            localStorage.setItem(
                "comunicaTheme",
                "light"
            );


            themeButton.innerHTML =
                '<i class="bi bi-moon-fill"></i>';

        }

    };


/* =====================================================
   CARREGAR TEMA
===================================================== */

if (
    localStorage.getItem(
        "comunicaTheme"
    ) === "dark"
) {

    document.body.classList.add(
        "dark"
    );


    themeButton.innerHTML =
        '<i class="bi bi-sun-fill"></i>';

}


/* =====================================================
   INICIALIZAR
===================================================== */

updateCounter();

renderHistory();

</script>

</body>
</html>
