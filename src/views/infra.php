<?php
// Simulação de estado de infraestrutura (Até o banco Ada ser conectado)
if (!isset($_SESSION['vms'])) {
    $_SESSION['vms'] = [
        ['id' => 'i-001a4b', 'name' => 'omni-db-postgres', 'vcpu' => 4, 'ram' => 8, 'state' => 'RUNNING', 'ip' => '192.168.0.105'],
        ['id' => 'i-002c9f', 'name' => 'worker-node-1', 'vcpu' => 2, 'ram' => 4, 'state' => 'STOPPED', 'ip' => '-']
    ];
}
$vms = $_SESSION['vms'];
?>

<div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
    <div>
        <h1 class="text-3xl font-light text-gray-800 dark:text-gray-100">Compute Engine (VMs)</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Orquestração de hypervisors locais (KVM/QEMU) no host Fedora.</p>
    </div>
    <button onclick="document.getElementById('modal-vm').classList.remove('hidden')" class="bg-php-purple text-white px-5 py-2.5 rounded-lg font-medium hover:bg-php-purple-dark transition shadow-sm flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5v14"></path></svg>
        Launch Instance
    </button>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center">
        <div class="p-3 bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">vCPUs Alocadas</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">6 / 16</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center">
        <div class="p-3 bg-purple-100 dark:bg-purple-900/30 text-php-purple dark:text-purple-400 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">RAM Alocada</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-white">12 GB / 32 GB</p>
        </div>
    </div>
    <div class="bg-white dark:bg-gray-800 p-6 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm flex items-center">
        <div class="p-3 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 rounded-lg mr-4">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
        </div>
        <div>
            <p class="text-sm text-gray-500 dark:text-gray-400 font-medium">Status do Host (Ada KVM)</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400">Online</p>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
        <h3 class="text-lg font-medium text-gray-900 dark:text-white">Instâncias Virtuais</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 dark:bg-gray-800 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider border-b border-gray-200 dark:border-gray-700">
                    <th class="px-6 py-4">Instance ID</th>
                    <th class="px-6 py-4">Nome</th>
                    <th class="px-6 py-4">Status</th>
                    <th class="px-6 py-4">IPv4 Local</th>
                    <th class="px-6 py-4">Specs (vCPU / RAM)</th>
                    <th class="px-6 py-4 text-right">Ações</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700 text-sm text-gray-700 dark:text-gray-300">
                <?php foreach ($vms as $vm): ?>
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition-colors">
                    <td class="px-6 py-4 font-mono text-php-purple dark:text-indigo-400"><?php echo $vm['id']; ?></td>
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white"><?php echo htmlspecialchars($vm['name']); ?></td>
                    <td class="px-6 py-4">
                        <?php if($vm['state'] === 'RUNNING'): ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-400 border border-green-200 dark:border-green-800">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full mr-1.5 animate-pulse"></span> Running
                            </span>
                        <?php else: ?>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300 border border-gray-200 dark:border-gray-600">
                                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full mr-1.5"></span> Stopped
                            </span>
                        <?php endif; ?>
                    </td>
                    <td class="px-6 py-4 font-mono text-gray-500"><?php echo $vm['ip']; ?></td>
                    <td class="px-6 py-4"><?php echo $vm['vcpu']; ?> vCPUs, <?php echo $vm['ram']; ?> GiB</td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <form action="actions.php" method="POST" class="inline">
                            <input type="hidden" name="acao" value="vm_toggle">
                            <input type="hidden" name="vm_id" value="<?php echo $vm['id']; ?>">
                            <?php if($vm['state'] === 'RUNNING'): ?>
                                <button type="submit" class="text-amber-600 hover:text-amber-800 font-medium text-xs border border-amber-200 bg-amber-50 px-2 py-1 rounded">Stop</button>
                            <?php else: ?>
                                <button type="submit" class="text-green-600 hover:text-green-800 font-medium text-xs border border-green-200 bg-green-50 px-2 py-1 rounded">Start</button>
                            <?php endif; ?>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal-vm" class="fixed inset-0 bg-gray-900 bg-opacity-50 hidden items-center justify-center z-50 flex">
    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-lg w-full p-6 border border-gray-200 dark:border-gray-700">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-xl font-bold text-gray-900 dark:text-white">Provisionar Nova Instância</h3>
            <button onclick="document.getElementById('modal-vm').classList.add('hidden')" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">✕</button>
        </div>
        <form action="actions.php" method="POST" class="space-y-4">
            <input type="hidden" name="acao" value="provisionar_vm">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Nome da Instância</label>
                <input type="text" name="vm_name" required class="mt-1 w-full p-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">vCPUs</label>
                    <select name="vcpu" class="mt-1 w-full p-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white">
                        <option value="1">1 Core</option>
                        <option value="2" selected>2 Cores</option>
                        <option value="4">4 Cores</option>
                        <option value="8">8 Cores</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Memória (RAM)</label>
                    <select name="ram" class="mt-1 w-full p-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white">
                        <option value="1">1 GiB</option>
                        <option value="2">2 GiB</option>
                        <option value="4" selected>4 GiB</option>
                        <option value="8">8 GiB</option>
                        <option value="16">16 GiB</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Imagem ISO / OS</label>
                <select name="os" class="mt-1 w-full p-2.5 bg-gray-50 dark:bg-gray-900 border border-gray-300 dark:border-gray-600 rounded-md text-gray-900 dark:text-white">
                    <option value="debian">Debian 12 (Netinst)</option>
                    <option value="ubuntu">Ubuntu Server 24.04 LTS</option>
                    <option value="fedora">Fedora Server 40</option>
                </select>
            </div>
            <button type="submit" class="w-full py-3 bg-php-purple hover:bg-php-purple-dark text-white font-bold rounded-lg mt-4 transition-colors">
                Lançar Instância
            </button>
        </form>
    </div>
</div>