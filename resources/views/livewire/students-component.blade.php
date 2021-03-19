<div>
    {{-- Formulario de Datos de Estudiantes --}}
    <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
        <x-slot name="title">
            USUARIO <small>{{ $uid }} » </small><strong>{{ $name }}</strong>
        </x-slot>

        <x-slot name="content">
            ID: <strong>{{ $uid }}</strong><br />
            Apellido/s
            <x-jet-input type='text' wire:model.lazy='lastname' value='{{ $lastname }}' /><br />
            Nombre/s
            <x-jet-input type='text' wire:model.lazy='firstname' value='{{ $name }}' /><br />
            Teléfono
            <x-jet-input type='tel' wire:model.lazy='phone' value='{{ $phone }}' /><br />
            Carrera » {{ $career_id }}
            <select wire:model.lazy="career_id" name="career_id" id="career_id">
                @foreach ($careers as $career)
                    <option value="{{ $career->id }}"
                        @if ($career->id==$career_id) selected @endif
                        >{{ $career->name}}</option>
                @endforeach
            </select><br />
            
            {{-- Habilitado --}}
            <input type="checkbox" value="@if ($enabled) 0 @else 1 @endif" wire:model.lazy="enabled"
            class="form-checkbox h-5 w-5 text-green-500"> Habilitado<br />


        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
            <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>


            @if ($formAction == 'store')
                <x-jet-button wire:click="store" color="green"
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
    </x-jet-confirmation-modal>

    {{-- Import Students --}}
    <a href="{{route('students-import-form')}}">
    <x-jet-button color='green'>
         Importar Alumnos&nbsp;
         <span class="inline-flex items-center justify-center px-2 py-1 text-xs leading-none text-red-100 bg-blue-600 rounded-full">.csv</span>
    </x-jet-button>
    </a>
    <hr />

    {{-- Search Box --}}
    <div class="flex border-gray-300 border rounded-md mb-2 shadow">
        <input class="w-full rounded m-0 pl-2 overflow-hidden" type="text" wire:model.lazy='search' value='{{ $search }}' placeholder="Buscar...">
        <button class="bg-gray-100 border-gray-400 shadow hover:bg-gray-50 border-l overflow-hidden">
          <span class="w-auto flex justify-end items-center text-grey p-2 hover:text-grey-darkest">
              <i class="material-icons text-xl">search</i>
          </span>
        </button>
    </div>

    <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">id</th>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Usuario</th>
                <th class="w-4/7 text-center py-2 px-3 uppercase font-semibold text-sm">Nombre +</th>
                <th class="text-center py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">

            @foreach ($students as $student)

            <tr class="@if ($student->enabled) text-black @else text-gray-500 @endif">
                <td class="w-1/7 text-left py-2 px-3 border-b">{{ $student->id }}</td>
                <td class="w-1/7 text-left py-2 px-3 border-b">{{ $student->name }}</td>
                <td class="w-4/7 text-left py-2 px-3 border-b">{{ $student->lastname }}, {{ $student->firstname }} // {{ $student->email }} // {{ $student->phone }}</td>
                <td class="py-2 px-3 border-b">
                <div class="flex justify-between">
                    {{-- Edit Student --}}
                    <x-jet-button wire:click="edit({{ $student }})">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </x-jet-button>
                    {{-- Add/Edit Subject->Grades --}}
                    <a href='subjects/{{ $student->id }}'>
                        <x-jet-secondary-button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg><small>Materias</small>
                        </x-jet-secondary-button>
                    </a>
                    {{-- Delete Student --}}
                    <x-jet-danger-button wire:click="$emit('triggerDelete',{{ $student }})">
                        <svg fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </x-jet-danger-button>
                </div>
                </td>
            </tr>

            @endforeach

        </tbody>
    </table>

    {{ $students->links() }}

    {{-- //scripts stack --}}
    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                @this.on('triggerDelete', item => {
                    Swal.fire({
                        title: 'Eliminar?',
                        text: item.lastname,
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        cancelButtonColor: '#1c64f2',
                        confirmButtonText: 'Eliminar',
                        confirmButtonColor: '#e02424',

                    }).then((result) => {
                        //if user clicks on delete
                        if (result.value) {
                            // calling destroy method to delete
                            @this.call('destroy', item)
                            // success response
                            Toast.fire('Eliminado', '', 'success');

                        } else {
                            Toast.fire('Cancelado', '', 'error');
                        }
                    });
                });
            })

        </script>
    @endpush

</div>
