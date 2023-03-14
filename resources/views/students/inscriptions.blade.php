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
      <p class="p-2 text-red-700 w-full border-2 border-red-600 bg-red-100">
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
              'bg-gray-200 shadow' => !$inscription->value=='true',
              'bg-gray-100 shadow-md hover:bg-white' => $inscription->value=='true',
          ])>
          <x-svg.notepad class="h-7 w-7" />&nbsp;{{ $inscription->description }}
          </div>
          </a>
        </div>
    @endforeach
  </div>
  </div>
  @livewire('inscription.inscriptions-manage')
</x-app-layout>
