<?php
require_once __DIR__ . '/../src/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $acao = $_POST['acao'] ?? '';
    
    // --- 1. AÇÃO DE LOGIN ---
    if ($acao === 'login') {
        $email = $_POST['email'] ?? '';
        $senha = $_POST['password'] ?? '';

        $res = disparar_requisicao("/login", ['u' => $email, 'p' => $senha]);
        
        if ($res['code'] == 200) {
            $data = json_decode($res['body'], true);
            $_SESSION['autenticado'] = true;
            $_SESSION['token'] = $data['token'] ?? '';
            $_SESSION['email'] = $email;
            // Pega o nome do payload do banco ou deriva a primeira parte do email
            $_SESSION['nome'] = $data['nome'] ?? ucfirst(explode('@', $email)[0]); 
            header('Location: index.php?v=dashboard');
            exit;
        } 
        
        // BYPASS DE DESENVOLVIMENTO
        if ($email === 'admin@omni.com' && $senha === 'admin') {
            $_SESSION['autenticado'] = true;
            $_SESSION['token'] = 'token-bypass-local';
            $_SESSION['email'] = 'admin@omni.com';
            $_SESSION['nome'] = 'Administrador Local'; // O nome de exibição fica aqui
            header('Location: index.php?v=dashboard');
            exit;
        }

        set_mensagem("Erro " . $res['code'] . " no Core Ada. Credenciais invalidas ou motor offline.", "erro");
        header('Location: index.php?v=login');
        exit;
    }
    
    // --- 2. AÇÃO DE REGISTRO ---
    if ($acao === 'register') {
        set_mensagem("Conta criada! Autentique-se para gerar seu Token.", "sucesso");
        header('Location: index.php?v=login');
        exit;
    }

    // --- 3. AÇÃO DE UPLOAD CLOUD ---
    if ($acao === 'upload_arquivo') {
        if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
            header('Location: index.php?v=login');
            exit;
        }

        if (isset($_FILES['documento']) && $_FILES['documento']['error'] === UPLOAD_ERR_OK) {
            $file_tmp  = $_FILES['documento']['tmp_name'];
            $file_name = basename($_FILES['documento']['name']);
            $file_size = $_FILES['documento']['size'];
            
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $dest_path = $upload_dir . time() . '_' . $file_name;

            if (move_uploaded_file($file_tmp, $dest_path)) {
                
                // CORREÇÃO APLICADA: Enviamos apenas os METADADOS. Removido o base64_encode.
                $payload = [
                    'usuario'        => $_SESSION['email'],
                    'nome_arquivo'   => $file_name,
                    'tamanho_bytes'  => $file_size,
                    'caminho_fisico' => $dest_path
                ];

                $res = disparar_requisicao("/storage/upload", $payload);

                if ($res['code'] == 200) {
                    set_mensagem("Arquivo enviado e catalogado no PostgreSQL com sucesso!", "sucesso");
                } else {
                    set_mensagem("Arquivo salvo localmente, mas rejeitado pelo Core Ada (Status " . $res['code'] . ").", "erro");
                }
            } else {
                set_mensagem("Erro ao mover o arquivo para o diretorio de uploads.", "erro");
            }
        } else {
            set_mensagem("Nenhum arquivo enviado ou erro no upload.", "erro");
        }

        header('Location: index.php?v=storage');
        exit;
    }

    // --- 4. AÇÃO DE ATUALIZAR PERFIL E AVATAR ---
    if ($acao === 'update_profile') {
        $novo_nome = $_POST['nome'] ?? $_SESSION['nome'];
        $_SESSION['nome'] = $novo_nome;

        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $avatar_name = 'avatar_' . time() . '.' . $ext;
            
            $upload_dir = __DIR__ . '/uploads/';
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $dest_path = $upload_dir . $avatar_name;

            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $dest_path)) {
                $_SESSION['avatar'] = 'uploads/' . $avatar_name;
                set_mensagem("Perfil e foto updated com sucesso.", "sucesso");
            } else {
                set_mensagem("Erro ao salvar a imagem.", "erro");
            }
        } else {
            set_mensagem("Perfil atualizado com sucesso.", "sucesso");
        }
        
        header('Location: index.php?v=users');
        exit;
    }

    // --- 5. AÇÃO DE SALVAR PIPELINE / WORKFLOW ---
    if ($acao === 'salvar_workflow') {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Sessão inválida ou expirada.']);
            exit;
        }

        $estrutura_json = $_POST['estrutura_json'] ?? '';
        if (empty($estrutura_json)) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Nenhum dado estrutural recebido do Canvas.']);
            exit;
        }

        // Converte para um array associativo PHP e valida a formatação
        $payload = json_decode($estrutura_json, true);
        if (!$payload) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Payload estrutural corrompido ou malformado.']);
            exit;
        }

        // Transmite o mapa completo dos nós conectados para o motor transacional Ada
        $res = disparar_requisicao("/pipeline/save", $payload);

        if ($res['code'] == 200) {
            echo json_encode(['status' => 'ok', 'mensagem' => 'Esteira salva e propagada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'O barramento Core Ada rejeitou a topologia (Status ' . $res['code'] . ').']);
        }
        exit;
    }
}

// --- 6. LÓGICA DE LOGOUT ---
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    session_destroy();
    header('Location: index.php?v=home');
    exit;
}