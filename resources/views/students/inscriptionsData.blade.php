<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Inscripciones segun permisos
      </h2>
  </x-slot>

  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-4">
      <div class="w-full d2c px-4 py-3 text-white flex justify-between">
          <h1>Inscripciones</h1>
      </div>
      <div class="m-4 flex justify-evenly">
        {{ $inscription->description }}
      </div>
      @if(Auth::user()->hasRole('admin'))
        @livewire('inscription.inscription-admin', ['inscription' => $inscription])
      @else
        @include('students.inscriptionStudent')
      @endif
  </div>

</x-app-layout>