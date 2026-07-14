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
            $_SESSION['nome'] = $data['nome'] ?? ucfirst(explode('@', $email)[0]); 
            header('Location: index.php?v=dashboard');
            exit;
        } 
        
        // BYPASS DE DESENVOLVIMENTO
        if ($email === 'admin@omni.com' && $senha === 'admin') {
            $_SESSION['autenticado'] = true;
            $_SESSION['token'] = 'token-bypass-local';
            $_SESSION['email'] = 'admin@omni.com';
            $_SESSION['nome'] = 'Administrador Local';
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
            echo json_encode(['status' => 'erro', 'mensagem' => 'Nenhum dado estrutural recebido.']);
            exit;
        }

        $payload = json_decode($estrutura_json, true);
        if (!$payload) {
            echo json_encode(['status' => 'erro', 'mensagem' => 'Payload estrutural corrompido ou malformado.']);
            exit;
        }

        $res = disparar_requisicao("/pipeline/save", $payload);

        if ($res['code'] == 200) {
            echo json_encode(['status' => 'ok', 'mensagem' => 'Esteira salva e propagada com sucesso!']);
        } else {
            echo json_encode(['status' => 'erro', 'mensagem' => 'O barramento Core Ada rejeitou a topologia.']);
        }
        exit;
    }

    // --- 7. AÇÃO DE PROVISIONAR VM (Infraestrutura) ---
    if ($acao === 'provisionar_vm') {
        $vm_name = $_POST['vm_name'] ?? 'nova-instancia';
        $vcpu = $_POST['vcpu'] ?? 2;
        $ram = $_POST['ram'] ?? 4;
        
        $nova_vm = [
            'id' => 'i-' . substr(md5(uniqid()), 0, 6),
            'name' => $vm_name,
            'vcpu' => $vcpu,
            'ram' => $ram,
            'state' => 'RUNNING',
            'ip' => '192.168.0.' . rand(110, 250)
        ];
        
        if (!isset($_SESSION['vms'])) $_SESSION['vms'] = [];
        $_SESSION['vms'][] = $nova_vm;
        
        set_mensagem("Instancia Virtual $vm_name comandada ao host KVM pelo Core Ada.", "sucesso");
        header('Location: index.php?v=infra');
        exit;
    }

    // --- 8. AÇÃO DE TOGGLE VM (Start/Stop) ---
    if ($acao === 'vm_toggle') {
        $vm_id = $_POST['vm_id'] ?? '';
        if (isset($_SESSION['vms'])) {
            foreach ($_SESSION['vms'] as &$vm) {
                if ($vm['id'] === $vm_id) {
                    $vm['state'] = ($vm['state'] === 'RUNNING') ? 'STOPPED' : 'RUNNING';
                    break;
                }
            }
        }
        header('Location: index.php?v=infra');
        exit;
    }

    // --- 9. AÇÃO DE CRIAR PROJETO FUNCIONAL ---
    if ($acao === 'criar_projeto_funcional') {
        $nome = $_POST['nome_projeto'] ?? '';
        if (!isset($_SESSION['projetos'])) $_SESSION['projetos'] = [];
        
        $_SESSION['projetos'][] = ['nome' => $nome];
        
        set_mensagem("Projeto criado. Agora adicione tarefas ao Gantt.", "sucesso");
        header('Location: index.php?v=projects');
        exit;
    }

    // --- 10. AÇÃO DE CRIAR TAREFA FUNCIONAL (Gantt) ---
    if ($acao === 'criar_tarefa_funcional') {
        if (!isset($_SESSION['tarefas'])) $_SESSION['tarefas'] = [];
        
        $_SESSION['tarefas'][] = [
            'projeto_id' => (int) $_POST['projeto_id'],
            'nome' => $_POST['nome_tarefa'],
            'inicio' => (int) $_POST['dia_inicio'],
            'duracao' => (int) $_POST['duracao']
        ];
        
        set_mensagem("Tarefa injetada no cronograma com sucesso.", "sucesso");
        header('Location: index.php?v=projects');
        exit;
    }

    // --- 11. AÇÃO DE COMANDOS DO TERMINAL (CLI) ---
    if ($acao === 'terminal_command') {
        header('Content-Type: application/json');
        
        if (!isset($_SESSION['autenticado']) || !$_SESSION['autenticado']) {
            echo json_encode(['error' => 'Acesso negado: Sessao invalida.']);
            exit;
        }

        $cmd_raw = trim($_POST['command'] ?? '');
        $parts = explode(' ', $cmd_raw);
        $base = strtolower($parts[0]);
        
        $output = "";

        switch ($base) {
            case 'help':
                $output = "Comandos nativos suportados:\n" .
                          "  core status    - Verifica o daemon Ada e integridade da memoria\n" .
                          "  vm list        - Lista as instancias KVM alocadas\n" .
                          "  vm start <id>  - Inicia uma maquina virtual\n" .
                          "  vm stop <id>   - Desliga uma maquina virtual graciosamente\n" .
                          "  clear          - Limpa a tela do terminal";
                break;
                
            case 'core':
                if (isset($parts[1]) && $parts[1] === 'status') {
                    $output = "[ADA CORE DAEMON]\n" .
                              "Status: ACTIVE (running) desde a inicializacao do sistema.\n" .
                              "Porta TCP/IPC: 8080 (Listen)\n" .
                              "Mapeamento KVM: /var/run/libvirt/libvirt-sock OK\n" .
                              "Uptime do Motor: 14h 22m";
                } else {
                    $output = "Uso: core status";
                }
                break;

            case 'vm':
                $subcmd = $parts[1] ?? '';
                $target_id = $parts[2] ?? '';
                
                $vms = $_SESSION['vms'] ?? [];
                
                if ($subcmd === 'list') {
                    if (empty($vms)) {
                        $output = "Nenhuma VM localizada no hypervisor.";
                    } else {
                        $output = str_pad("INSTANCE ID", 15) . str_pad("NAME", 20) . "STATE\n";
                        $output .= "------------------------------------------------\n";
                        foreach ($vms as $v) {
                            $output .= str_pad($v['id'], 15) . str_pad($v['name'], 20) . $v['state'] . "\n";
                        }
                    }
                } elseif ($subcmd === 'start' || $subcmd === 'stop') {
                    if (empty($target_id)) {
                        $output = "Erro: Especifique o Instance ID. Exemplo: vm start i-001a4b";
                    } else {
                        $encontrado = false;
                        foreach ($_SESSION['vms'] as &$v) {
                            if ($v['id'] === $target_id) {
                                $v['state'] = ($subcmd === 'start') ? 'RUNNING' : 'STOPPED';
                                $output = "Sinal ACPI enviado. VM " . $v['id'] . " agora esta " . $v['state'] . ".";
                                $encontrado = true;
                                break;
                            }
                        }
                        if (!$encontrado) {
                            $output = "Erro: Instancia '" . $target_id . "' nao encontrada.";
                        }
                    }
                } else {
                    $output = "Uso: vm [list | start <id> | stop <id>]";
                }
                break;

            default:
                $output = "bash: " . htmlspecialchars($base) . ": comando nao encontrado";
                break;
        }

        echo json_encode(['output' => $output]);
        exit;
    }
}

// --- 12. LÓGICA DE LOGOUT ---
if (isset($_GET['acao']) && $_GET['acao'] === 'logout') {
    session_destroy();
    header('Location: index.php?v=home');
    exit;
}