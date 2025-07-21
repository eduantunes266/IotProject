

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
$valor_Praia_vigiada = file_get_contents("api/files/Praia_vigiada/valor.txt");
$data_Praia_vigiada = file_get_contents("api/files/Praia_vigiada/data.txt");
$log_Praia_vigiada = file_get_contents("api/files/Praia_vigiada/log.txt");
$nome_Praia_vigiada = file_get_contents("api/files/Praia_vigiada/nome.txt");

//Tempagua - 2
$valor_Tempagua = file_get_contents("api/files/Tempagua/valor.txt");
$data_Tempagua = file_get_contents("api/files/Tempagua/data.txt");
$log_Tempagua = file_get_contents("api/files/Tempagua/log.txt");
$nome_Tempagua = file_get_contents("api/files/Tempagua/nome.txt");

//Vento - 3 
$valor_Vento = file_get_contents("api/files/Vento/valor.txt");
$data_Vento = file_get_contents("api/files/Vento/data.txt");
$log_Vento = file_get_contents("api/files/Vento/log.txt");
$nome_Vento = file_get_contents("api/files/Vento/nome.txt");

//Bandeira - 4 
$valor_Bandeira = file_get_contents("api/files/Bandeira/valor.txt");
$data_Bandeira = file_get_contents("api/files/Bandeira/data.txt");
$log_Bandeira = file_get_contents("api/files/Bandeira/log.txt");
$nome_Bandeira = file_get_contents("api/files/Bandeira/nome.txt");

//ocupação - 5 
$valor_Ocupacao = file_get_contents("api/files/Ocupacao/valor.txt");
$data_Ocupacao = file_get_contents("api/files/Ocupacao/data.txt");
$log_Ocupacao = file_get_contents("api/files/Ocupacao/log.txt");
$nome_Ocupacao = file_get_contents("api/files/Ocupacao/nome.txt");

//Dia_Noite - 6 
$valor_Dia_Noite = file_get_contents("api/files/Dia_Noite/valor.txt");
$data_Dia_Noite = file_get_contents("api/files/Dia_Noite/data.txt");
$log_Dia_Noite = file_get_contents("api/files/Dia_Noite/log.txt");
$nome_Dia_Noite  = file_get_contents("api/files/Dia_Noite/nome.txt");






?>
<!DOCTYPE html>
<html lang="pt"> <!-- Adicionado o atributo lang para especificar o idioma -->
  
<head>
  <meta charset="UTF-8"> <!-- Corrigido para UTF-8 -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="refresh" content="5"> <!-- Atualização automática a cada 5 segundos -->
  <title>Praia Segura</title>





  
  <!-- Links para estilos e Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="Style.css">
