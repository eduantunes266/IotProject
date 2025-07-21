<?php
session_start(); // Inicia a sessão

// Verifica se o usuário está logado
if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    echo "<script>
        alert('Acesso negado! Você precisa estar logado para sair.');
        window.location.href = 'index.php';
    </script>";
    exit();
}

// Remove todas as variáveis de sessão e destrói a sessão
session_unset();
session_destroy();

// Redireciona para a página de login
header("refresh:0;url=index.php");
exit();
?>