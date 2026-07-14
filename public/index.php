<?php
require_once __DIR__ . '/../src/config.php';

$v = $_GET['v'] ?? 'home';
$logado = $_SESSION['autenticado'] ?? false;

// Inclusão da rota orchestration e users no array de segurança
$rotas_protegidas = ['dashboard', 'finance', 'storage', 'customers', 'products', 'orchestration', 'workflow', 'users', 'projects', 'infra', 'terminal'];
if (in_array($v, $rotas_protegidas) && !$logado) { 
    header('Location: index.php?v=login'); 
    exit; 
}

$view_path = ROOT . "/src/views/$v.php";

if (!file_exists($view_path)) {
    $v = 'home';
    $view_path = ROOT . "/src/views/home.php";
}

// Direcionamento de Layouts Mestre
if (in_array($v, ['login', 'register'])) {
    require_once ROOT . '/src/templates/auth.php';
} elseif (in_array($v, ['home', 'sobre', 'contato'])) { // <-- 'contato' adicionado aqui
    require_once ROOT . '/src/templates/public.php';
} else {
    require_once ROOT . '/src/templates/app.php';
}