</head>
<body>
  <iframe name="hidden_iframe" style="display:none;"></iframe>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <div class="container-fluid">
        <a class="navbar-brand cor" href="#">Praia Segura</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
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
      <div class="row g-4">
        <!-- Temperatura da Água -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center sensor r"><h6>Temperatura da Água: <?php echo $valor_Tempagua ?>ºC</h6></div>
            <div class="card-body text-center">
              <img src="imagens/tempAgua.png" alt="Temperatura da Água" width="100">
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Tempagua?>
              <a href="historico.php?sensor=Tempagua">Histórico</a>
            </div>
          </div>
        </div>

        <!-- Bandeira -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center atuador"><h6>Bandeira: <?php echo $valor_Bandeira ?></h6></div>
            <div class="card-body text-center">
              <?php
               //ifs para imagens 
                if ($valor_Bandeira == "Verde") {
                    echo '<img src="imagens/Bandeira_verde.png" alt="Bandeira Verde" width="100">';
                } elseif ($valor_Bandeira == "Amarela") {
                    echo '<img src="imagens/Bandeira_amarela.png" alt="Bandeira Amarela" width="100">';
                } elseif ($valor_Bandeira == "Vermelha") {
                    echo '<img src="imagens/Bandeira_vermelha.png" alt="Bandeira Vermelha" width="100">';
                }
              ?>
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Bandeira ?>
              <a href="historico.php?sensor=Bandeira">Histórico</a>
            </div>
          </div>
        </div>

        <!-- Velocidade do Vento -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center sensor"><h6>Velocidade do Vento: <?php echo $valor_Vento ?> km/h</h6></div>
            <div class="card-body d-flex justify-content-center">
              <img src="imagens/Vento.png" alt="Velocidade do Vento" width="100">
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Vento ?>
              <a href="historico.php?sensor=Vento">Histórico</a>
            </div>
          </div>
        </div>

        <!-- Praia Vigiada -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center atuador"><h6>Praia Vigiada: <?php echo $valor_Praia_vigiada ?></h6></div>
            <div class="card-body text-center">
              <?php
               //ifs para imagens 
                if ($valor_Praia_vigiada == "Sim") {
                    echo '<img src="imagens/nadador.png" alt="Praia Vigiada" width="100">';
                } elseif ($valor_Praia_vigiada == "Não") {
                    echo '<img src="imagens/semnadador.png" alt="Praia Vigiada" width="100">';
                }
              ?>
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Praia_vigiada ?>
              <a href="historico.php?sensor=Praia_vigiada">Histórico</a>
            </div>
          </div>
        </div>

        <!-- Ocupação -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center sensor"><h6>Ocupação: <?php echo $valor_Ocupacao ?>%</h6></div>
            <div class="card-body text-center">
              <img src="imagens/Ocupacao.png" alt="Ocupação" width="100">
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Ocupacao ?>
              <a href="historico.php?sensor=Ocupacao">Histórico</a>
            </div>
          </div>
        </div>

        <!-- Dia_Noite -->
        <div class="col-sm-4">
          <div class="card">
            <div class="card-header text-center atuador"><h6>Dia/Noite: <?php echo $valor_Dia_Noite ?></h6></div>
            <div class="card-body d-flex justify-content-center">
              <?php
               //ifs para imagens 
                if ($valor_Dia_Noite == "Dia") {
                    echo '<img src="imagens/Dia.png" alt="Dia" width="100">';
                } elseif ($valor_Dia_Noite == "Noite") {
                    echo '<img src="imagens/Noite.png" alt="Noite" width="100">';
                }
              ?>
            </div>
            <div class="card-footer text-center">
              <h6 class="d-inline">Atualização:</h6>
              <?php echo $data_Dia_Noite ?>
              <a href="historico.php?sensor=Dia_Noite">Histórico</a>
            </div>
          </div>
        </div>
      </div>  
    </div>

<iframe name="hidden_iframe" style="display:none;"></iframe>
<!-- Controle de Bandeira -->
<div class="row justify-content-center mt-4">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-header text-center atuador">
        <h6>Definir Bandeira</h6>
      </div>
      <div class="card-body text-center">
        <!-- iframe escondido para post “invisível” -->
        <iframe name="hidden_iframe" style="display:none;"></iframe>

        <!-- Botão Verde -->
        <form method="post" action="api.php" target="hidden_iframe" class="d-inline-block mx-2">
          <input type="hidden" name="valor_Bandeira" value="Verde">
          <input type="hidden" name="data_Bandeira"  value="<?php echo $data_Bandeira ?>">
          <input type="hidden" name="nome_Bandeira"  value="<?php echo htmlspecialchars($nome_Bandeira) ?>">
          <button type="submit" class="btn btn-success">Verde</button>
        </form>

        <!-- Botão Amarela -->
        <form method="post" action="api.php" target="hidden_iframe" class="d-inline-block mx-2">
          <input type="hidden" name="valor_Bandeira" value="Amarela">
          <input type="hidden" name="data_Bandeira"  value="<?php echo $data_Bandeira ?>">
          <input type="hidden" name="nome_Bandeira"  value="<?php echo htmlspecialchars($nome_Bandeira) ?>">
          <button type="submit" class="btn btn-warning">Amarela</button>
        </form>

        <!-- Botão Vermelha -->
        <form method="post" action="api.php" target="hidden_iframe" class="d-inline-block mx-2">
          <input type="hidden" name="valor_Bandeira" value="Vermelha">
          <input type="hidden" name="data_Bandeira"  value="<?php echo $data_Bandeira ?>">
          <input type="hidden" name="nome_Bandeira"  value="<?php echo htmlspecialchars($nome_Bandeira) ?>">
          <button type="submit" class="btn btn-danger">Vermelha</button>
        </form>
      </div>
      <div class="card-footer text-center">
        <h6 class="d-inline">Bandeira atual:</h6>
        <span id="valor_Bandeira"><?php echo htmlspecialchars($valor_Bandeira) ?></span>
      </div>
    </div>
  </div>
