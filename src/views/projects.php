<?php
// Mock de dados para simular o banco de dados (Fases / Sprints)
$metodologia = $_GET['metodo'] ?? 'sprint'; // 'fase' ou 'sprint'

$tasks = [
    'fase' => [
        ['id' => 1, 'name' => 'Análise de Requisitos', 'start' => 1, 'duration' => 3, 'progress' => 100],
        ['id' => 2, 'name' => 'Desenvolvimento do Core Ada', 'start' => 4, 'duration' => 5, 'progress' => 60],
        ['id' => 3, 'name' => 'Integração de APIs REST', 'start' => 7, 'duration' => 4, 'progress' => 10],
        ['id' => 4, 'name' => 'Testes e Homologação', 'start' => 10, 'duration' => 3, 'progress' => 0]
    ],
    'sprint' => [
        ['id' => 1, 'name' => 'Setup do Provedor de Virtualização', 'start' => 1, 'duration' => 2, 'progress' => 100],
        ['id' => 2, 'name' => 'Interface do Monitor de Filas', 'start' => 3, 'duration' => 4, 'progress' => 80],
        ['id' => 3, 'name' => 'Mapeamento do Ledger Financeiro', 'start' => 5, 'duration' => 3, 'progress' => 30],
        ['id' => 4, 'name' => 'Refatoração da Splash Screen', 'start' => 7, 'duration' => 2, 'progress' => 0]
    ]
];

$risks = [
    ['id' => 1, 'name' => 'Sobrecarga de RAM no Servidor Caseiro', 'prob' => 4, 'imp' => 5, 'mitigation' => 'Adicionar limite de cgroups via Ada.'],
    ['id' => 2, 'name' => 'Queda de Energia Local', 'prob' => 2, 'imp' => 5, 'mitigation' => 'Configurar UPS/No-break com shutdown automático.'],
    ['id' => 3, 'name' => 'Incompatibilidade de Libs no Fedora', 'prob' => 3, 'imp' => 3, 'mitigation' => 'Utilizar compilação estática do GNAT.'],
    ['id' => 4, 'name' => 'Latência de Disco nas VMs', 'prob' => 3, 'imp' => 4, 'mitigation' => 'Alocar discos virtuais em SSD NVMe local.'],
];

$selected_tasks = $tasks[$metodologia];
?>

