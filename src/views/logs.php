<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-light text-gray-800 dark:text-gray-100">Live Logs Inspector</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Escuta assíncrona do daemon Core Ada, KVM e banco de dados.</p>
    </div>
    <div>
        <button id="btn-tail" onclick="toggleTailing()" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center">
            <span id="tail-dot" class="w-2 h-2 bg-white rounded-full animate-pulse mr-2"></span>
            <span id="tail-text">Tailing: ON</span>
        </button>
    </div>
</div>

<div class="bg-[#0b0b0b] rounded-xl shadow-2xl border border-gray-700 overflow-hidden h-[600px] flex flex-col font-mono text-sm relative">
    
    <div class="bg-[#1a1a1a] px-4 py-2 flex justify-between items-center border-b border-gray-800 text-xs text-gray-400">
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            /var/log/omni/core-daemon.log
        </span>
        <span>Auto-scroll <span class="text-green-500">ativo</span></span>
    </div>

    <div id="log-container" class="flex-1 overflow-y-auto p-4 text-gray-300 space-y-1 text-[13px] leading-relaxed">
        <div class="text-green-500 font-bold mb-2">
            [SYSTEM] Conectado ao socket de telemetria do Core Ada. Aguardando eventos...
        </div>
    </div>
</div>

<script>
    const logContainer = document.getElementById('log-container');
    const btnTail = document.getElementById('btn-tail');
    const tailDot = document.getElementById('tail-dot');
    const tailText = document.getElementById('tail-text');
    
    let isTailing = true;
    let fetchInterval;

    function appendLog(message) {
        const line = document.createElement('div');
        // Adiciona coloração condicional básica para ERROR, WARN e INFO
        if (message.includes('[ERROR]')) {
            line.innerHTML = `<span class="text-red-500">${message}</span>`;
        } else if (message.includes('[WARN]')) {
            line.innerHTML = `<span class="text-yellow-500">${message}</span>`;
        } else if (message.includes('[INFO]')) {
            line.innerHTML = `<span class="text-blue-400">${message}</span>`;
        } else {
            line.innerHTML = `<span class="text-gray-300">${message}</span>`;
        }
        
        logContainer.appendChild(line);
        
        if (isTailing) {
            logContainer.scrollTop = logContainer.scrollHeight;
        }
    }

    function fetchLogs() {
        if (!isTailing) return;
        
        const formData = new FormData();
        formData.append('acao', 'fetch_logs');

        fetch('actions.php', { method: 'POST', body: formData })
            .then(res => res.json())
            .then(data => {
                if (data.logs && data.logs.length > 0) {
                    data.logs.forEach(log => appendLog(log));
                }
            })
            .catch(err => console.error("Erro ao buscar logs", err));
    }

    function toggleTailing() {
        isTailing = !isTailing;
        if (isTailing) {
            btnTail.className = "bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center";
            tailDot.classList.remove('hidden');
            tailText.innerText = "Tailing: ON";
            logContainer.scrollTop = logContainer.scrollHeight;
        } else {
            btnTail.className = "bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition shadow-sm flex items-center";
            tailDot.classList.add('hidden');
            tailText.innerText = "Tailing: OFF";
        }
    }

    // Inicia a escuta a cada 1.5 segundos
    fetchInterval = setInterval(fetchLogs, 1500);
</script>