</div>




    <!-- Fim dos containers -->
    <!-- Tabela -->
    <div class="container mb-5 mt-5">
      <div class="card">
        <div class="card-header"><h6 class="bold-text">Informações Úteis</h6></div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                
                <th scope="col">Nome</th>
                <th scope="col">Valor</th>
                <th scope="col">Ultima Atualização</th>
                <th scope="col">Estado</th>
              </tr>
            </thead>
            <tbody>
              <!-- Praia Vigiada -->
<tr>
  <th scope="row"><?php echo $nome_Praia_vigiada ?></th> 
  <td><?php echo $valor_Praia_vigiada ?></td>
  <td><?php echo $data_Praia_vigiada ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Praia_vigiada == "Sim") {
          echo '<span class="badge rounded-pill text-bg-success">Sim</span>';
      } elseif ($valor_Praia_vigiada == "Não") {
          echo '<span class="badge rounded-pill text-bg-danger">Não</span>';
      }
    ?>
  </td>




</tr>





<!-- Temperatura da Água -->
<tr>
  <th scope="row"><?php echo $nome_Tempagua ?></th> 
  <td><?php echo $valor_Tempagua ?>ºC</td>
  <td><?php echo $data_Tempagua ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Tempagua < 20) {
          echo '<span class="badge rounded-pill text-bg-primary">Fria</span>';
      } elseif ($valor_Tempagua >= 20 && $valor_Tempagua < 26) {
          echo '<span class="badge rounded-pill text-bg-warning">Morna</span>';
      } elseif ($valor_Tempagua >= 26) {
          echo '<span class="badge rounded-pill text-bg-danger">Quente</span>';
      }
    ?>
  </td>
</tr>

<!-- Velocidade do Vento -->
<tr>
  <th scope="row"><?php echo $nome_Vento ?></th> 
  <td><?php echo $valor_Vento ?> km/h</td>
  <td><?php echo $data_Vento ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Vento < 20) {
          echo '<span class="badge rounded-pill text-bg-success">Baixa</span>';
      } elseif ($valor_Vento >= 20 && $valor_Vento < 40) {
          echo '<span class="badge rounded-pill text-bg-warning">Média</span>';
      } elseif ($valor_Vento >= 40) {
          echo '<span class="badge rounded-pill text-bg-danger">Alta</span>';
      }
    ?>
  </td>
</tr>

<!-- Bandeira -->
<tr>
  <th scope="row"><?php echo $nome_Bandeira ?></th> 
  <td><?php echo $valor_Bandeira ?></td>
  <td><?php echo $data_Bandeira ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Bandeira == "Verde") {
          echo '<span class="badge rounded-pill text-bg-success">Verde</span>';
      } elseif ($valor_Bandeira == "Amarela") {
          echo '<span class="badge rounded-pill text-bg-warning">Amarela</span>';
      } elseif ($valor_Bandeira == "Vermelha") {
          echo '<span class="badge rounded-pill text-bg-danger">Vermelha</span>';
      } else {
          echo '<span class="badge rounded-pill text-bg-secondary">Desconhecida</span>';
      }
    ?>
  </td>
</tr>

<!-- Ocupação -->
<tr>
  <th scope="row"><?php echo $nome_Ocupacao ?></th>
  <td><?php echo $valor_Ocupacao ?>%</td>
  <td><?php echo $data_Ocupacao ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Ocupacao < 30) {
          echo '<span class="badge rounded-pill text-bg-success">Baixa</span>';
      } elseif ($valor_Ocupacao >= 30 && $valor_Ocupacao < 70) {
          echo '<span class="badge rounded-pill text-bg-warning">Média</span>';
      } elseif ($valor_Ocupacao >= 70) {
          echo '<span class="badge rounded-pill text-bg-danger">Alta</span>';
      } else {
          echo '<span class="badge rounded-pill text-bg-secondary">Desconhecida</span>';
      }
    ?>
  </td>
</tr>
              <!-- Dia_Noite -->
<tr>
  <th scope="row"><?php echo $nome_Dia_Noite ?></th> 
  <td><?php echo $valor_Dia_Noite ?></td>
  <td><?php echo $data_Dia_Noite ?></td>
  <td>
    <?php
    //ifs para imagens 
      if ($valor_Dia_Noite == "Dia") {
          echo '<span class="badge bg-warning text-dark">Dia</span>';
      } elseif ($valor_Dia_Noite == "Noite") {
          echo '<span class="badge bg-dark">Noite</span>';
      } else {
          echo '<span class="badge rounded-pill text-bg-secondary">Desconhecida</span>';
      }
    ?>
  </td>
</tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>

</html>


