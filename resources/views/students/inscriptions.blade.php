<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">Alumnos</h2>
  </x-slot>

  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto">
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
      <h1>Inscripciones
        @hasanyrole('admin|principal|superintendent|administrative')
          &nbsp;»<small>Permisos Elevados</small>
        @endhasanyrole
      </h1>

    </div>
    @if (auth()->user()->enabled == false)
      <p class="ml-5 mt-1 text-red-700 w-full border-2 border-red-600 rounded-md">
        Se ha encontrado una inconsistencia: CONSULTE CON TESORERÍA</p>
    @endif

    <div class="m-4 flex justify-evenly">
      @foreach ($inscriptions as $inscription)

        <div class="inline-flex">
          <a @if ($inscription->value == 'true' && auth()->user()->enabled)
              href="{{ route('studentsinscdata', $inscription->id) }}"
          @else
            @hasanyrole('admin|principal|superintendent|administrative')
              href="{{ route('studentsinscdata', $inscription->id) }}"
            @endhasanyrole
          @endif
          >
      <div @class([
          'flex p-3 m-1 rounded-md',
          'bg-gray-200 shadow' => !$inscription->value,
          'bg-gray-100 shadow-md hover:bg-white' => $inscription->value,
      ])>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
        </svg>&nbsp;{{ $inscription->description }}
      </div>
      </a>
    </div>

    @endforeach
  </div>
  </div>
  @livewire('inscription.inscriptions-manage')
</x-app-layout>
