<div wire:init="loadData">
  {{-- Formulario CRUD Estudiantes --}}
  <x-jet-dialog-modal icon='edit' wire:model="openModal">
    <x-slot name="title">
      <div class="flex justify-between">
        <div><small>{{ $uid }}</small> » <strong>{{ $name }}</strong></div>
        <div class="flex">
          <details class="w-32 text-right">
            <summary>⚙️</summary>
            <p><x-jet-button wire:click="passReset()">Reset Password</x-jet-button></p>
          </details>
        </div>
      </div>
    </x-slot>

    <x-slot name="content">

      <div class="flex items-center">
        <div class="w-1/3 ml-3">
          <x-jet-label value="ID/DNI" />
          <x-jet-input type="number" class="w-full" wire:model.defer='pid' />
          <x-jet-input-error for="pid" />
        </div>

        <div class="w-1/3 mx-auto">
          {{-- Habilitado --}}
          <x-jet-label value="Condición en el Sistema" />
          <input type="checkbox" value="@if ($enabled) 0 @else 1 @endif" wire:model.lazy="enabled"
            class="form-checkbox h-5 w-5 text-green-500">&nbsp;Habilitado
        </div>
      </div>

      <div class="flex">
        <div class="w-1/3 ml-3">
          <x-jet-label value="Apellido/s" />
          <x-jet-input type='text' wire:model.lazy='lastname' value='{{ $lastname }}' class="w-full" />
          <x-jet-input-error for="lastname" />
        </div>
        <div class="w-2/3 ml-3">
          <x-jet-label value="Nombre/s" />
          <x-jet-input type='text' wire:model.lazy='firstname' value='{{ $name }}' class="w-full" />
          <x-jet-input-error for="firstname" />
        </div>
      </div>

      <div class="flex">
        <div class="w-full ml-3">
          <x-jet-label value="EMail" />
          <x-jet-input type='email' wire:model.lazy='email' value='{{ $email }}' class="w-full" />
          <x-jet-input-error for="email" />
        </div>
        <div class="w-full ml-3">
          <x-jet-label value="Teléfono" />
          <x-jet-input type='tel' wire:model.lazy='phone' value='{{ $phone }}' class="w-full" />
          <x-jet-input-error for="phone" />
        </div>
      </div>

      @if ($updating)
        <fieldset class="bg-gray-300 my-2 rounded-md overflow-hidden">
          <legend class="px-2 bg-gray-300 p-1 rounded-md text-gray-900">Carreras</legend>
          @foreach ($student_careers as $item)
            <div class="mx-1 rounded-md flex justify-between bg-gray-100 my-1">
              <span class="p-2">{{ $item->name }}</span>
              <x-jet-secondary-button
                wire:click="$emit('confirmDelete','{{ $item->name }}','{{ $item->id }}','deleteCareer')"
                class="w-4/4">
                <x-svg.trash class="h-5 w-5 text-red-700" />
              </x-jet-secondary-button>
            </div>
          @endforeach
          <div class="p-2 flex justify-between items-center">
            <span class="text-gray-900">Agregar Carrera/s</span>
            <select wire:model="career_id" name="career_id" id="career_id">
              @foreach ($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
              @endforeach
            </select>
            <x-jet-button wire:click="addCareer">Agregar</x-jet-button>
          </div>
        </fieldset>
      @endif

    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('openModal')" wire:loading.attr="disabled">
          Salir
        </x-jet-secondary-button>

        @if ($formAction == 'store')
          <x-jet-button wire:click="store" class="text-white font-bold px-3 py-1 rounded text-xs">
            <x-svg.plusCircle class="w-5 h-5" />&nbsp;Crear
          </x-jet-button>
        @else
          <x-jet-button class="ml-2" wire:click="saveChange" wire:loading.attr="disabled">
            Modificar
          </x-jet-button>
        @endif

      </div>
    </x-slot>
  </x-jet-dialog-modal>


  <div class="flex items-center d2c px-4">
    <select wire:model="cant" class="mr-2 rounded-md shadow-sm">
      <option value="10">10</option>
      <option value="25">25</option>
      <option value="50">50</option>
      <option value="100">100</option>
    </select>

    {{-- SEARCH --}}
    <x-jet-input class="flex-1" type="search" placeholder="Ingrese su búsqueda aquí" wire:model.lazy="search" />
    <x-jet-secondary-button wire:click="render" class="mr-2 py-2.5">
      <x-svg.search />
    </x-jet-secondary-button>
    {{-- select career --}}
    <div class="inline text-sm mr-2">
      <select wire:model="careerSelected" name="careerSelected" id="careerSelected" class="truncate w-36 py-1">
        @foreach ($careers as $career)
          <option value="{{ $career->id }}">{{ $career->name }}</option>
        @endforeach
        <option value="">*none*</option>
      </select><br>
      {{-- select role --}}
      <select wire:model="roleSelected" name="roleSelected" id="roleSelected" class="truncate w-36 py-1">
        @foreach ($roles as $role)
          <option value="{{ $role->id }}">{{ $role->name }}</option>
        @endforeach
        <option value="0">*none*</option>
      </select>
    </div>

    <div class="block">
      <x-jet-button wire:click="create">Nuevo Ingreso</x-jet-button>
      <br>
      <div class="bg-gray-800 text-gray-100 rounded my-1 pb-1 px-2">
        <label><input type="checkbox" wire:model="globalSearch"> <span class="uppercase text-xs">GLOBAL por
            ROL</span></label>
      </div>
    </div>
  </div>
    <table class="w-full">
      <thead>
        <tr>
          <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
            wire:click="order('id')">
            ID
            @if ($sort != 'id')
              <x-sortNone />
            @else
              @if ($direction == 'asc')
                <x-sortUp />
              @else
                <x-sortDown />
              @endif
            @endif
          </th>
          <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
            wire:click="order('pid')">
            PID
            @if ($sort != 'pid')
              <x-sortNone />
            @else
              @if ($direction == 'asc')
                <x-sortUp />
              @else
                <x-sortDown />
              @endif
            @endif
          </th>
          <th scope="col" class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
            wire:click="order('lastname')">
            Apellido y Nombre
            @if ($sort != 'lastname')
              <x-sortNone />
            @else
              @if ($direction == 'asc')
                <x-sortUp />
              @else
                <x-sortDown />
              @endif
            @endif
          </th>
          <th scope="col" class="text-center text-xs font-medium uppercase tracking-wider">
            ACCIONES
          </th>
        </tr>
      </thead>
      <tbody class="bg-white text-black divide-y divide-gray-400">
        @foreach ($students as $student)
          <tr @class(['hover:bg-blue-100', 'text-red-800' => !$student->enabled])>
            <td class="px-6 py-1">
              <div>{{ $student->id }}</div>
            </td>
            <td class="px-6 py-1">
              <div class="text-sm">{{ $student->pid }}</div>
            </td>
            <td class="px-6 py-1">
              <div><strong>{{ $student->lastname }}, {{ $student->firstname }}</strong><br />
                <small>{{ $student->email }} | {{ $student->phone }}</small>
              </div>
            </td>

            <td class="mt-1 text-sm">
              <div class="inline-flex rounded-lg overflow-hidden">
                <button wire:click="edit('{{ $student->id }}')" class="gradl2r text-white border-r px-3 py-1">
                  <x-svg.edit class="h-6 w-6" />
                </button>
                {{-- Add/Edit Materias --}}
                @if (count($student->careers))
                  <a href='grades/{{ $student->id }}'>
                    <button class="gradl2r text-white border-r px-3 py-1">
                      <x-svg.academicCap class="h-7 w-7" />
                    </button>
                  </a>
                @else
                  <button class="gradl2r text-white border-r px-3 py-1">
                    <x-svg.academicCap class="h-7 w-7" />
                  </button>
                @endif
                <a href='userpayments/{{ $student->id }}'>
                  <button class="gradl2r text-white border-r px-3 py-1">
                    <x-svg.dolarRound class="h-7 w-7" />
                  </button>
                </a>
                <button class="gradl2r text-white border-r px-3 py-1"
                  wire:click="$emit('setBookmark','{{ $student->id }}')">
                  <x-svg.bookmarkPlus class="h-6 w-6" />
                </button>
                <button class="bg-red-700 text-white px-3 py-1 ml-1"
                  wire:click="$emit('confirmDelete','{{ $student->lastname }}, {{ $student->firstname }}','{{ $student->id }}','delete')">
                  <x-svg.trash class="h-6 w-6" />
                </button>
              </div>
            </td>
          </tr>
        @endforeach
        <!-- More items... -->
      </tbody>
    </table>
    @if (count($students))
      <div class="px-5 py-2 bg-gray-300">
        {{ $students->links() }}
      </div>
    @endif

  <!-- Loading indicator -->
  <div wire:loading class="spin fixed top-2 left-1/2 rounded-full bg-black bg-opacity-50">
    <x-svg.loading class="w-[3rem] h-[3rem] m-0 p-0 text-white" />
  </div>
</div>
