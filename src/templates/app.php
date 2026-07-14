<!DOCTYPE html>
<html lang="pt-br" class="h-full" id="html-tag">

<head>
    <meta charset="UTF-8">
    <title>Omni ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        'php-purple': '#777BB4',
                        'php-purple-dark': '#4F5B93',
                        'fiori-bg': '#F3F4F6'
                    }
                }
            }
        }
    </script>
    <script>
        // Executa imediatamente para evitar flash de tela branca no Fedora
        if (localStorage.getItem('theme') === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>

<body class="bg-fiori-bg dark:bg-gray-900 h-screen flex overflow-hidden text-gray-800 dark:text-gray-200 font-sans transition-colors duration-200">

    <aside class="w-64 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 flex flex-col z-20 shadow-sm">
        <div class="h-16 flex items-center px-6 border-b border-gray-200 dark:border-gray-700">
            <img src="logo/logo.png" alt="Logo Omni" class="w-8 h-8 object-contain mr-3 dark:invert-0 transition-all duration-200">
            <span class="text-xl font-bold tracking-tight text-gray-900 dark:text-white">OMNI</span>
        </div>

        <nav class="flex-grow py-4 px-3 space-y-1 overflow-y-auto">
            <a href="index.php?v=dashboard" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Launchpad</span>
            </a>

            <a href="index.php?v=finance" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Ledger Financeiro</span>
            </a>

            <div>
                <button onclick="toggleSubmenu('cloud-menu')" class="w-full flex items-center justify-between px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                    <span>Ambiente Cloud</span>
                </button>
                <div id="cloud-menu" class="hidden pl-6 pr-3 py-1 space-y-1 bg-gray-50/50 dark:bg-gray-700/30 rounded-lg mt-1">
                    <a href="index.php?v=storage" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium">Cloud Storage</a>
                    <a href="index.php?v=workflow" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium">Construtor de Fluxos</a>
                    <a href="index.php?v=orchestration" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium">Monitor de Filas</a>
                </div>
            </div>

            <a href="index.php?v=terminal" class="block px-3 py-2 text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white font-medium flex justify-between items-center group">
                <span>Terminal Core</span>
                <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse group-hover:scale-125 transition-transform"></span>
            </a>

            <a href="index.php?v=infra" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Máquinas Virtuais (EC2)</span>
            </a>

            <a href="index.php?v=customers" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Clientes</span>
            </a>

            <a href="index.php?v=products" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Estoque</span>
            </a>

            <a href="index.php?v=projects" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Projetos & Portfólio</span>
            </a>

            <a href="index.php?v=users" class="flex items-center px-3 py-2.5 text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg font-medium transition-colors">
                <span>Gestão de Usuários</span>
            </a>
        </nav>

        <div class="p-4 border-t border-gray-200 dark:border-gray-700">
            <a href="actions.php?acao=logout" class="flex items-center px-3 py-2 text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg font-medium transition-colors">
                <span>Sair</span>
            </a>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">
        <header class="h-16 bg-php-purple-dark text-white flex items-center justify-between px-8 shadow-md z-10 transition-colors duration-200">
            <h2 class="text-lg font-semibold tracking-wide">Ambiente de Trabalho</h2>
            <div class="flex items-center space-x-6">

                <button onclick="toggleDarkMode()" class="p-2 rounded-lg bg-php-purple hover:bg-php-purple/80 transition-colors focus:outline-none" title="Alternar Tema">
                    <svg id="sun-icon" class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path>
                    </svg>
                    <svg id="moon-icon" class="w-5 h-5 block dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 118.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>
                </button>

                <div class="flex items-center space-x-3">
                    <div class="text-right hidden md:block">
                        <div class="text-sm font-medium"><?php echo htmlspecialchars($_SESSION['nome'] ?? 'Usuário'); ?></div>
                        <div class="text-xs text-indigo-200"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></div>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-white text-php-purple flex items-center justify-center font-bold shadow-inner overflow-hidden border-2 border-indigo-400">
                        <?php if (isset($_SESSION['avatar'])): ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['avatar']); ?>" alt="Avatar" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?php echo strtoupper(substr($_SESSION['nome'] ?? 'U', 0, 1)); ?>
                        <?php endif; ?>
                    </div>
                </div>

            </div>
        </header>

        <main class="flex-1 overflow-y-auto p-8">
            <div class="max-w-7xl mx-auto">
                <?php require_once $view_path; ?>
            </div>
        </main>
    </div>

    <script>
        function toggleSubmenu(id) {
            const menu = document.getElementById(id);
            menu.classList.toggle('hidden');
        }

        function toggleDarkMode() {
            const html = document.documentElement;
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }
    </script>
</body>

</html>