<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <div>
        <h1 class="text-3xl font-light text-gray-800 dark:text-gray-100">Construtor de Automações</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Arraste os nós, crie conexões e monte réguas de automação para o Core Ada.</p>
    </div>
    <div class="flex items-center gap-3">
        <button onclick="exportarFluxo()" class="bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-600 px-4 py-2 rounded-lg font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition shadow-sm">
            Exportar JSON
        </button>
        <button onclick="limparCanvas()" class="border border-red-300 dark:border-red-900 text-red-600 dark:text-red-400 px-4 py-2 rounded-lg font-medium hover:bg-red-50 dark:hover:bg-red-900/20 transition">
            Limpar
        </button>
    </div>
</div>

<div class="grid grid-cols-1 xl:grid-cols-5 gap-6 h-[calc(100vh-220px)] min-h-[500px]">
    
    <div class="xl:col-span-1 bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex flex-col overflow-hidden">
        <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Componentes</span>
        </div>
        <div class="p-4 flex-1 overflow-y-auto space-y-4">
            <div>
                <h3 class="text-xs font-semibold uppercase text-green-600 dark:text-green-400 mb-2">Gatilhos (Triggers)</h3>
                <div class="p-3 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-300 rounded-lg text-sm font-medium cursor-grab active:cursor-grabbing select-none" 
                     draggable="true" ondragstart="handleDragStart(event, 'TRIGGER', 'On File Upload', 'green')">
                    ⚡ On File Upload
                </div>
            </div>
            
            <div>
                <h3 class="text-xs font-semibold uppercase text-php-purple dark:text-indigo-400 mb-2">Ações do Core (Ada)</h3>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 text-php-purple dark:text-purple-300 rounded-lg text-sm font-medium cursor-grab active:cursor-grabbing select-none mb-2" 
                     draggable="true" ondragstart="handleDragStart(event, 'ACTION', 'Persist Metadata', 'php-purple')">
                    ⚙️ Persist Metadata
                </div>
                <div class="p-3 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 text-php-purple dark:text-purple-300 rounded-lg text-sm font-medium cursor-grab active:cursor-grabbing select-none" 
                     draggable="true" ondragstart="handleDragStart(event, 'ACTION', 'Resize Image Task', 'php-purple')">
                    🖼️ Resize Image Task
                </div>
            </div>
        </div>
    </div>

    <div id="canvas-container" 
         class="xl:col-span-4 bg-gray-50 dark:bg-gray-950 border border-gray-200 dark:border-gray-800 rounded-xl relative overflow-hidden select-none shadow-inner"
         onargover="event.preventDefault()" 
         ondragover="allowDrop(event)" 
         ondrop="handleDrop(event)"
         style="background-size: 24px 24px; background-image: radial-gradient(circle, #d1d5db 1px, transparent 1px); html-tag.dark & { background-image: radial-gradient(circle, #374151 1px, transparent 1px); }">
        
        <svg id="svg-connections" class="absolute inset-0 w-full h-full pointer-events-none z-0">
            <defs>
                <marker id="arrow" viewBox="0 0 10 10" refX="6" refY="5" markerWidth="6" markerHeight="6" orient="auto-start-reverse">
                    <path d="M 0 1 L 10 5 L 0 9 z" fill="#777BB4" />
                </marker>
            </defs>
        </svg>

        </div>
</div>

<script>
let dragData = null;
let nodes = [];
let connections = [];
let activeConnectionSource = null;
let draggedElement = null;
let offsetX = 0;
let offsetY = 0;

function handleDragStart(e, type, title, colorClass) {
    dragData = { type, title, colorClass };
}

function allowDrop(e) {
    e.preventDefault();
}

