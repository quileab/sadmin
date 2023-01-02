<div>
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-2">
    <div class="w-full d2c px-4 py-1 flex justify-between">
      <h1 class="py-1 mr-3">Filtros</h1>
    </div>

    <div class="flex justify-evenly mx-2 my-1">
      <div class="w-1/3 mx-1">
        Inscripcion 
        <select class="w-full" wire:model.lazy="inscription_id" id="inscription">
          <option value="">Todas</option>
          @foreach ($inscriptions as $inscription)
            <option value="{{ $inscription->id }}">{{ $inscription->description }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        Carreras
        <select class="w-full" wire:model.lazy="career_id" id="career">
          <option value="">Todas</option>
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        Materias
        <select class="w-full" wire:model.lazy="subject_id" id="subject">
          <option value="">Todas</option>
          @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="h-full mt-auto ml-2 mb-1 flex">
        <x-jet-button wire:click="buscarFiltros" wire:loading.attr="disabled">
          Buscar
        </x-jet-button>
        @if (count($detail) > 0)
          &nbsp;<x-jet-button wire:click="borrarRegistros" wire:loading.attr="disabled">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="red">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
            </svg>{{ count($detail) ?? 0 }}
          </x-jet-button>
        @endif
      </div>
    </div>

    <table class="table-auto w-full bg-gray-200">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-4 py-2">ID</th>
          <th class="px-4 py-2">Apellido y Nombre</th>
          <th class="px-4 py-2">Insc_ID</th>
          <th class="px-4 py-2">Valor</th>
          <th class="px-4 py-2">Materia</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($detail as $detailItem)
          <tr>
            <td class="border px-4 py-2">{{ $detailItem->user_id }}</td>
            <td class="border px-4 py-2">
              {{ $detailItem->lastname ?? '' }}, {{ $detailItem->firstname ?? ''}}</td>
            <td class="border px-4 py-2">{{ $detailItem->inscription ?? '' }}</td>
            <td class="border px-4 py-2">{{ $detailItem->value ?? '' }}</td>
            <td class="border px-4 py-2">
              {{ $detailItem->subject_id ?? '' }} {{ $detailItem->subject_name ?? '' }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>


  </div>
</div>
