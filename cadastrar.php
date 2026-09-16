<?php

require_once "config-database.php";

$erro = "";
$sucesso = "";


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome = trim($_POST["nome"] ?? "");

    $email = trim($_POST["email"] ?? "");

    $senha = $_POST["senha"] ?? "";

    $confirmar_senha = $_POST["confirmar_senha"] ?? "";


    if (
        empty($nome) ||
        empty($email) ||
        empty($senha) ||
        empty($confirmar_senha)
    ) {

        $erro = "Preencha todos os campos.";

    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $erro = "Digite um e-mail válido.";

    }

    elseif (strlen($senha) < 6) {

        $erro =
            "A palavra-passe deve ter pelo menos 6 caracteres.";

    }

    elseif ($senha !== $confirmar_senha) {

        $erro =
            "As palavras-passe não coincidem.";

    }

    else {

        /*
        |--------------------------------------------------------------------------
        | Verificar se o e-mail já existe
        |--------------------------------------------------------------------------
        */

        $sql = "SELECT id
                FROM utilizadores
                WHERE email = :email
                LIMIT 1";

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":email" => $email
        ]);

        $existe = $stmt->fetch();


        if ($existe) {

            $erro =
                "Já existe uma conta com este e-mail.";

        } else {

            /*
            |--------------------------------------------------------------------------
            | Criptografar a palavra-passe
            |--------------------------------------------------------------------------
            */

            $senha_hash = password_hash(
                $senha,
                PASSWORD_DEFAULT
            );


            /*
            |--------------------------------------------------------------------------
            | Criar utilizador
            |--------------------------------------------------------------------------
            */

            $sql = "INSERT INTO utilizadores
                    (nome, email, senha)
                    VALUES
                    (:nome, :email, :senha)";

            $stmt = $pdo->prepare($sql);

            $stmt->execute([
                ":nome" => $nome,
                ":email" => $email,
                ":senha" => $senha_hash
            ]);


            header(
                "Location: index.php?sucesso=Conta criada com sucesso! Faça login."
            );

            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-AO">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Comunica+ | Criar Conta</title>

    <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
    >

    <link
        rel="stylesheet"
        href="css-style.css"
    >

</head>


<body class="cadastro-body">


    <div class="cadastro-container">


        <!-- CABEÇALHO -->

        <div class="cadastro-header">

            <div class="cadastro-icon">

                <i class="bi bi-chat-heart-fill"></i>

            </div>


            <h1>
                Criar conta
            </h1>


            <p>
                Registe-se para utilizar o Comunica+
            </p>

        </div>
        <!-- FORMULÁRIO -->

        <form
            action="cadastrar.php"
            method="POST"
            class="cadastro-form"
        >


            <!-- NOME -->

            <div class="form-group">

                <label for="nome">
                    Nome Completo
                </label>


                <div class="input-container">

                    <i class="bi bi-person"></i>


                    <input
                        type="text"
                        id="nome"
                        name="nome"
                        placeholder="Digite o seu nome"
                        value="<?= htmlspecialchars($nome ?? '') ?>"
                        required
                    >

                </div>

            </div>



            <!-- EMAIL -->

            <div class="form-group">

                <label for="email">
                    E-mail
                </label>


                <div class="input-container">

                    <i class="bi bi-envelope"></i>


                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="Digite o seu e-mail"
                        value="<?= htmlspecialchars($email ?? '') ?>"
                        required
                    >

                </div>

            </div>



            <!-- SENHA -->

            <div class="form-group">

                <label for="senha">
                    Palavra-passe
                </label>


                <div class="input-container">

                    <i class="bi bi-lock"></i>


                    <input
                        type="password"
                        id="senha"
                        name="senha"
                        placeholder="Mínimo 6 caracteres"
                        minlength="6"
                        required
                    >


                    <button
                        type="button"
                        class="password-button"
                        onclick="mostrarSenha('senha', this)"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>



            <!-- CONFIRMAR SENHA -->

            <div class="form-group">

                <label for="confirmar_senha">
                    Confirmar palavra-passe
                </label>


                <div class="input-container">

                    <i class="bi bi-shield-lock"></i>


                    <input
                        type="password"
                        id="confirmar_senha"
                        name="confirmar_senha"
                        placeholder="Repita a palavra-passe"
                        minlength="6"
                        required
                    >


                    <button
                        type="button"
                        class="password-button"
                        onclick="mostrarSenha('confirmar_senha', this)"
                    >

                        <i class="bi bi-eye"></i>

                    </button>

                </div>

            </div>



            <!-- BOTÃO -->

            <button
                type="submit"
                class="cadastro-button"
            >

                <i class="bi bi-person-plus"></i>

                CRIAR CONTA

            </button>


        </form>



        <!-- VOLTAR PARA LOGIN -->

        <div class="cadastro-footer">

            <p>
                Já possui uma conta?
            </p>


            <a href="index.php">

                Voltar para o login

            </a>

        </div>


    </div>



    <script>

        function mostrarSenha(id, botao) {

            const input =
                document.getElementById(id);

            const icon =
                botao.querySelector("i");


            if (input.type === "password") {

                input.type = "text";

                icon.classList.remove("bi-eye");

                icon.classList.add("bi-eye-slash");

            } else {

                input.type = "password";

                icon.classList.remove("bi-eye-slash");

                icon.classList.add("bi-eye");

            }

        }

    </script>


</body>

</html>