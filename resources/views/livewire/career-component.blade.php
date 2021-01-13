<div>
    {{-- Formulario de Carreras --}}
    <x-jet-confirmation-modal icon='edit' wire:model="updateCareerForm">
        <x-slot name="title">
            <small>{{ $uid }} » </small><strong>{{ $name }}</strong>
        </x-slot>

        <x-slot name="content">
            ID
            <x-jet-input type='number' wire:model.lazy='uid' value='{{ $uid }}' /><br />
            Nombre
            <x-jet-input wire:model.lazy='name' value='{{ $name }}' /><br />
            Resol
            <x-jet-input wire:model.lazy='resol' value='{{ $resol }}' /><br />

            <input type="checkbox" value="@if ($active_suscribe) 0 @else 1 @endif" wire:model.lazy="active_suscribe"
                class="form-checkbox h-5 w-5 text-green-500"> Inscripciones<br />

            <input type="checkbox" value="@if ($active_eval) 0 @else 1 @endif" wire:model.lazy="active_eval"
                class="form-checkbox h-5 w-5 text-green-500"> Mesas Examen
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
            <x-jet-secondary-button wire:click="$toggle('updateCareerForm')" wire:loading.attr="disabled">
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
                <x-jet-button class="ml-2" wire:click="saveCareerChange" wire:loading.attr="disabled">
                    Modificar
                    </x-jet-danger-button>
            @endif

            </div>
        </x-slot>
    </x-jet-confirmation-modal>

    {{-- NEW Career --}}
    <x-jet-button color='green' wire:click="create">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
        </svg> Nueva
    </x-jet-button>
    <hr />



    <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th class="w-1/6 text-center py-2 px-3 uppercase font-semibold text-sm">id</th>
                <th class="w-4/6 text-center py-2 px-3 uppercase font-semibold text-sm">Nombre</th>
                <th class="text-center py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">

            @foreach ($careers as $career)

            <tr>
                <td class="w-1/6 text-left py-2 px-3 border-b">{{ $career->id }}</td>
                <td class="w-4/6 text-left py-2 px-3 border-b">{{ $career->name }}</td>
                <td class="py-2 px-3 border-b">
                <div class="flex justify-between">
                    {{-- Edit Career --}}
                    <x-jet-button wire:click="edit({{ $career }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg>
                    </x-jet-button>

                    {{-- Add/Edit Materias --}}
                    <a href='subjects/{{ $career->id }}'>
                        <x-jet-secondary-button>
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg><small>Materias</small>
                        </x-jet-secondary-button>
                    </a>
                    {{-- Delete Career --}}
                    <x-jet-danger-button wire:click="$emit('triggerDelete',{{ $career }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
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

    {{-- //scripts stack --}}
    @push('scripts')
        <script type="text/javascript">
            document.addEventListener('DOMContentLoaded', function() {
                @this.on('triggerDelete', career => {
                    Swal.fire({
                        title: 'Eliminar?',
                        text: career.name,
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
                            @this.call('destroy', career)
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
