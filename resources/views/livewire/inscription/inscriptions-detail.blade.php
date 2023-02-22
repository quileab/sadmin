<div>
  <x-jet-dialog-modal wire:model="openModal">
    <x-slot name="title">
        Calificar
    </x-slot>
    <x-slot name="content">

      <div class="inline-flex">
      <div>
      <x-jet-label value="Calificación" />
      <x-jet-input type="number" wire:model.defer='grade' id="grade" />
      <x-jet-input-error for="grade" />
      </div>

        <div class="mx-2 p-1 border rounded border-gray-300 text-center">
          <x-jet-label value="Aprobado" />
          <x-jet-input type="checkbox" wire:model.defer='approved' id="approved" />
          <x-jet-input-error for="approved" />
        </div>

        <div class="mx-2 p-1 border rounded border-gray-300 text-center bg-red-300">
          <x-jet-label value="Eliminar" />
          <x-jet-input type="checkbox" wire:model.defer='remove' id="remove" />
          <x-jet-input-error for="remove" />
        </div>
      </div>

      
      <x-jet-label value="Descripción" />
      <x-jet-input type="text" wire:model.defer='description' id="description" />
      <x-jet-input-error for="description" />
    </x-slot>
    <x-slot name="footer">
      <div class="flex justify-between">
        @if ($errors->any())
          <div class="text-yellow-300">Verifique la información ingresada</div>
        @endif
        <x-jet-button wire:click="updateOrSaveGrade" wire:loading.attr="disabled" wire:target="save">
          Guardar
        </x-jet-button>
        <x-jet-danger-button wire:click="$set('openModal',false)">Cancelar</x-jet-danger-button>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="bg-gray-300 max-w-6xl mx-auto mb-2 pb-4">
    <div class="w-full d2c px-4 py-1 flex justify-between">
      <h1 class="py-1 mr-3">Calificación Rápida</h1>
      @if (count($inscriptions) > 0)
      &nbsp;
      <x-jet-button wire:click="borrarRegistros" wire:loading.attr="disabled">
        <x-svg.trash class="h-4 w-4" /> {{ count($inscriptions) ?? 0 }}
      </x-jet-button>
    @endif

    </div>

    <div class="flex justify-evenly mx-2 my-1">
      <div class="w-1/3 mx-1">
        <small>Inscripcion</small> 
        <select class="w-full" wire:model.lazy="inscriptionType_id" id="inscriptionType">
          <option value="">Todas</option>
          @foreach ($inscriptionTypes as $inscriptionType)
            <option value="{{ $inscriptionType->id }}">{{ $inscriptionType->description }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        <small>Carreras</small>
        <select class="w-full" wire:model.lazy="career_id" id="career">
          <option value="">Todas</option>
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->id }} {{ $career->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        <small>Materias</small>
        <select class="w-full" wire:model.lazy="subject_id" id="subject">
          <option value="">Todas</option>
          @foreach ($subjects as $subject)
            <option value="{{ $subject->id }}">{{ $subject->id }} {{ $subject->name }}</option>
          @endforeach
        </select>
      </div>
      <div class="w-1/3 mx-1">
        <small>Fecha</small>
        <x-jet-input type="date" wire:model.lazy="gradeDate" class='w-full' />
      </div>
  
      <div class="h-full mt-auto ml-2 mb-1 flex">
        <x-jet-button wire:click="buscarFiltros" wire:loading.attr="disabled">
          Buscar
        </x-jet-button>
      </div>
    </div>

    <table class="table-auto w-full bg-gray-200 rounded-md overflow-hidden shadow-md">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-4 py-2">Apellido y Nombre</th>
          <th class="px-4 py-2">Insc / Materia</th>
          <th class="px-4 py-2">Valor</th>
          <th class="px-4 py-2">Calif.</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($inscriptions as $key=>$inscription)
          <tr @class([
            'text-green-700 font-bold'=>$inscription['approved'],
            'bg-red-200'=>!$inscription['enabled']
            ])>
            <td class="border px-4 py-1">
              {{ $inscription['full_name'] ?? '' }} <small>({{ $inscription['user_id'] }})</small></td>
            <td class="border px-4 py-1 text-xs">
              {{ $inscription['inscription'] ?? '' }}<br />
              {{ $inscription['subject_name'] ?? '' }}
            </td>
            <td class="border px-4 py-1">{{ $inscription['value'] ?? '' }}</td>
            <td class="border px-4 py-1 text-right text-lg">
              {{ $inscription['grade'] ?? '' }}&nbsp;
              <x-jet-button wire:click="edit({{$key}})"><x-svg.edit /></x-jet-button>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </div>

    <!-- Loading indicator -->
    <div wire:loading class="spin absolute top-2 left-1/2">
      <x-svg.loading class="w-[2rem] h-[2rem] m-0 p-0 text-white" />
    </div>
</div>
