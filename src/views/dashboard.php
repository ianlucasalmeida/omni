<div class="mb-8">
    <h1 class="text-3xl font-light text-gray-800">Olá, <?php echo htmlspecialchars(explode('@', $_SESSION['usuario'] ?? 'Usuário')[0]); ?></h1>
    <p class="text-gray-500 mt-1">Aqui está o resumo das suas operações de hoje.</p>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer border-t-4 border-t-php-purple">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Volume de Vendas</h3>
        <div class="mt-4 flex items-baseline">
            <p class="text-4xl font-light text-gray-900">R$ 0</p>
            <p class="ml-2 text-sm text-gray-500">,00</p>
        </div>
    </div>
    
    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Transações Core</h3>
        <div class="mt-4 flex items-baseline">
            <p class="text-4xl font-light text-gray-900">0</p>
            <p class="ml-2 text-sm text-green-500 flex items-center"><svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg> 100%</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Espaço em Nuvem</h3>
        <div class="mt-4 flex items-baseline">
            <p class="text-4xl font-light text-gray-900">0.0</p>
            <p class="ml-2 text-sm text-gray-500">MB</p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow cursor-pointer">
        <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Status do Motor</h3>
        <div class="mt-4">
            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                <span class="w-2 h-2 mr-2 bg-green-500 rounded-full"></span>
                Ada Online
            </span>
        </div>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
        <h3 class="text-lg font-medium text-gray-900">Atividade Recente no Ledger</h3>
    </div>
    <div class="p-6 text-center text-gray-500 py-12">
        Nenhuma transação atômica registrada no Core Ada até o momento.
    </div>
</div>