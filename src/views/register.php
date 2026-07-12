<div class="mx-auto w-full max-w-sm lg:max-w-md">
    <h2 class="text-3xl font-light text-gray-900 mb-2">Criar Identidade</h2>
    <p class="text-sm text-gray-500 mb-8">Preencha seus dados básicos para provisionar seu ambiente.</p>

    <form action="actions.php" method="POST" class="space-y-5">
        <input type="hidden" name="acao" value="register">

        <div>
            <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
            <input type="text" name="nome_completo" required class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none" placeholder="Seu nome">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nascimento</label>
                <input type="date" name="data_nascimento" required class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none text-gray-600">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Telefone (Opcional)</label>
                <input type="text" name="telefone" placeholder="(00) 00000-0000" class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">E-mail de Acesso</label>
            <input type="email" name="email" required class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none" placeholder="voce@empresa.com">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Criar Senha</label>
                <input type="password" name="password" required class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none" placeholder="••••••••">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Confirmar Senha</label>
                <input type="password" name="password_confirm" required class="mt-1 block w-full p-3 bg-gray-50 border border-gray-300 rounded-lg focus:ring-2 focus:ring-php-purple focus:border-php-purple transition-all outline-none" placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-bold text-white bg-php-purple hover:bg-php-purple-dark transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-php-purple mt-4">
            Registrar no Core
        </button>
    </form>

    <div class="mt-8 text-center border-t border-gray-100 pt-6">
        <p class="text-sm text-gray-600">
            Já possui uma conta? 
            <a href="index.php?v=login" class="font-medium text-php-purple hover:text-php-purple-dark transition-colors">Faça login aqui</a>
        </p>
    </div>
</div>