function handleDrop(e) {
    e.preventDefault();
    if (!dragData) return;

    const container = document.getElementById('canvas-container');
    const rect = container.getBoundingClientRect();
    
    // Calcula posição relativa interna do Canvas
    const x = e.clientX - rect.left - 100; 
    const y = e.clientY - rect.top - 40;

    criarNoNoCanvas(dragData.type, dragData.title, dragData.colorClass, x, y);
    dragData = null;
}

function criarNoNoCanvas(type, title, colorClass, x, y) {
    const id = 'node_' + Date.now();
    const nodeObj = { id, type, title, colorClass, x, y };
    nodes.push(nodeObj);

    const canvas = document.getElementById('canvas-container');
    const nodeEl = document.createElement('div');
    nodeEl.id = id;
    nodeEl.style.left = x + 'px';
    nodeEl.style.top = y + 'px';
    nodeEl.className = `absolute bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg p-4 w-52 z-10 cursor-move border-l-4 ${type === 'TRIGGER' ? 'border-l-green-500' : 'border-l-php-purple'}`;
    
    nodeEl.innerHTML = `
        <div class="flex justify-between items-center pb-1 mb-2 border-b border-gray-100 dark:border-gray-700 text-xs font-bold uppercase ${type === 'TRIGGER' ? 'text-green-600' : 'text-php-purple'}">
            <span>${type}</span>
            <button onclick="removerNo('${id}')" class="text-gray-400 hover:text-red-500 transition">✕</button>
        </div>
        <h4 class="font-semibold text-sm text-gray-900 dark:text-white">${title}</h4>
        
        ${type !== 'TRIGGER' ? `<div class="absolute -left-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-gray-200 dark:bg-gray-700 border-2 border-gray-400 dark:border-gray-500 rounded-full cursor-pointer target-point" data-node="${id}"></div>` : ''}
        <div class="absolute -right-2 top-1/2 -translate-y-1/2 w-4 h-4 bg-white dark:bg-gray-800 border-2 ${type === 'TRIGGER' ? 'border-green-500' : 'border-php-purple'} rounded-full cursor-pointer source-point" data-node="${id}"></div>
    `;

    // Eventos para arrastar o Nó dentro do Canvas
    nodeEl.addEventListener('pointerdown', function(e) {
        if (e.target.classList.contains('source-point') || e.target.classList.contains('target-point') || e.target.tagName === 'BUTTON') return;
        draggedElement = nodeEl;
        const style = window.getComputedStyle(nodeEl);
        offsetX = e.clientX - parseInt(style.left);
        offsetY = e.clientY - parseInt(style.top);
        nodeEl.setPointerCapture(e.pointerId);
    });

    nodeEl.addEventListener('pointermove', function(e) {
        if (draggedElement !== nodeEl) return;
        const container = document.getElementById('canvas-container');
        const rect = container.getBoundingClientRect();
        
        let targetX = e.clientX - offsetX;
        let targetY = e.clientY - offsetY;

        // Limita as bordas do Canvas
        targetX = Math.max(10, Math.min(targetX, rect.width - 220));
        targetY = Math.max(10, Math.min(targetY, rect.height - 100));

        nodeEl.style.left = targetX + 'px';
        nodeEl.style.top = targetY + 'px';

        // Atualiza a posição no array de estados
        const current = nodes.find(n => n.id === id);
        if (current) { current.x = targetX; current.y = targetY; }

        renderizarConexoes();
    });

    nodeEl.addEventListener('pointerup', function(e) {
        if (draggedElement === nodeEl) {
            nodeEl.releasePointerCapture(e.pointerId);
            draggedElement = null;
        }
    });

    canvas.appendChild(nodeEl);

    // Configura eventos para criar conexões clicando nas bolinhas
    nodeEl.querySelector('.source-point').addEventListener('click', function(e) {
        e.stopPropagation();
        activeConnectionSource = id;
        document.querySelectorAll('.target-point').forEach(el => el.classList.add('animate-ping'));
    });

    if (type !== 'TRIGGER') {
        nodeEl.querySelector('.target-point').addEventListener('click', function(e) {
            e.stopPropagation();
            if (activeConnectionSource && activeConnectionSource !== id) {
                // Evita duplicados
                if (!connections.some(c => c.from === activeConnectionSource && c.to === id)) {
                    connections.push({ from: activeConnectionSource, to: id });
                    renderizarConexoes();
                }
            }
            limparEstadoConexao();
        });
    }
}

