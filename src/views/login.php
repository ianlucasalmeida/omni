<h2 class="text-2xl font-bold text-center">Acesse sua Conta</h2>

<?php if ($msg = get_mensagem()): ?>
    <div class="mt-4 p-3 rounded-md text-center <?php echo $msg['type'] === 'erro' ? 'bg-red-100 text-red-600' : 'bg-green-100 text-green-600'; ?>">
        <?php echo $msg['text']; ?>
    </div>
<?php endif; ?>

<form method="POST" action="actions.php" class="mt-8 space-y-6">
    <input type="hidden" name="acao" value="login">
    <div>
        <label class="font-semibold text-gray-700">Email</label>
        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-md mt-1 focus:ring-php-purple focus:border-php-purple outline-none transition-all">
    </div>
    <div>
        <label class="font-semibold text-gray-700">Senha</label>
        <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-md mt-1 focus:ring-php-purple focus:border-php-purple outline-none transition-all">
    </div>
    <button type="submit" class="w-full py-3 px-4 bg-php-purple text-white rounded-md font-semibold hover:bg-php-purple-dark transition-colors">Entrar</button>
</form>
<p class="text-center mt-6 text-sm">Nao tem uma conta? <a href="index.php?v=register" class="font-medium text-php-purple hover:underline">Cadastre sua empresa</a></p>