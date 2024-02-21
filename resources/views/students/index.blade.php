<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Alumnos
      </h2>
  </x-slot>

  <div class="w-full d2c px-4 py-3 text-white flex justify-between">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
    </svg>&nbsp;Alumnos

    @if (auth()->user()->hasRole('admin'))
    {{-- Import Students --}}
    <div class="w-full text-right">
    <a href="{{ route('students-import-form') }}">
      <x-jet-button>
        Importar Alumnos&nbsp;
        <span class="inline-flex items-center justify-center px-2 py-1 text-xs leading-none text-gray-50 bg-gray-700 rounded-full">
          .csv</span>
      </x-jet-button>
    </a>
    </div>
    @endif
  </div>
  @livewire('students-component')

</x-app-layout>
