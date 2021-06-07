@php
$nav_links = [
    [
        'name' => 'Dashboard',
        'route' => route('dashboard'),
        'active' => request()->routeIs('dashboard'),
    ],
    [
        'name' => 'Info Tarjetas',
        'route' => route('infocards'),
        'active' => request()->routeIs('infocards'),
    ],
    [
      'name' => 'Carreras',
      'route' => route('careers'),
      'active' => request()->routeIs('careers'),
    ],
    [
      'name' => 'Alumnos',
      'route' => route('students'),
      'active' => request()->routeIs('students'),
    ],
    [
      'name' => 'Calendarios',
      'route' => route('calendars'),
      'active' => request()->routeIs('calendars'),
    ],
    [
      'name' => 'Libros',
      'route' => route('books'),
      'active' => request()->routeIs('books'),
    ],
    [
        'name' => 'Configuración',
        'route' => route('configs'),
        'active' => request()->routeIs('configs'),
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
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">

  @livewireStyles

  <!-- Scripts -->
  <script src="{{ mix('js/app.js') }}" defer></script>
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
    <div class="sidbar bg-gray-500 text-gray-100 w-56 absolute inset-y-0 left-0
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
                    alt="{{ Auth::user()->name }}" />
                </button>
              @else
                <button
                  class="flex items-center text-sm font-medium text-gray-200 hover:text-gray-50 hover:border-gray-300 focus:outline-none transition duration-150 ease-in-out">
                  <div>{{ Auth::user()->name }}</div>

                  <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                      <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </div>
                </button>
              @endif
            </x-slot>

            <x-slot name="content">
              <!-- Account Management -->
              <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Manage Account') }}
              </div>

              <x-jet-dropdown-link href="{{ route('profile.show') }}">
                {{ __('Profile') }}
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
                  {{ __('Logout') }}
                </x-jet-dropdown-link>
              </form>
            </x-slot>
          </x-jet-dropdown>
        </div>
      </div>

      <nav class="text-gray-200">
        @foreach ($nav_links as $nav_link)

          <x-jet-nav-link class="block py-2 px-4 w-full" href="{{ $nav_link['route'] }}"
            :active="$nav_link['active']">
            {{ __($nav_link['name']) }}
          </x-jet-nav-link><br />

        @endforeach
      </nav>

    </div>

    {{-- content --}}
    <div class="flex-1 mx-auto py-5 bg-gray-400">
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
    livewire.on('toast', function(message, icon) {
      if (icon == '') {
        icon = 'success'
      }
      switch (icon) {
        case 'success':
          bgcolor = '#a9bd8a';
          break;
        case 'warning':
          bgcolor = '#bdb68a';
          break;
        case 'error':
          bgcolor = '#bd8a8a';
          break;
        case 'info':
          bgcolor = '#8aa0bd';
          break;
        case 'question':
          bgcolor = '#8abdb2';
          break;
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
        text: "Eliminar " + message + "?",
        icon: 'warning',
        iconColor: '#ffc145',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Eliminar',
        background: '#dddddd',
        padding: '0.5rem'
      }).then((result) => {
        if (result.isConfirmed) {
          Livewire.emit('delete', uid);
        }
      })
    });

  </script>
</body>

</html>
