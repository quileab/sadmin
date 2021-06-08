<div wire:init="loadData">
    {{-- Formulario CRUD Estudiantes --}}
    <x-jet-dialog-modal icon='edit' wire:model="openModal">
        <x-slot name="title">
            <small>ID: </small><strong>{{ $uid }}</strong> » <small>Usuario: </small><strong>{{ $name }}</strong>
        </x-slot>

        <x-slot name="content">
            Personal ID
            <x-jet-input type='number' wire:model.lazy='pid' value='{{ $pid }}' /><br />
            Apellido/s
            <x-jet-input type='text' wire:model.lazy='lastname' value='{{ $lastname }}' /><br />
            Nombre/s
            <x-jet-input type='text' wire:model.lazy='firstname' value='{{ $name }}' /><br />
            EMail
            <x-jet-input type='email' wire:model.lazy='email' value='{{ $email }}' /><br />
            Teléfono
            <x-jet-input type='tel' wire:model.lazy='phone' value='{{ $phone }}' /><br />
            <small>Se muestran las carreras a las cuales está anotado</small>
            Carrera/s » {{ $career_id }}
            <select wire:model.lazy="career_id" name="career_id" id="career_id">
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}"
                        @if ($career->id==$career_id) selected @endif
                        >{{ $career->name}}</option>
                @endforeach
            </select><br />
            
            {{-- Habilitado --}}
            <input type="checkbox" value="@if ($enabled) 0 @else 1 @endif" wire:model.lazy="enabled"
            class="form-checkbox h-5 w-5 text-green-500">&nbsp;Habilitado<br />


        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
            <x-jet-secondary-button wire:click="$toggle('openModal')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>


            @if ($formAction == 'store')
                <x-jet-button wire:click="store"
                class="text-white font-bold px-3 py-1 rounded text-xs">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                      </svg> Crear
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
    <a href="{{route('students-import-form')}}">
    <x-jet-button>
         Importar Alumnos&nbsp;
         <span class="inline-flex items-center justify-center px-2 py-1 text-xs leading-none text-red-100 bg-blue-600 rounded-full">.csv</span>
    </x-jet-button>
    </a>
    <hr />

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
        <x-jet-button wire:click="create()" color="green">Nuevo Ingreso</x-jet-danger-button>
      </div>
      <table class="min-w-full divide-y divide-gray-200">
        <thead class="text-gray-100 bg-cool-gray-700">
          <tr>
            <th scope="col"
              class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
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
            <th scope="col"
              class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
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
            <th scope="col"
              class="cursor-pointer px-4 py-3 text-left text-xs font-medium uppercase tracking-wider"
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
            <th scope="col" class="relative px-4 py-3">
              <span class="sr-only">ACCIONES</span>
            </th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($students as $student)
            <tr class="hover:bg-gray-100 {{ $student->enabled ? 'bg-blue-100' : '' }}">
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $student->id }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900">{{ $student->pid }}</div>
              </td>
              <td class="px-6 py-4">
                <div class="text-sm text-gray-900"><b>{{ $student->lastname }}</b>, {{ $student->firstname }}<br />
                {{ $student->email }} | {{ $student->phone }}
                </div>
              </td>

              <td class="w-80 bg-gray-100 px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                {{-- <a href="#" class="text-indigo-600 hover:text-indigo-900">Edit</a> --}}
                <button wire:click="edit('{{ $student->id }}')" class="mr-2">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                  </svg>
                </button>
                {{-- Add/Edit Subject->Grades --}}
                <a href='subjects/{{ $student->id }}'>
                    <x-jet-button>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path d="M12 14l9-5-9-5-9 5 9 5z" />
                            <path d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14zm-4 6v-7.5l4-2.222" />
                          </svg>&nbsp;<small>Materias</small>
                    </x-jet-secondary-button>
                </a>
                <button wire:click="$emit('confirmDelete','{{$student->lastname}}, {{ $student->firstname }}','{{ $student->id }}')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="red">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
