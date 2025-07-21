<?php

header('Content-Type: text/html; charset=utf-8');

echo "O método HTTP utilizado é: " . $_SERVER['REQUEST_METHOD'] . "<pt>";

$base = "api/files";

// Lista todas as pastas de sensores existentes
$sensores = array_filter(glob("$base/*"), 'is_dir');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    echo "recebi um POST<br>";

    foreach ($sensores as $pasta) {
        $sensor = basename($pasta);

        // Prefixo dos campos enviados via POST
        $prefixo = ($sensor === "Dia_Noite") ? "Dia" : $sensor;

        $valor = $_POST["valor_$prefixo"] ?? null;
        $data  = $_POST["data_$prefixo"] ?? null;
        $nome  = $_POST["nome_$prefixo"] ?? null;

        if ($valor !== null && $data !== null && $nome !== null) {
            file_put_contents("$pasta/valor.txt", $valor, LOCK_EX);
            file_put_contents("$pasta/data.txt", $data, LOCK_EX);
            file_put_contents("$pasta/nome.txt", $nome, LOCK_EX);

            $linha_log = "$data;$valor\n";
            file_put_contents("$pasta/log.txt", $linha_log, FILE_APPEND | LOCK_EX);
        }
    }

    echo "Dados gravados com sucesso.";

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    echo "recebi um GET<pt>";

    if (isset($_GET["nome"])) {
        $sensor = $_GET["nome"];
        $arquivo = "$base/$sensor/valor.txt";

        if (file_exists($arquivo)) {
            $valor = file_get_contents($arquivo);
            echo "Valor do sensor $sensor: $valor";
        } else {
            echo "Erro: Sensor '$sensor' não encontrado.";
        }
    } else {
        echo "Erro: parâmetro 'nome' ausente no GET.";
    }

} else {
    echo "Método não permitido.";
}




?>


