<div>
  {{-- Formulario CRUD --}}
  <x-jet-dialog-modal wire:model="openModal">
    <x-slot name="title">
      {{ $updating ? 'Actualizando' : 'Nuevo' }}
    </x-slot>
    <x-slot name="content">
      <div class="w-2/5">
        <x-jet-label value="Fecha" />
        <x-jet-input type="date" wire:model.defer='date_id' />
        <x-jet-input-error for="date" />
      </div>
      <div class="flex justify-between">
        <div class="w-1/5">
          <x-jet-label value="Clase #" />
          <x-jet-input type="number" wire:model.defer='classnr' class="w-full" />
          <x-jet-input-error for="classnr" />
        </div>
        <div class="w-1/5">
          <abbr title='Utilice "0" para indicar que no hubo clase'>
          <x-jet-label value="Unidad (?)" /></abbr>
          <x-jet-input title='Utilice 0 para indicar que no hubo clase' type="number" wire:model.defer='unit' class="w-full" />
          <x-jet-input-error for="unit" />
        </div>
        <div class="w-2/5">
          <x-jet-label value="Tipo" />
          <x-jet-input type="text" wire:model.defer='type' list="types" maxlength="25" class="w-full" />
          <datalist id="types">
            <option value="Expositivo">
            <option value="Teórico">
            <option value="Práctico">
            <option value="Teórico-Práctico">
            <option value="Evaluativo">
            <option value="Introductorio">
          </datalist>
          <x-jet-input-error for="type" />
        </div>
      </div>
      <div class="flex justify-between">
        <div class="w-1/2 mr-1">
          <x-jet-label value="Contenido/s" />
          <textarea wire:model.defer="contents" maxlength="240" rows="5" class="w-full"></textarea>
          <!--x-jet-input type="text" wire:model.defer='contents' / -->
          <x-jet-input-error for="contents" />
        </div>
        <div class="w-1/2 ml-1">
          <x-jet-label value="Actividades" />
          <textarea wire:model.defer="activities" maxlength="100" rows="5" class="w-full"></textarea>
          <!--x-jet-input type="text" wire:model.defer='activities' /-->
          <x-jet-input-error for="activities" />
        </div>
      </div>
        <div>
          <x-jet-label value="Observaciones" />
          <x-jet-input type="text" wire:model.defer='observations' maxlength="60" class="w-full" />
          <x-jet-input-error for="observations" />
        </div>

    </x-slot>
    <x-slot name="footer">
      <div class="flex justify-between">
        @if ($errors->any())
          <div class="text-yellow-300">Verifique la información ingresada</div>
        @endif

        @if ($updating)
        <x-jet-button wire:click="update" wire:loading.attr="disabled" wire:target="save">
          Actualizar
        </x-jet-button>
        @else
        <x-jet-button wire:click="save" wire:loading.attr="disabled" wire:target="save">
          Guardar
        </x-jet-button>
        @endif
        <x-jet-danger-button wire:click="$set('openModal',false)">Cancelar</x-jet-danger-button>
      </div>
    </x-slot>
  </x-jet-dialog-modal>
<!-- --- Listado de Classes --- -->
  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden w-full">
    <div class="w-full d2c px-4 py-1 flex justify-between">
      <h1 class="py-1 mr-3">Libro de Temas</h1>

      <div>
        <x-jet-button wire:click="createCalendar">
          @if($calendar=='')
            <x-svg.calendar />
          @else
            <x-svg.calendarX />
          @endif
          Calendario
        </x-jet-button>      
        @if($subjectId>0)
        <x-jet-button wire:click="createOrUpdate(0)">
          <x-svg.plusCircle />
          Nuevo Registro
        </x-jet-button>
        @endif
        </div>
    </div>

    <div class="p-2">
      <label for="carrera">Materia </label>
      <select id='carrera' wire:model="subjectId">
        @foreach ($mySubjects as $mySubject)
        <option value="{{ $mySubject->id }}">
          {{ $mySubject->id }} : {{ $mySubject->name }}
        </option>
        @endforeach
      </select>

      <a href='printClassbooks/{{ $subjectId }}' target='_blank'>
      <x-jet-button><x-svg.print /> Imprimir</x-jet-button>
      </a>
      <!-- Loading indicator -->
      <div wire:loading wire:target="subjectId" class="spin">
        <x-svg.wait class="w-7 h-7" />
      </div>
      <!-- ----------------- -->
      {!! $calendar !!}
      <br />
      <table class="table-auto w-full bg-gray-200 rounded-md overflow-hidden">
        <thead class="bg-gray-800 text-white">
          <tr>
            <th class="px-4 py-2">Fecha</th>
            <th class="px-4 py-2">Unidad</th>
            <th class="px-4 py-2">Contenido</th>
            <th class="px-4 py-2">Actividades</th>
            <th class="px-4 py-2">Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($subject_classes as $class)
            <tr>
              <td class="border px-4 py-2"><small>{{ \Carbon\Carbon::createFromFormat('Y-m-d', $class->date_id)->format('d-m') }}</td>
              <td class="border px-4 py-2">{{ $class->Unit }}</td>
              <td class="border px-4 py-2">{{ $class->Contents }}</td>
              <td class="border px-4 py-2">{{ $class->Activities }}</td>
              <td class="border rounded-md overflow-hidden px-4 py-2 flex justify-evenly">
                <x-jet-button wire:click="createOrUpdate('{{ $class->date_id }}')">
                  <x-svg.edit />
                </x-jet-button>
                <x-jet-danger-button>
                  <x-svg.trash />
                </x-jet-danger-button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
