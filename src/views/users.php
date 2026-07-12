<div class="mb-8">
    <h1 class="text-3xl font-light text-gray-800 dark:text-gray-100">Configurações & Usuários</h1>
    <p class="text-gray-500 dark:text-gray-400 mt-1">Gerencie seu perfil pessoal e as permissões de equipe.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
    <div class="lg:col-span-1">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 transition-colors duration-200">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white mb-6">Meu Perfil</h2>
            
            <form action="actions.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="acao" value="update_profile">
                
                <div class="flex flex-col items-center">
                    <div class="w-24 h-24 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-4 border-white dark:border-gray-800 shadow-lg mb-3">
                        <?php if (isset($_SESSION['avatar'])): ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['avatar']); ?>" alt="Avatar" class="w-full h-full object-cover">
                        <?php else: ?>
                            <svg class="w-12 h-12 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <?php endif; ?>
                    </div>
                    <label for="avatar-upload" class="cursor-pointer text-sm font-medium text-php-purple dark:text-indigo-400 hover:underline">
                        Alterar Foto
                    </label>
                    <input id="avatar-upload" name="avatar" type="file" class="sr-only" accept="image/*">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome de Exibição</label>
                    <input type="text" name="nome" value="<?php echo htmlspecialchars($_SESSION['nome'] ?? ''); ?>" class="mt-1 w-full p-2.5 bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white focus:ring-php-purple focus:border-php-purple transition-colors">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">E-mail (Login)</label>
                    <input type="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?>" disabled class="mt-1 w-full p-2.5 bg-gray-50 dark:bg-gray-700/50 border border-gray-300 dark:border-gray-600 rounded-md text-gray-500 dark:text-gray-400 cursor-not-allowed transition-colors">
                </div>

                <button type="submit" class="w-full py-2.5 px-4 rounded-md shadow-sm text-sm font-medium text-white bg-php-purple hover:bg-php-purple-dark transition-colors">
                    Salvar Alterações
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden transition-colors duration-200 h-full">
            <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700 bg-gray-50/50 dark:bg-gray-800 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Membros da Equipe</h3>
                <button class="text-sm bg-gray-900 dark:bg-gray-700 text-white dark:text-gray-200 px-3 py-1.5 rounded-md hover:bg-gray-800 dark:hover:bg-gray-600 transition-colors">
                    + Convidar
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 dark:bg-gray-900/50 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                            <th class="px-6 py-4">Membro</th>
                            <th class="px-6 py-4">Role</th>
                            <th class="px-6 py-4 text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30 transition-colors">
                            <td class="px-6 py-4 flex items-center">
                                <div class="w-8 h-8 rounded-full bg-gray-200 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-gray-300 font-bold mr-3 overflow-hidden">
                                    <?php if (isset($_SESSION['avatar'])): ?>
                                        <img src="<?php echo htmlspecialchars($_SESSION['avatar']); ?>" alt="Avatar" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <?php echo strtoupper(substr($_SESSION['nome'] ?? 'U', 0, 1)); ?>
                                    <?php endif; ?>
                                </div>
                                <div>
                                    <div class="font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($_SESSION['nome'] ?? 'Admin'); ?> (Você)</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500"><?php echo htmlspecialchars($_SESSION['email'] ?? ''); ?></div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                    ADMIN
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/40 text-green-800 dark:text-green-300">
                                    Ativo
                                </span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>