<?php

session_start();

require_once "config-database.php";


/* =========================================
   VERIFICAR MÉTODO
========================================= */

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: index.php");

    exit;

}


/* =========================================
   RECEBER DADOS
========================================= */

$email =
    trim($_POST["email"] ?? "");

$senha =
    $_POST["senha"] ?? "";


/* =========================================
   VALIDAR
========================================= */

if (
    empty($email) ||
    empty($senha)
) {

    header(
        "Location: index.php?erro=Preencha todos os campos."
    );

    exit;

}


/* =========================================
   BUSCAR UTILIZADOR
========================================= */

$sql = "
    SELECT
        id,
        nome,
        email,
        senha,
        tipo,
        ativo

    FROM utilizadores

    WHERE email = ?

    LIMIT 1
";


$stmt =
    $pdo->prepare($sql);


$stmt->execute([
    $email
]);


$utilizador =
    $stmt->fetch();


/* =========================================
   VERIFICAR UTILIZADOR
========================================= */

if (!$utilizador) {

    header(
        "Location: index.php?erro=E-mail ou senha incorretos."
    );

    exit;

}


/* =========================================
   VERIFICAR ATIVO
========================================= */

if (!$utilizador["ativo"]) {

    header(
        "Location: index.php?erro=Esta conta está desativada."
    );

    exit;

}


/* =========================================
   VERIFICAR SENHA
========================================= */

if (
    !password_verify(
        $senha,
        $utilizador["senha"]
    )
) {

    header(
        "Location: index.php?erro=E-mail ou senha incorretos."
    );

    exit;

}


/* =========================================
   CRIAR SESSÃO
========================================= */

session_regenerate_id(true);


$_SESSION["utilizador_id"] =
    $utilizador["id"];


$_SESSION["utilizador_nome"] =
    $utilizador["nome"];


$_SESSION["utilizador_email"] =
    $utilizador["email"];


$_SESSION["utilizador_tipo"] =
    $utilizador["tipo"];


/* =========================================
   REDIRECIONAR
========================================= */

header(
    "Location: dashboard.php"
);

exit;

?>