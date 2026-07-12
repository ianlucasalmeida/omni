<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT', dirname(__DIR__));
define('BASE_URL', 'http://localhost:3000');
define('ADA_API', 'http://localhost:8080');

function disparar_requisicao($endpoint, $payload = []) {
    $ch = curl_init(ADA_API . $endpoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    
    $token = $_SESSION['token'] ?? '';
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $token
    ]);
    
    $res = curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    return ['code' => $code, 'body' => $res];
}

function set_mensagem($texto, $tipo = "info") {
    $_SESSION['flash'] = ['text' => $texto, 'type' => $tipo];
}

function get_mensagem() {
    if (isset($_SESSION['flash'])) {
        $msg = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $msg;
    }
    return null;
}