<div class="mb-8">
    <h1 class="text-3xl font-light text-gray-800">Orquestração de Processos</h1>
    <p class="text-gray-500 mt-1">Gerenciamento de filas assíncronas e barramento de eventos integrados ao Ada.</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-php-purple">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Jobs em Espera</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">0</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-green-500">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Processados (24h)</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">0</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-red-500">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Falhas detectadas</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">0</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-blue-400">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Workers Ativos</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">2</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-medium text-gray-900">Barramento de Mensagens</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50/50">
                        <th class="px-6 py-4">Nome da Fila</th>
                        <th class="px-6 py-4">Driver</th>
                        <th class="px-6 py-4 text-center">Mensagens</th>
                        <th class="px-6 py-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-medium text-gray-900">core.transactions.ledger</td>
                        <td class="px-6 py-4 text-gray-500">PostgreSQL Channels</td>
                        <td class="px-6 py-4 text-center font-bold">0</td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Escutando</span>
                        </td>
                    </tr>
                    <tr class="hover:bg-gray-50/50">
                        <td class="px-6 py-4 font-medium text-gray-900">core.storage.metadata</td>
                        <td class="px-6 py-4 text-gray-500">PostgreSQL Channels</td>
                        <td class="px-6 py-4 text-center font-bold">0</td>
                        <td class="px-6 py-4 text-right">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Escutando</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="lg:col-span-1 bg-white rounded-xl shadow-sm border border-gray-100 p-6">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Orquestrador</h3>
        <div class="space-y-4">
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                <div>
                    <h4 class="font-semibold text-sm">Worker_Daemon_1</h4>
                    <p class="text-xs text-gray-500">PID: 49822 - Servidor Ada</p>
                </div>
                <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
            </div>
            <div class="p-4 bg-gray-50 rounded-lg border border-gray-200 flex justify-between items-center">
                <div>
                    <h4 class="font-semibold text-sm">Worker_Daemon_2</h4>
                    <p class="text-xs text-gray-500">PID: 49828 - Servidor Ada</p>
                </div>
                <span class="w-2.5 h-2.5 bg-green-500 rounded-full"></span>
            </div>
        </div>
    </div>
</div>