<div class="space-y-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Projetos & Portfólio</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Gerencie cronogramas, metodologias de ciclo de vida e monitoramento de riscos de infraestrutura.</p>
        </div>
        
        <div class="mt-4 md:mt-0 flex bg-gray-100 dark:bg-gray-700 p-1 rounded-lg">
            <a href="index.php?v=projects&metodo=fase" class="px-4 py-2 text-sm font-medium rounded-md transition-colors <?php echo $metodologia === 'fase' ? 'bg-white dark:bg-gray-600 text-php-purple-dark dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'; ?>">
                Fases (Cascata)
            </a>
            <a href="index.php?v=projects&metodo=sprint" class="px-4 py-2 text-sm font-medium rounded-md transition-colors <?php echo $metodologia === 'sprint' ? 'bg-white dark:bg-gray-600 text-php-purple-dark dark:text-white shadow-sm' : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white'; ?>">
                Sprints (Ágil)
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <div class="xl:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white flex items-center">
                    <span class="w-2.5 h-2.5 bg-php-purple rounded-full mr-2"></span>
                    Cronograma de Execução (Gráfico de Gantt)
                </h2>
                <span class="text-xs font-semibold px-2.5 py-1 rounded bg-indigo-50 dark:bg-indigo-950/40 text-php-purple-dark dark:text-indigo-300 uppercase">
                    Modo: <?php echo $metodologia; ?>
                </span>
            </div>

            <div class="overflow-x-auto">
                <div class="min-w-[600px] space-y-4">
                    <div class="grid grid-cols-12 gap-1 text-center text-xs font-bold text-gray-400 dark:text-gray-500 pb-2 border-b border-gray-100 dark:border-gray-700">
                        <div class="col-span-4 text-left pl-2">Tarefa / Atividade</div>
                        <?php for($i = 1; $i <= 8; $i++): ?>
                            <div class="col-span-1">D<?php echo $i; ?></div>
                        <?php endfor; ?>
                    </div>

                    <?php foreach ($selected_tasks as $task): ?>
                        <div class="grid grid-cols-12 gap-1 items-center py-2 hover:bg-gray-50 dark:hover:bg-gray-700/20 rounded-lg px-2 transition-colors">
                            <div class="col-span-4 pr-4">
                                <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate"><?php echo $task['name']; ?></p>
                                <span class="text-xs text-gray-400"><?php echo $task['progress']; ?>% concluído</span>
                            </div>
                            
                            <div class="col-span-8 grid grid-cols-8 gap-1 h-6 relative bg-gray-100 dark:bg-gray-700/50 rounded-md overflow-hidden">
                                <div style="grid-column: <?php echo $task['start']; ?> / span <?php echo $task['duration']; ?>;" 
                                     class="h-full bg-gradient-to-r from-php-purple to-php-purple-dark rounded-md relative flex items-center pl-2 shadow-inner">
                                    
                                    <div class="absolute left-0 top-0 bottom-0 bg-indigo-900/30 rounded-md transition-all" style="width: <?php echo $task['progress']; ?>%"></div>
                                    
                                    <span class="relative z-10 text-[10px] font-bold text-white shadow-sm">
                                        <?php echo $task['duration'] * 24; ?>h
                                    </span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-6 flex items-center">
                <span class="w-2.5 h-2.5 bg-red-500 rounded-full mr-2"></span>
                Matriz de Risco (Probabilidade × Impacto)
            </h2>

            <div class="flex flex-col items-center">
                <div class="w-full max-w-[240px] aspect-square grid grid-cols-5 gap-1.5 mb-4">
                    <?php 
                    // Desenha a matriz de baixo para cima (Impacto 5 no topo, Probabilidade de 1 a 5 da esquerda para a direita)
                    for ($imp = 5; $imp >= 1; $imp--): 
                        for ($prob = 1; $prob <= 5; $prob++): 
                            $severity = $prob * $imp;
                            // Definição de cores conforme o calor do risco
                            if ($severity >= 15) {
                                $color = 'bg-red-500 text-white';
                            } elseif ($severity >= 8) {
                                $color = 'bg-amber-400 text-gray-900';
                            } else {
                                $color = 'bg-emerald-500 text-white';
                            }

                            // Verifica se existe algum risco cadastrado nessa coordenada
                            $risk_count = 0;
                            foreach ($risks as $risk) {
                                if ($risk['prob'] === $prob && $risk['imp'] === $imp) {
                                    $risk_count++;
                                }
                            }
                    ?>
                            <div class="relative flex items-center justify-center rounded text-[10px] font-bold <?php echo $color; ?> transition-transform hover:scale-110 cursor-pointer shadow-sm" 
                                 title="Impacto: <?php echo $imp; ?> | Probabilidade: <?php echo $prob; ?>">
                                <?php if ($risk_count > 0): ?>
                                    <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-gray-900 text-[8px] text-white ring-1 ring-white">
                                        <?php echo $risk_count; ?>
                                    </span>
                                <?php endif; ?>
                                <?php echo $prob; ?>x<?php echo $imp; ?>
                            </div>
                    <?php 
                        endfor;
                    endfor; 
                    ?>
                </div>
                <p class="text-[10px] text-gray-400 dark:text-gray-500 mb-6 text-center">Eixo X: Probabilidade | Eixo Y: Impacto</p>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700">
        <h3 class="text-md font-bold text-gray-900 dark:text-white mb-4">Lista de Riscos e Planos de Mitigação</h3>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-300">
                    <tr>
                        <th class="px-6 py-3">Risco</th>
                        <th class="px-6 py-3 text-center">Probabilidade</th>
                        <th class="px-6 py-3 text-center">Impacto</th>
                        <th class="px-6 py-3">Mitigação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($risks as $risk): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/30">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white"><?php echo $risk['name']; ?></td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-xs font-semibold"><?php echo $risk['prob']; ?> / 5</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-xs font-semibold"><?php echo $risk['imp']; ?> / 5</span>
                            </td>
                            <td class="px-6 py-4 text-xs italic text-gray-600 dark:text-gray-300"><?php echo $risk['mitigation']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>