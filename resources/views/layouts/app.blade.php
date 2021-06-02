<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    @livewireStyles

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-300">
        @livewire('navigation-dropdown')

        <!-- Page Heading -->
        {{-- <header class="d2c shadow">
            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header> --}}

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>

    @stack('modals')
    @livewireScripts
    @stack('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        livewire.on('toast', function(message, icon) {
          if (icon == '') { 
            icon = 'success'
          }
          switch (icon) {
            case 'success':
              bgcolor = '#a9bd8a'; break;
            case 'warning':
              bgcolor = '#bdb68a'; break;
            case 'error':
              bgcolor = '#bd8a8a'; break;
            case 'info':
              bgcolor = '#8aa0bd'; break;
            case 'question':
              bgcolor = '#8abdb2'; break;
          }
          Swal.fire({
            icon: icon,
            iconColor: '#ffffff',
            background: bgcolor,
            title: message,
            toast: true,
            position: 'top-end',
            timerProgressBar: true,
            showConfirmButton: false,
            timer: 2500
          })
        });
    
        livewire.on('confirmDelete', function(message, uid) {
            Swal.fire({
                //title: 'Está seguro?',
                text: "Eliminar "+message+"?",
                icon: 'warning',
                iconColor: '#ffc145',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText:'Cancelar',
                confirmButtonText: 'Eliminar',
                background: '#dddddd',
                padding:'0.5rem'
            }).then((result) => {
                if (result.isConfirmed) {
                    Livewire.emit('delete',uid);
                }
              })
            });
      </script>
    
</body>

</html>
