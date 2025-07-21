<?php
session_start(); // Inicia a sessão
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    // Redireciona para a página de login se não estiver autenticado
    header("Location: index.php");
    exit(); // Encerra o script para evitar que o restante do código seja executado
}
?>
<?php
//Praia_vigiada - 1 





?>
<!DOCTYPE html>
<html lang="pt"> <!-- Adicionado o atributo lang para especificar o idioma -->

<head>
    <meta charset="UTF-8"> <!-- Corrigido para UTF-8 -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5"> <!-- Atualização automática a cada 5 segundos -->
    <title>Praia Segura</title>






    <!-- Links para estilos e Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="Style.css">
</head>

<body>
    <iframe name="hidden_iframe" style="display:none;"></iframe>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand cor" href="#">Praia Segura</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="dashboard.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="historico.php">Histórico</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="camara.php">Câmara de Vigilância</a>
                    </li>
                </ul>
                <a href="logout.php" class="btn btn-outline-danger ms-auto">Logout</a>
            </div>
        </div>
    </nav>
    <!--Fim Navbar -->
    <!--Inicio dos containers -->
   <div class="container mt-4">
    <div class="row g-4 justify-content-center"> <!-- adicionado justify-content-center -->
        <!-- Temperatura da Água -->
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-center sensor r">
                    <h6>Camera:</h6>
                </div>
                <div class="card-body text-center">
                    <?php echo "<img src='api/images/webcam.jpg?id=" . time() . "' style='width:100%'>"; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

</body>

</html>