<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-light text-gray-800">Fluxo de Caixa</h1>
        <p class="text-gray-500 mt-1">Gestao de receitas, despesas e saldo das contas.</p>
    </div>
    <div class="space-x-3">
        <button class="bg-red-50 text-red-600 border border-red-200 px-4 py-2 rounded-lg font-medium hover:bg-red-100 transition">Nova Despesa</button>
        <button class="bg-green-600 text-white px-4 py-2 rounded-lg font-medium hover:bg-green-700 transition">Nova Receita</button>
    </div>
</div>

<!-- Cards Financeiros Fiori -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-green-500">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Entradas (Mes)</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">R$ 0,00</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-red-500">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Saidas (Mes)</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">R$ 0,00</p>
    </div>
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 border-t-4 border-t-php-purple">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Saldo Atual</h3>
        <p class="text-3xl font-light text-gray-900 mt-2">R$ 0,00</p>
    </div>
</div>

<!-- Tabela de Transacoes -->
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50 flex justify-between items-center">
        <h3 class="text-lg font-medium text-gray-900">Ultimas Transacoes</h3>
        <input type="text" placeholder="Buscar transacao..." class="text-sm border border-gray-300 rounded-md px-3 py-1.5 focus:outline-none focus:ring-1 focus:ring-php-purple">
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4">Data</th>
                    <th class="px-6 py-4">Descricao</th>
                    <th class="px-6 py-4">Categoria</th>
                    <th class="px-6 py-4 text-right">Valor</th>
                    <th class="px-6 py-4 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm text-gray-700">
                <tr>
                    <td class="px-6 py-4 text-gray-500" colspan="5" text-align="center">Nenhum registro financeiro encontrado no Core.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>