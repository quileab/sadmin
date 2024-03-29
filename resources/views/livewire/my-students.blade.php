<div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto">
  {{-- Formulario CRUD --}}
  <x-jet-dialog-modal wire:model="openModal">
    <x-slot name="title">
      {{ $updating ? 'Actualizando' : 'Nuevo' }}
    </x-slot>
    <x-slot name="content">
      <div class="flex justify-between">
        <div class="w-1/5">
          <x-jet-label value="Calificación %" /></abbr>
          <x-jet-input type="number" wire:model.defer='Dgrade' min="0" step="5" max="100" class="w-full" />
          <x-jet-input-error for="Dgrade" />
        </div>
        <div class="w-1/5">
          <x-jet-label value="Aprobado" />
          <x-jet-secondary-button wire:click="$toggle('Dapproved')">
          @if($Dapproved)
            <x-svg.switchRight class="text-green-700" />
          @else
            <x-svg.switchLeft class="text-red-700" />
          @endif
          </x-jet-secondary-button>
          <x-jet-input-error for="Dapproved" />
        </div>
        <div class="w-1/5">
          <x-jet-label value="Asistencia %" />
          <x-jet-input type="number" wire:model.defer='Dattendance' min="0" step="5" max="100" class="w-full" />
          <x-jet-input-error for="Dattendance" />
        </div>
      </div>
      <div>
        <x-jet-label value="Observaciones" />
        <x-jet-input type="text" wire:model.defer='Dname' maxlength="200" class="w-full" />
        <x-jet-input-error for="Dname" />
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


  <div class="w-full d2c px-4 py-1 flex justify-between">
    <h1 class="py-1 mr-3">Mis Estudiantes</h1>
  </div>

  <div class="p-3">
    Carrera <select wire:model.defer="subjectId">
      @foreach ($mySubjects as $mySubject)
        <option value="{{ $mySubject->id }}">
          {{ $mySubject->id }} : {{ $mySubject->name }}
        </option>
      @endforeach
    </select>

    fecha
    <x-jet-input type="date" wire:model.defer="classDate" />

    <x-jet-button wire:click="loadData()">Buscar</x-jet-button>
    {{-- loading indicator --}}
    <div wire:loading class="spin absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
      <x-svg.wait class="w-[7rem] h-[7rem] m-0 p-0" />
    </div>

    <details>
      <summary>Reportes</summary>
      <p class="flex-center">
        <a href="printStudentsAttendance/{{ $subjectId }}" target="_blank" class="flex">
          <x-svg.documentFull />% Asistencia
        </a>
      </p>
    </details>

    @if (session()->has('message'))
      <div class="border-2 border-red-300 bg-red-50 p-3 my-1 rounded">
        {{ session('message') }}
      </div>
    @endif
    @if ($classDay != null)
      <div class="border-2 border-blue-300 bg-blue-50 p-3 my-1 rounded">
        <strong>{{ $classDay->Contents }}</strong>
        <br />#{{ $classDay->ClassNr }} U:{{ $classDay->Unit }}
        » <small>{{ $classDay->Activities }}</small>
      </div>
    @endif
    <table class="table-auto w-full bg-gray-200 rounded-md overflow-hidden">
      <thead class="bg-gray-800 text-white">
        <tr>
          <th class="px-4 py-2">Apellido y Nombre</th>
          @if (!session()->has('message'))
            <th class="px-4 py-2">Asistencia</th>
            <th class="px-4 py-2">Calif.</th>
            <th class="px-4 py-2">Descripción</th>
            <th class="px-4 py-2"><x-svg.menu />
          @endif
        </tr>
      </thead>
      <tbody>
        @foreach ($myStudents as $key => $myStudent)
          <tr wire:key='att-{{ $loop->index }}'>
            <td class="border px-4 py-2">
              <a href="printStudentsStats/{{$myStudent->id}}/{{$subjectId}}" target="_blank" class="flex">
              <x-svg.documentFull />&nbsp;
              {{ ucwords(strtolower($myStudent->lastname)) }},              
              {{ ucwords(strtolower($myStudent->firstname)) }}
              </a>
            </td>
            @if (!session()->has('message'))
            <td class="border px-4 py-2 text-right">
              {{ $studentData[$myStudent->id]['attendance'] }} %
              <div class="inline-flex rounded-md shadow text-sm font-medium text-gray-300 bg-gray-700 overflow-hidden" role="group">
                <button type="button" class="px-2 py-1 focus:z-10 focus:ring-2 border border-gray-400 hover:text-white hover:bg-gray-600 focus:text-white"
                  wire:click="setAttendance({{ $myStudent->id }},100)"><small>100</small></button>
                <button type="button" class="px-2 py-1 focus:z-10 focus:ring-2 border border-gray-400 hover:text-white hover:bg-gray-600 focus:text-white"
                  wire:click="setAttendance({{ $myStudent->id }},50)"><small>50</small></button>
                <button type="button" class="px-2 py-1 focus:z-10 focus:ring-2 border border-gray-400 hover:text-white hover:bg-gray-600 focus:text-white"
                  wire:click="setAttendance({{ $myStudent->id }},0)"><small>0</small></button>
              </div>
            </td>
            <td class="border px-4 py-2 text-right">
              {{ $studentData[$myStudent->id]['grade'] }} %
            </td>
            <td class="border px-4 py-2">
              {{ $studentData[$myStudent->id]['name'] }}
            </td>
            <td>
              <x-jet-button wire:click="edit({{ $myStudent->id }})">
                <x-svg.edit />
              </x-jet-danger-button>
            </td>
            @endif
          </tr>
        @endforeach
      </tbody>
    </table>
    {{-- <pre>
        {{ print_r($studentData) }}
        <hr />
        {{ var_dump($classDate) }}
    </pre> --}}

  </div>
</div>