<div class="flex justify-between items-center mb-6">
    <div>
        <h1 class="text-3xl font-light text-gray-800 dark:text-gray-100">Core Terminal</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Acesso direto ao daemon do motor Ada e hipervisor KVM local.</p>
    </div>
</div>

<div class="bg-[#1e1e1e] rounded-xl shadow-2xl border border-gray-700 overflow-hidden h-[600px] flex flex-col font-mono text-sm relative">
    
    <div class="bg-[#2d2d2d] px-4 py-2 flex items-center border-b border-gray-900">
        <div class="flex space-x-2">
            <div class="w-3 h-3 rounded-full bg-red-500"></div>
            <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
            <div class="w-3 h-3 rounded-full bg-green-500"></div>
        </div>
        <div class="mx-auto text-gray-400 text-xs tracking-widest uppercase">omni-cli @ fedora-server</div>
    </div>

    <div id="terminal-output" class="flex-1 overflow-y-auto p-4 text-gray-300 space-y-1">
        <div class="text-php-purple-dark dark:text-indigo-400 mb-4">
            Omniware OS v1.0.0 (Core Ada KVM Interface)<br>
            Digite 'help' para ver os comandos disponiveis.
        </div>
    </div>

    <div class="p-4 flex items-center bg-[#1e1e1e] border-t border-gray-800">
        <span class="text-green-500 font-bold mr-2">omni@fedora:~$</span>
        <input type="text" id="terminal-input" autocomplete="off" spellcheck="false" class="flex-1 bg-transparent border-none outline-none text-gray-100 placeholder-gray-700 font-mono" placeholder="_" autofocus>
    </div>
</div>

<script>
    const input = document.getElementById('terminal-input');
    const output = document.getElementById('terminal-output');
    let history = [];
    let historyIndex = -1;

    // Foca no input ao clicar no terminal
    document.querySelector('.bg-\\[\\#1e1e1e\\]').addEventListener('click', () => input.focus());

    function printLine(text, isCommand = false) {
        const line = document.createElement('div');
        if (isCommand) {
            line.innerHTML = `<span class="text-green-500 font-bold">omni@fedora:~$</span> <span class="text-white">${text}</span>`;
        } else {
            // Formata quebras de linha preservando o layout
            line.innerHTML = `<span class="text-gray-400 whitespace-pre-wrap">${text}</span>`;
        }
        output.appendChild(line);
        output.scrollTop = output.scrollHeight;
    }

    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            const command = this.value.trim();
            if (command) {
                history.push(command);
                historyIndex = history.length;
                printLine(command, true);
                
                if (command === 'clear') {
                    output.innerHTML = '';
                } else {
                    processCommand(command);
                }
            }
            this.value = '';
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (historyIndex > 0) {
                historyIndex--;
                this.value = history[historyIndex];
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (historyIndex < history.length - 1) {
                historyIndex++;
                this.value = history[historyIndex];
            } else {
                historyIndex = history.length;
                this.value = '';
            }
        }
    });

    function processCommand(cmd) {
        const formData = new FormData();
        formData.append('acao', 'terminal_command');
        formData.append('command', cmd);

        // Simulando delay de rede/processamento para efeito realista
        setTimeout(() => {
            fetch('actions.php', {
                method: 'POST',
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.output) {
                    printLine(data.output);
                } else if (data.error) {
                    printLine(`<span class="text-red-500">${data.error}</span>`);
                }
            })
            .catch(err => {
                printLine('<span class="text-red-500">Erro fatal de conexao com o socket IPC.</span>');
            });
        }, 150);
    }
</script>