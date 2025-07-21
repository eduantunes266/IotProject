<!doctype html>
<html lang="pt"> <!-- Adicionado o atributo lang -->
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="logo-container">
        <a href="https://www.ipleiria.pt/estg/">
            <img src="imagens/Ri.png" alt="ESTG Logo" class="img-fluid" style="width: 350px;">
        </a>

        <?php
        session_start(); // Inicia a sessão
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            // Verifica as credenciais
            if ($username === 'edu' && $password === '1234' || ($username === 'admin' && $password === 'admin')) {
                $_SESSION['username'] = $username; // Armazena o nome do usuário na sessão
                echo '<div style="position:fixed;top:50%;left:50%;transform:translate(-50%, -50%);font-size:20px;color:green;background:white;padding:10px;border-radius:5px;">Login bem-sucedido!</div>';
                header("refresh:2;url=dashboard.php"); // Redireciona para o dashboard
                exit;
            } else {
                echo '<div class="alert alert-danger">Credenciais inválidas!</div>';
            }
        }
        ?>
    </div>

    <div class="container-fluid vh-100">
        <div class="row h-100">
            <!-- Coluna Esquerda -->
            <div class="col-md-4 d-flex flex-column justify-content-start align-items-center login-container">
                <!-- Imagem mais próxima do topo -->
                <div class="text-center mb-4" style="margin-top: 10px;">
                    <img src="imagens/Logo_nav.png" alt="Imagem Acima" class="img-fluid" style="max-width: 100%; height: auto;">
                </div>
                <!-- Formulário -->
                <div class="login-container w-100 px-4" style="margin-top: 20px;">
    <form method="post" action="index.php"> <!-- Corrigido o atributo action -->
        <div class="mb-3 text-start">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Insira o seu username" required>
        </div>
        <div class="mb-3 text-start">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Insira a sua password" required>
        </div>
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary btn-sm w-auto">Entrar</button>
        </div>
    </form>
</div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>