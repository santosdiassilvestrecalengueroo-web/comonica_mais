/*
|--------------------------------------------------------------------------
| TEXTO → VOZ
|--------------------------------------------------------------------------
*/

function falar() {

    const texto =
        document.getElementById("texto").value;


    if (texto.trim() === "") {

        alert("Digite uma mensagem primeiro.");

        return;
    }


    if (!("speechSynthesis" in window)) {

        alert(
            "O seu navegador não suporta síntese de voz."
        );

        return;
    }


    const mensagem =
        new SpeechSynthesisUtterance(texto);


    mensagem.lang = "pt-PT";

    mensagem.rate = 1;

    mensagem.pitch = 1;

    mensagem.volume = 1;


    window.speechSynthesis.cancel();

    window.speechSynthesis.speak(mensagem);
}



/*
|--------------------------------------------------------------------------
| VOZ → TEXTO
|--------------------------------------------------------------------------
*/

function ouvir() {

    const SpeechRecognition =
        window.SpeechRecognition ||
        window.webkitSpeechRecognition;


    if (!SpeechRecognition) {

        alert(
            "O seu navegador não suporta reconhecimento de voz."
        );

        return;
    }


    const reconhecimento =
        new SpeechRecognition();


    reconhecimento.lang = "pt-PT";

    reconhecimento.continuous = false;

    reconhecimento.interimResults = false;


    reconhecimento.onstart = function () {

        console.log(
            "Reconhecimento de voz iniciado."
        );

    };


    reconhecimento.onresult = function (evento) {

        const texto =
            evento.results[0][0].transcript;


        document.getElementById("resultado").value =
            texto;

    };


    reconhecimento.onerror = function (evento) {

        alert(
            "Erro no reconhecimento de voz: " +
            evento.error
        );

    };


    reconhecimento.start();
}