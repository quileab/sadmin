<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Inscripciones segun permisos
      </h2>
  </x-slot>

  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-4">
      <div class="w-full d2c px-4 py-3 text-white flex justify-between">
          <h1>{{ $inscription->description }}</h1>
      </div>
      @if(Auth::user()->hasRole('admin'))
        @livewire('inscription.inscription-admin', ['inscription' => $inscription])
      @else
        @livewire('inscription.inscription-student', ['inscription' => $inscription])
      @endif
  </div>

</x-app-layout>