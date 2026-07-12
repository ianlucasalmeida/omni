<?php
// Se o usuário já está logado, não deve estar nas páginas públicas
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado']) {
  header('Location: index.php?v=dashboard');
  exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $page_title ?? 'Omniware ERP - A Gestão Completa para seu Negócio'; ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            'php-purple': '#777BB4',
            'php-purple-dark': '#4F5B93'
          }
        }
      }
    }
  </script>
</head>

<body class="bg-white flex flex-col min-h-screen">

  <header class="bg-white shadow-sm sticky top-0 z-50">
    <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-20">
      <a href="index.php?v=home" class="flex items-center">
        <div class="w-10 h-10 bg-php-purple rounded-lg flex items-center justify-center font-bold text-xl text-white mr-3">O</div>
        <span class="text-2xl font-bold text-gray-800">Omni ERP</span>
      </a>
      <div class="flex items-center space-x-8">
        <a href="index.php?v=sobre" class="text-gray-600 font-semibold hover:text-php-purple">Sobre Nós</a>
      </div>
      <div>
        <a href="index.php?v=login" class="text-gray-600 font-semibold hover:text-php-purple mr-6">Login</a>
        <a href="index.php?v=register" class="bg-php-purple text-white font-semibold py-2 px-5 rounded-lg hover:bg-php-purple-dark transition-colors">Começar Agora</a>
      </div>
    </nav>
  </header>

  <main class="flex-grow w-full">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">
      <?php
      if (isset($_SESSION['mensagem'])):
        $tipo = $_SESSION['tipo_mensagem'] ?? 'info';
        $bg = $tipo === 'erro' ? 'bg-red-100 text-red-800 border-red-200' : 'bg-green-100 text-green-800 border-green-200';
      ?>
        <div class="p-4 mb-4 rounded-lg border <?php echo $bg; ?>">
          <?php echo htmlspecialchars($_SESSION['mensagem']); ?>
        </div>
      <?php
        unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']);
      endif;
      ?>
    </div>

    <?php if (isset($view_path) && file_exists($view_path)) require_once $view_path; ?>
  </main>

  <footer class="bg-gray-800 text-white mt-auto">
    <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:px-8">
      <div class="xl:grid xl:grid-cols-4 xl:gap-8">
        <div class="space-y-8 xl:col-span-1">
          <a href="index.php?v=home" class="flex items-center">
            <div class="w-10 h-10 bg-php-purple rounded-lg flex items-center justify-center font-bold text-xl mr-3">O</div>
            <span class="text-2xl font-bold">Omni ERP</span>
          </a>
          <p class="text-gray-400 text-base">
            Simplificando a gestão de negócios com tecnologia intuitiva.
          </p>
        </div>
        <div class="mt-12 grid grid-cols-2 md:grid-cols-3 gap-8 xl:mt-0 xl:col-span-3">
          <div>
            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Soluções</h3>
            <ul class="mt-4 space-y-4">
              <li><a href="index.php?v=home" class="text-base text-gray-400 hover:text-white">CRM</a></li>
              <li><a href="index.php?v=home" class="text-base text-gray-400 hover:text-white">Estoque</a></li>
              <li><a href="index.php?v=home" class="text-base text-gray-400 hover:text-white">BI & Analytics</a></li>
            </ul>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Empresa</h3>
            <ul class="mt-4 space-y-4">
              <li><a href="index.php?v=sobre" class="text-base text-gray-400 hover:text-white">Sobre Nós</a></li>
              <li><a href="index.php?v=home" class="text-base text-gray-400 hover:text-white">Contato</a></li>
              <li><a href="#" class="text-base text-gray-400 hover:text-white cursor-not-allowed">Carreiras</a></li>
            </ul>
          </div>
          <div>
            <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Clientes</h3>
            <ul class="mt-4 space-y-4">
              <li><a href="index.php?v=login" class="text-base text-gray-400 hover:text-white">Login do Cliente</a></li>
              <li><a href="#" class="text-base text-gray-400 hover:text-white cursor-not-allowed">Suporte</a></li>
            </ul>
          </div>
        </div>
      </div>
      <div>
        <h3 class="text-sm font-semibold text-gray-300 tracking-wider uppercase">Empresa</h3>
        <ul class="mt-4 space-y-4">
          <li><a href="index.php?v=sobre" class="text-base text-gray-400 hover:text-white">Sobre Nós</a></li>
          <li><a href="index.php?v=contato" class="text-base text-gray-400 hover:text-white">Contato</a></li>
          <li><a href="#" class="text-base text-gray-400 hover:text-white cursor-not-allowed">Carreiras</a></li>
        </ul>
      </div>
    </div>
  </footer>
</body>

</html>