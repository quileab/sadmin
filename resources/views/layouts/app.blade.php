@php
$nav_links = [
    [
      'name' => 'Dashboard',
      'route' => route('dashboard'),
      'active' => request()->routeIs('dashboard'),
      'permission'=>'menu.dashboard',
    ],
    [
      'name' => 'Usuarios/Alumnos',
      'route' => route('students'),
      'active' => request()->routeIs('students'),
      'permission'=>'menu.students',
    ],
    [
      'name' => 'Carreras / Cursos-Divisiones',
      'route' => route('careers'),
      'active' => request()->routeIs('careers'),
      'permission'=>'menu.careers',
    ],
    [
      'name' => 'Profesores-Materias',
      'route' => route('teachersubjects'),
      'active' => request()->routeIs('teachersubjects'),
      'permission'=>'menu.teachersubjects',
    ],
    [
      'name' => 'Matriculación a Materias',
      'route' => route('studentsubjects'),
      'active' => request()->routeIs('studentsubjects'),
      'permission'=>'menu.studentsubjects',
    ],
    [
      'name' => 'Libro de Temas',
      'route' => route('classbooks'),
      'active' => request()->routeIs('classbooks'),
      'permission'=>'menu.classbooks',
    ],
    [
      'name' => 'Mis Estudiantes',
      'route' => route('mystudents'),
      'active' => request()->routeIs('mystudents'),
      'permission'=>'menu.mystudents',
    ],
    [
      'name' => 'Inscripciones',
      'route' => route('studentsinsc'),
      'active' => request()->routeIs('studentsinsc'),
      'permission'=>'menu.inscriptions',
    ],
    [
      'name' => 'Calendarios',
      'route' => route('calendars'),
      'active' => request()->routeIs('calendars'),
      'permission'=>'menu.calendars',
    ],
    [
      'name' => '📚 Biblioteca',
      'route' => route('books'),
      'active' => request()->routeIs('books'),
      'permission'=>'menu.books',
    ],
    [
      'name' => 'Info Tarjetas',
      'route' => route('infocards'),
      'active' => request()->routeIs('infocards'),
      'permission'=>'menu.infocards',
    ],
    [
      'name' => 'Planes de Pago',
      'route' => route('payplans'),
      'active' => request()->routeIs('payplans'),
      'permission'=>'menu.payplans',
    ],
    [
      'name' => 'Roles & Permisos',
      'route' => route('permissions'),
      'active' => request()->routeIs('permissions'),
      'permission'=>'menu.security',
    ],
    [
      'name' => 'Configuración',
      'route' => route('configs'),
      'active' => request()->routeIs('configs'),
      'permission'=>'menu.config',
    ],
];
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- Styles -->
  @vite('resources/css/app.css')
  <style>
    .swal2-title {
      color: aliceblue !important;
      font-size: 1.2rem !important;
    }

  </style>
  @livewireStyles

  <!-- Scripts -->
  @vite('resources/js/app.js')
</head>

