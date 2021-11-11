<div>
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-2">
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
      <h1 class="py-1 mr-3">Filtros</h1>
    </div>

    <div class="flex justify-evenly mx-2 my-1">
      <div class="w-1/3 mx-1">
        Inscripcion<br />
        <select class="w-full" wire:model.lazy="inscription_id" id="inscription">
          <option value="">Todas</option>
          @foreach ($inscriptions as $inscription)
            <option value="{{ $inscription->id }}">{{ $inscription->description }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        Carreras<br />
        <select class="w-full" wire:model.lazy="career_id" id="career">
          <option value="">Todas</option>
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        Materias<br />
        <select class="w-full" wire:model.lazy="subject_id" id="subject">
          <option value="">Todas</option>
          @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="h-full mt-auto ml-2 mb-1">
        <x-jet-button wire:click="buscarFiltros" wire:loading.attr="disabled">
          Buscar
        </x-jet-button>
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
