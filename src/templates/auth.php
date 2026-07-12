<!DOCTYPE html>
<html lang="pt-br" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso - Omni     ERP</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
      tailwind.config = { 
          theme: { extend: { colors: { 'php-purple': '#777BB4', 'php-purple-dark': '#4F5B93' } } } 
      }
    </script>
    <style>
        /* Padrão Quadriculado com as cores Omniware */
        .bg-checkerboard {
            background-color: #777BB4;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M0 0h30v30H0V0zm30 30h30v30H30V30z' fill='%2363679b' fill-opacity='0.4' fill-rule='evenodd'/%3E%3C/svg%3E");
        }
    </style>
</head>
<body class="bg-white h-screen flex overflow-hidden">
    
    <div class="hidden lg:flex lg:w-1/2 bg-checkerboard flex-col justify-center items-center text-white px-12 relative">
        <div class="relative z-10 text-center">
            <div class="w-20 h-20 bg-white rounded-2xl flex items-center justify-center font-bold text-4xl text-php-purple mx-auto mb-8 shadow-xl">O</div>
            <h1 class="text-4xl font-bold tracking-tight mb-4">Omni ERP</h1>
            <p class="text-lg text-indigo-100 max-w-md mx-auto">Motor transacional atômico. Escalabilidade infinita. Gestão definitiva para o seu negócio.</p>
        </div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent to-php-purple-dark opacity-40"></div>
    </div>

    <div class="w-full lg:w-1/2 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 overflow-y-auto bg-white">
        <?php if (isset($_SESSION['mensagem'])): 
            $tipo = $_SESSION['tipo_mensagem'] ?? 'info';
            $bg = $tipo === 'erro' ? 'bg-red-50 text-red-800 border-red-200' : 'bg-green-50 text-green-800 border-green-200';
        ?>
            <div class="p-4 mb-6 rounded-lg border <?php echo $bg; ?>">
                <?php echo htmlspecialchars($_SESSION['mensagem']); ?>
            </div>
        <?php unset($_SESSION['mensagem'], $_SESSION['tipo_mensagem']); endif; ?>

        <?php require_once $view_path; ?>
    </div>
</body>
</html>