<body>
  {{-- qb template --}}
  <div class="relative min-h-screen md:flex">
    {{-- mobile navbar --}}
    <div class="bg-gray-800 text-gray-100 flex justify-between md:hidden">
      {{-- logo --}}
      <div class="block p-4">
        <a href="{{ route('dashboard') }}">
          <x-jet-application-mark class="block h-9 w-auto" />
        </a>
      </div>
      <button class="p-4 focus:outline-none focus:bg-gray-700"
        onclick="document.querySelector('.sidbar').classList.toggle('-translate-x-full')">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
      </button>

    </div>

    {{-- sidebar --}}
    <div class="sidbar bg-gray-600 text-gray-50 w-56 absolute inset-y-0 left-0
        transform -translate-x-full transition duration-200 ease-in-out
        md:relative md:translate-x-0
        ">
      {{-- Logo & profile --}}
      <div class="flex justify-between bg-gray-800">
        {{-- logo --}}
        <div class="flex-shrink-0 flex items-end my-4 mx-4">
          <a href="{{ route('dashboard') }}">
            <x-jet-application-mark class="block h-9 w-auto" />
          </a>
        </div>

        <!-- Settings Dropdown -->
        <div class="hidden sm:flex sm:items-center sm:ml-6 mr-4">
          <x-jet-dropdown>
            <x-slot name="trigger">
              @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                <button
                  class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                  <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}"
                    alt="{{ Auth::user()->lastname .' '. strtoupper(substr(Auth::user()->firstname, 0, 1)) }}" />
                </button>
              @else
                <button
                  class="flex items-center text-sm font-medium text-gray-200 hover:text-gray-50 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                  <div class="text-sm">
                    {{ Auth::user()->lastname .' '. strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                  </div>

                  <div>
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" />
                    </svg>
                  </div>
                </button>
              @endif
            </x-slot>

            <x-slot name="content">
              <!-- Account Management -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('messages.Manage Account') }}
              </div>

              <x-jet-dropdown-link href="{{ route('profile.show') }}">
                {{ __('messages.Profile') }}
              </x-jet-dropdown-link>

              @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-jet-dropdown-link href="{{ route('api-tokens.index') }}">
                  {{ __('API Tokens') }}
                </x-jet-dropdown-link>
              @endif

              <div class="border-t border-gray-100"></div>

              <!-- Team Management -->
              @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ __('Manage Team') }}
                </div>

                <!-- Team Settings -->
                <x-jet-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                  {{ __('Team Settings') }}
                </x-jet-dropdown-link>

                @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                  <x-jet-dropdown-link href="{{ route('teams.create') }}">
                    {{ __('Create New Team') }}
                  </x-jet-dropdown-link>
                @endcan

                <div class="border-t border-gray-100"></div>

                <!-- Team Switcher -->
                <div class="block px-4 py-2 text-xs text-gray-400">
                  {{ __('Switch Teams') }}
                </div>

                @foreach (Auth::user()->allTeams() as $team)
                  <x-jet-switchable-team :team="$team" />
                @endforeach

                <div class="border-t border-gray-100"></div>
              @endif

              <!-- Authentication -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();
                  this.closest('form').submit();">
                  {{ __('messages.Logout') }}
                </x-jet-dropdown-link>
              </form>
            </x-slot>
          </x-jet-dropdown>
        </div>
      </div>
      
      {{-- float information --}}    
      @livewire('book-marks')

      <nav class="text-gray-50">
        @foreach ($nav_links as $nav_link)
          @can($nav_link['permission'])
            <x-jet-nav-link class="block py-2 px-4 w-full" href="{{ $nav_link['route'] }}"
              :active="$nav_link['active']">
              &nbsp;{{ __($nav_link['name']) }}
            </x-jet-nav-link><br />
          @endcan
        @endforeach
      </nav>
    </div>

    {{-- content --}}
    <div class="flex-1 w-full py-0 bg-stone-900">
      <!-- Page Content -->
      <main>
        {{ $slot }}
      </main>

    </div>

  </div>
  {{-- end qb template --}}
  @stack('modals')
  @livewireScripts
  @stack('scripts')
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script>
    livewire.on('bookmark', function(message) {
      document.getElementById('bookmark').innerHTML = message;
    });

    livewire.on('toast', function(message, icon) {
      if (icon == '') {
        icon = 'success'
      }
      switch (icon) {
        case 'success':
          bgcolor = '#237539';
          break;
        case 'warning':
          bgcolor = '#d67200';
          break;
        case 'info':
          bgcolor = '#0a3f80';
          break;
        case 'question':
          bgcolor = '#8a0a61';
          break;
        default: // none / error / danger
          bgcolor = '#b80000';
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
        timer: 3500,
      })
    });

    livewire.on('confirmDelete', function(message, uid, callback) {
      Swal.fire({
        //title: 'Está seguro?',
        text: "Eliminar " + message + "?",
        icon: 'warning',
        iconColor: '#ffaa00',
        showCancelButton: true,
        confirmButtonColor: '#065f46',
        cancelButtonColor: '#b91c1c',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar',
        background: '#dddddd',
        padding: '0.5rem'
      }).then((result) => {
        if (result.isConfirmed) {
          // Livewire.emit('delete', uid);
          Livewire.emit(callback, uid);
        }
      })
    });
  </script>
</body>

</html>
