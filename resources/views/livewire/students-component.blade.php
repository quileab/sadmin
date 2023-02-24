<div wire:init="loadData">
  {{-- Formulario CRUD Estudiantes --}}
  <x-jet-dialog-modal icon='edit' wire:model="openModal">
    <x-slot name="title">
      <small>{{ $uid }}</small> » <strong>{{ $name }}</strong>
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
          <input type="checkbox" value="@if ($enabled) 0 @else 1 @endif"
            wire:model.lazy="enabled" class="form-checkbox h-5 w-5 text-green-500">&nbsp;Habilitado
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
        <fieldset class="bg-gray-500 my-2 rounded-md overflow-hidden">
          <legend class="px-2 bg-gray-500 p-1 rounded-md text-gray-50">Carreras</legend>
          @foreach ($student_careers as $item)
            <div class="mx-1 rounded-md flex justify-between bg-gradient-to-b from-gray-200 to-gray-300 my-1">
              <span class="p-2">{{ $item->name }}</span>
              <x-jet-button
                wire:click="$emit('confirmDelete','{{ $item->name }}','{{ $item->id }}','deleteCareer')"
                color="red" class="w-4/4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                  <path fill-rule="evenodd"
                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                    clip-rule="evenodd" />
                </svg>
              </x-jet-button>
            </div>
          @endforeach
          <div class="p-2 flex justify-between items-center">
            <span class="text-gray-50">Agregar Carrera/s</span>
            <select wire:model="career_id" name="career_id" id="career_id">
              @foreach ($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
              @endforeach
            </select>
            <x-jet-button wire:click="addCareer">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
              </svg>&nbsp;Agregar</x-jet-button>
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

  <div class="w-full px-3 sm:px-4 lg:px-6">
    <x-table>
      <div class="px-3 py-1 flex items-center d2c">
        <div class="flex item center">
          <select wire:model="cant"
            class="mr-2 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>
        {{-- SEARCH --}}
        <x-jet-input class="flex-1" type="search" placeholder="Ingrese su búsqueda aquí" wire:model.lazy="search" />
        <x-jet-secondary-button wire:click="render" class="mr-2 py-2.5">
          <x-svg.search />
        </x-jet-secondary-button>
        {{-- select career --}}
        <div class="inline text-sm mr-2">
        <select wire:model="careerSelected" name="careerSelected" id="careerSelected" 
          class="truncate w-36 py-1">
          @foreach ($careers as $career)
            <option value="{{ $career->id }}">{{ $career->name }}</option>
          @endforeach
            <option value="">*none*</option>
        </select><br>
        {{-- select role --}}
        <select wire:model="roleSelected" name="roleSelected" id="roleSelected"
          class="truncate w-36 py-1">
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
          <label><input type="checkbox" wire:model="globalSearch"> <span class="uppercase text-xs">GLOBAL por ROL</span></label>
        </div>
        </div>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
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
            <tr @class([
              'hover:bg-yellow-100',
              'text-red-800'=>!$student->enabled,
              ])>
              <td class="px-6 py-1">
                <div>{{ $student->id }}</div>
              </td>
              <td class="px-6 py-1">
                <div class="text-sm">{{ $student->pid }}</div>
              </td>
              <td class="px-6 py-1">
                <div><b>{{ $student->lastname }}</b>, {{ $student->firstname }}<br />
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
    </x-table>
  </div>

</div>
