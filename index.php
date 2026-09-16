<?php
session_start();

if (isset($_SESSION['utilizador_id'])) {
    header("Location: dashboard.php");
    exit;
}

$erro = $_GET['erro'] ?? '';
$sucesso = $_GET['sucesso'] ?? '';
?>

<!DOCTYPE html>
<html lang="pt-AO">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Comunica+ | Login</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css"
        rel="stylesheet"
    >

    <link
        rel="stylesheet"
        href="css/style.css"
    >

</head>

<body class="login-body">

<div class="container">

    <div class="row justify-content-center align-items-center min-vh-100">

        <div class="col-12 col-sm-10 col-md-7 col-lg-5">

            <div class="login-card">

                <!-- LOGO -->

                <div class="text-center mb-4">

                    <div class="logo-icon">

                        <i class="bi bi-chat-heart-fill"></i>

                    </div>

                    <h1 class="fw-bold mt-3">
                        Comunica+
                    </h1>

                    <p class="text-muted">
                        Sistema de Comunicação Assistiva
                    </p>

                </div>


                <!-- MENSAGENS -->

                <?php if ($erro): ?>

                    <div class="alert alert-danger">

                        <i class="bi bi-exclamation-triangle-fill"></i>

                        <?= htmlspecialchars($erro) ?>

                    </div>

                <?php endif; ?>


                <?php if ($sucesso): ?>

                    <div class="alert alert-success">

                        <i class="bi bi-check-circle-fill"></i>

                        <?= htmlspecialchars($sucesso) ?>

                    </div>

                <?php endif; ?>


                <!-- FORMULÁRIO -->

                <form
                    action="login.php"
                    method="POST"
                >

                    <!-- EMAIL -->

                    <div class="mb-3">

                        <label
                            for="email"
                            class="form-label fw-bold"
                        >
                            E-mail
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-envelope-fill"></i>

                            </span>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                placeholder="Digite seu e-mail"
                                required
                            >

                        </div>

                    </div>


                    <!-- SENHA -->

                    <div class="mb-3">

                        <label
                            for="senha"
                            class="form-label fw-bold"
                        >
                            Senha
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-lock-fill"></i>

                            </span>

                            <input
                                type="password"
                                name="senha"
                                id="senha"
                                class="form-control"
                                placeholder="Digite sua senha"
                                required
                            >

                            <button
                                type="button"
                                class="btn btn-outline-secondary"
                                id="mostrarSenha"
                            >

                                <i
                                    class="bi bi-eye"
                                    id="iconeSenha"
                                ></i>

                            </button>

                        </div>

                    </div>


                    <!-- LEMBRAR -->

                    <div class="form-check mb-4">

                        <input
                            type="checkbox"
                            class="form-check-input"
                            id="lembrar"
                            name="lembrar"
                        >

                        <label
                            class="form-check-label"
                            for="lembrar"
                        >

                            Lembrar-me

                        </label>

                    </div>


                    <!-- BOTÃO -->

                    <button
                        type="submit"
                        class="btn btn-primary btn-login w-100"
                    >

                        <i class="bi bi-box-arrow-in-right"></i>

                        ENTRAR

                    </button>

                </form>


                <!-- CADASTRO -->

                <div class="text-center mt-4">

                    <p class="mb-0">

                        Ainda não possui uma conta?

                    </p>

                    <a
                        href="cadastrar.php"
                        class="fw-bold"
                    >

                        Criar uma conta

                    </a>

                </div>


                <!-- RODAPÉ -->

                <div class="text-center mt-4">

                    <small class="text-muted">

                        Comunica+ © 2026

                    </small>

                </div>

            </div>

        </div>

    </div>

</div>


<script>

const senha =
    document.getElementById("senha");

const mostrarSenha =
    document.getElementById("mostrarSenha");

const iconeSenha =
    document.getElementById("iconeSenha");


mostrarSenha.addEventListener(
    "click",
    function () {

        if (senha.type === "password") {

            senha.type = "text";

            iconeSenha.className =
                "bi bi-eye-slash";

        } else {

            senha.type = "password";

            iconeSenha.className =
                "bi bi-eye";

        }

    }
);

</script>

</body>

</html>