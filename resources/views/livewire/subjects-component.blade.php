<div>
    {{-- Formulario de Carreras --}}
    <x-jet-confirmation-modal wire:model="updateSubjectForm">
        <x-slot name="title">
            Materia
        </x-slot>

        <x-slot name="content">
            ID <x-jet-input type='number' wire:model='uid' value={{ $uid }} /><br />
            Nombre <x-jet-input wire:model='name' value={{ $name }} /><br />
            IDs de Correlatividades <x-jet-input wire:model='correl' value={{ $correl }} /><br />
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updateSubjectForm')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveSubjectChange" wire:loading.attr="disabled">
                Modificar
                </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <div class="bg-white rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
        <div class="w-full d2c px-4 py-3 text-white">
            <h1>Materias</h1> <small>{{ $career_id }} » <strong>{{ $career_name }}</strong></small>
        </div>
        <div class="p-4">

            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead class="bg-gray-700 text-white">
                    <tr>
                        <th class="w-1/5 text-left py-2 px-3 uppercase font-semibold text-sm">id</th>
                        <th class="w-3/5 text-left py-2 px-3 uppercase font-semibold text-sm">Nombre</th>
                        <th class="text-left py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach ($subjects as $subject)
                        <tr>
                            <td class="w-1/5 text-left py-2 px-3 border-b">{{ $subject->id }}</td>
                            <td class="w-3/5 text-left py-2 px-3 border-b">{{ $subject->name }}</td>
                            <td class="py-2 px-3 border-b">
                                <div class="flex items-center justify-evenly">
                                    {{-- Edit Subject --}}
                                    <x-jet-button wire:click="showModalSubjectForm({{ $subject }})">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" width="1rem" height="1rem">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </x-jet-button>
                                    {{-- Delete Subject --}}
                                    <x-jet-danger-button>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" width="1rem" height="1rem">
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
        </div>
    </div>
</div>
