<?php
// historico.php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<script>
        alert('Você precisa estar logado para acessar esta página.');
        window.location.href = 'index.php';
    </script>";
    exit();
}


// Função para exibir o histórico de um sensor
function exibirHistorico($sensor) {
    // Mapeamento de nomes amigáveis para os sensores
    $nomes_sensores = [
        "Praia_vigiada" => "Praia Vigiada",
        "Tempagua" => "Temperatura da Água",
        "Vento" => "Velocidade do Vento",
        "Bandeira" => "Bandeira",
        "Ocupacao" => "Ocupação",
        "Dia_Noite" => "Dia/Noite"
    ];

    $caminho_log = "api/files/" . ucfirst($sensor) . "/log.txt"; // Caminho do arquivo de log
    if (file_exists($caminho_log)) {

        $conteudo = file_get_contents($caminho_log);
        $nome_amigavel = $nomes_sensores[$sensor] ?? ucfirst($sensor); // Nome amigável ou padrão
        echo "<h3>Histórico do sensor: " . $nome_amigavel . "</h3>";
        echo "<pre style='background: #f4f4f4; padding: 10px; border: 1px solid #ddd;'>$conteudo</pre>";
    } else {
        echo "<p style='color: red;'>Histórico para o sensor $sensor não encontrado.</p>";
        echo $caminho_log; 
    }
}
?>

<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Histórico de Sensores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="StyleHistorico.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light Navbar-container">
        <div class="container-fluid ">
            <a class="navbar-brand" href="#">
    <img src="imagens/nadador.png" alt="Praia Segura" style="height: 40px;">
</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                </ul>
                <a href="logout.php" class="btn btn-outline-danger ms-auto ">Logout</a>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
    <div class="d-inline-block p-3 Opcao-container rounded shadow">
        <h1>Escolha um sensor para ver o <br>Histórico</h1>
        <form method="get" >
            <select name="sensor" class="form-select">
                <option value="" selected disabled>Selecione uma opção</option>
                <option value="Praia_vigiada">Praia Vigiada</option>
                <option value="Tempagua">Temperatura da Água</option>
                <option value="Vento">Velocidade do Vento</option>
                <option value="Bandeira">Bandeira</option>
                <option value="Ocupacao">Ocupação</option>
                <option value="Dia_Noite">Dia/Noite</option>
            </select>
            <button type="submit" class="btn btn-primary mt-3">Ver Histórico</button>
        </form>

        <?php
        // Verifica se um sensor foi selecionado
        if (isset($_GET['sensor'])) {
            $sensor = $_GET['sensor'];
            exibirHistorico($sensor);
        }
        ?>
    </div>
</div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>