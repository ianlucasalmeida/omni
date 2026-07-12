<div class="flex justify-between items-center mb-8">
    <div>
        <h1 class="text-3xl font-light text-gray-800">Cloud Storage</h1>
        <p class="text-gray-500 mt-1">Gerencie documentos e notas fiscais vinculadas ao sistema.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <div class="lg:col-span-1">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">Novo Arquivo</h2>
            
            <form action="actions.php" method="POST" enctype="multipart/form-data" class="space-y-4">
                <input type="hidden" name="acao" value="upload_arquivo">
                
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:bg-gray-50 transition-colors">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <div class="mt-4 flex text-sm text-gray-600 justify-center">
                        <label for="file-upload" class="relative cursor-pointer bg-white rounded-md font-medium text-php-purple hover:text-php-purple-dark focus-within:outline-none">
                            <span>Selecione um arquivo</span>
                            <input id="file-upload" name="documento" type="file" class="sr-only" required>
                        </label>
                    </div>
                    <p class="text-xs text-gray-500 mt-2">PDF, PNG, JPG até 10MB</p>
                </div>
                
                <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-php-purple hover:bg-php-purple-dark transition-colors">
                    Fazer Upload para o Core
                </button>
            </form>
        </div>
    </div>

    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                <h3 class="text-lg font-medium text-gray-900">Seus Arquivos</h3>
                <span class="text-sm text-gray-500">0 itens encontrados</span>
            </div>
            
            <div class="divide-y divide-gray-100">
                <div class="p-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    <p class="text-gray-500">A nuvem está vazia.</p>
                </div>
            </div>
        </div>
    </div>
</div>