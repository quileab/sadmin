<div wire:init="loadData">
  {{-- Formulario CRUD Estudiantes --}}
  <x-jet-dialog-modal icon='edit' wire:model="openModal">
    <x-slot name="title">
      <small>ID: </small><strong>{{ $uid }}</strong> » <small>Usuario:
      </small><strong>{{ $name }}</strong>
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
            <select wire:model.lazy="career_id" name="career_id" id="career_id" class="bg-white">
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
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>&nbsp;Crear
          </x-jet-button>
        @else
          <x-jet-button class="ml-2" wire:click="saveChange" wire:loading.attr="disabled">
            Modificar
          </x-jet-button>
        @endif

      </div>
    </x-slot>
  </x-jet-dialog-modal>

  {{-- Import Students --}}
  <div class="w-full text-right">
  <a href="{{ route('students-import-form') }}">
    <x-jet-button>
      Importar Alumnos&nbsp;
      <span class="inline-flex items-center justify-center px-2 py-1 text-xs leading-none text-gray-50 bg-blue-600 rounded-full">
        .csv</span>
    </x-jet-button>
  </a>
  </div>

  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- This example requires Tailwind CSS v2.0+ -->
    <x-table>
      <div class="px-4 py-2 flex items-center d2c">
        <div class="flex item center">
          <span class="mt-3">Mostrar&nbsp;</span>
          <select wire:model="cant"
            class="mr-4 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
            <option value="10">10</option>
            <option value="25">25</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
        </div>

        <x-jet-input class="flex-1 mr-4" type="search" placeholder="Ingrese su búsqueda aquí" wire:model="search" />
        <x-jet-button wire:click="create" color="green">Nuevo Ingreso</x-jet-danger-button>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="text-gray-100 bg-cool-gray-700">
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
            <tr class="hover:bg-yellow-100 {{ !$student->enabled ? 'bg-red-200' : '' }}">
              <td class="px-6 py-1">
                <div>{{ $student->id }}</div>
              </td>
              <td class="px-6 py-1">
                <div class="text-sm text-gray-900">{{ $student->pid }}</div>
              </td>
              <td class="px-6 py-1">
                <div><b>{{ $student->lastname }}</b>, {{ $student->firstname }}<br />
                  {{ $student->email }} | {{ $student->phone }}
                </div>
              </td>

              <td class="px-6 py-1 flex justify-between text-sm font-medium">
                {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a> --}}
                <button wire:click="edit('{{ $student->id }}')" class="bg-blue-600 text-white px-3 py-2 rounded-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                {{-- Add/Edit Materias --}}
                @if (count($student->careers))
                  <a href='grades/{{ $student->id }}'>
                    <button class="bg-indigo-600 text-white px-3 py-2 rounded-md">
                      <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                      </svg>
                    </button>
                  </a>
                @else
                  <button class="bg-indigo-600 text-white px-3 rounded-md opacity-50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path d="M12 14l9-5-9-5-9 5 9 5z" />
                      <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                    </svg>
                </button>
                @endif
                <a href='userpayments/{{ $student->id }}'>
                <button class="bg-green-600 text-white px-3 py-2 rounded-md">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                  </svg>
                </button>
                </a>
                <button class="bg-red-600 text-white px-3 py-2 rounded-md"
                  wire:click="$emit('confirmDelete','{{ $student->lastname }}, {{ $student->firstname }}','{{ $student->id }}','delete')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                </button>
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