function renderizarConexoes() {
    const svg = document.getElementById('svg-connections');
    // Mantém o marker e limpa apenas as linhas anteriores
    svg.innerHTML = svg.querySelector('defs').outerHTML;

    connections.forEach(conn => {
        const fromEl = document.getElementById(conn.from);
        const toEl = document.getElementById(conn.to);
        if (!fromEl || !toEl) return;

        const fromRect = fromEl.getBoundingClientRect();
        const toRect = toEl.getBoundingClientRect();
        const containerRect = document.getElementById('canvas-container').getBoundingClientRect();

        // Encontra o centro exato dos botões de ancoragem laterais
        const x1 = fromRect.right - containerRect.left;
        const y1 = fromRect.top + (fromRect.height / 2) - containerRect.top;
        
        const x2 = toRect.left - containerRect.left;
        const y2 = toRect.top + (toRect.height / 2) - containerRect.top;

        // Cria uma curva Bézier suave cúbica (estilo n8n/Fiori)
        const controlOffset = Math.abs(x2 - x1) * 0.5;
        const d = `M ${x1} ${y1} C ${x1 + controlOffset} ${y1}, ${x2 - controlOffset} ${y2}, ${x2} ${y2}`;

        const path = document.createElementNS('http://www.w3.org/2000/svg', 'path');
        path.setAttribute('d', d);
        path.setAttribute('stroke', document.documentElement.classList.contains('dark') ? '#4F5B93' : '#777BB4');
        path.setAttribute('stroke-width', '3');
        path.setAttribute('fill', 'none');
        path.setAttribute('marker-end', 'url(#arrow)');
        svg.appendChild(path);
    });
}

function limparEstadoConexao() {
    activeConnectionSource = null;
    document.querySelectorAll('.target-point').forEach(el => el.classList.remove('animate-ping'));
}

// Cancela a conexão se clicar no fundo do Canvas
document.getElementById('canvas-container').addEventListener('click', limparEstadoConexao);

function removerNo(id) {
    // Remove as conexões vinculadas ao nó
    connections = connections.filter(c => c.from !== id && c.to !== id);
    // Remove o nó do estado
    nodes = nodes.filter(n => n.id !== id);
    // Remove do DOM
    const el = document.getElementById(id);
    if (el) el.remove();
    renderizarConexoes();
}

function limparCanvas() {
    nodes = [];
    connections = [];
    document.querySelectorAll('[id^="node_"]').forEach(el => el.remove());
    renderizarConexoes();
}

function exportarFluxo() {
    if (nodes.length === 0) {
        alert("O canvas está vazio! Adicione alguns nós antes de salvar.");
        return;
    }

    const pipeline = {
        total_nodes: nodes.length,
        structure: nodes.map(n => ({
            id: n.id,
            tipo: n.type,
            acao: n.title,
            proximos: connections.filter(c => c.from === n.id).map(c => c.to)
        }))
    };

    // Comunicação real com o backend PHP e Ada
    const formData = new FormData();
    formData.append('acao', 'salvar_workflow');
    formData.append('estrutura_json', JSON.stringify(pipeline));

    fetch('actions.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'ok') {
            alert("Workflow gravado com sucesso no Core Ada e persistido no PostgreSQL!");
        } else {
            alert("Erro ao salvar workflow: " + data.mensagem);
        }
    })
    .catch(error => {
        console.error('Erro na requisição:', error);
        alert("Falha crítica ao conectar com o servidor.");
    });
}
</script>