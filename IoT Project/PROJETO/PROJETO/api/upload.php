<?php

header('Content-Type: text/html; charset=utf-8');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['imagem'])) {
        print_r($_FILES['imagem']);
        move_uploaded_file($_FILES['imagem']['tmp_name'], 'images/webcam.jpg');
    } else {
        echo 'Erro. Nenhum campo de imagem.';
    }
} else {
    http_response_code(400);
}
?>