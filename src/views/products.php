<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-light text-gray-800">Estoque & Produtos</h1>
        <p class="text-gray-500 mt-1">Catalogo de SKUs e controle de inventario.</p>
    </div>
    <button class="bg-php-purple text-white px-4 py-2 rounded-lg font-medium hover:bg-php-purple-dark transition">Novo Produto</button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-xs font-semibold text-gray-500 uppercase tracking-wider border-b border-gray-200">
                    <th class="px-6 py-4">Codigo/SKU</th>
                    <th class="px-6 py-4">Descricao do Produto</th>
                    <th class="px-6 py-4 text-right">Preco Venda</th>
                    <th class="px-6 py-4 text-center">Em Estoque</th>
                    <th class="px-6 py-4 text-right">Acoes</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <tr>
                    <td class="px-6 py-8 text-center text-gray-500" colspan="5">Nenhum produto cadastrado no catalogo.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>