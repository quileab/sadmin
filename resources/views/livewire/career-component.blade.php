<div>
    {{-- Formulario de Carreras --}}
    <x-jet-confirmation-modal wire:model="updateCareerForm">
        <x-slot name="title">
            {{ $name }}<br /><small>{{ $uid }}</small>
        </x-slot>

        <x-slot name="content">
            Nombre <x-jet-input wire:model='name' value={{ $name }} /><br />
            Resol <x-jet-input wire:model='resol' value={{ $resol }} /><br />
            <input type="checkbox" value="{{ $active_suscribe }}" wire.model="active_suscribe" class="form-checkbox h-5 w-5 text-green-500"> Inscripciones<br />
            <input type="checkbox" value="{{ $active_eval }}" wire.model="active_eval" class="form-checkbox h-5 w-5 text-green-500"> Mesas Examen
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updateCareerForm')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-button class="ml-2" wire:click="saveCareerChange" wire:loading.attr="disabled">
                Modificar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>




    @foreach ($careers as $career)
        <x-jet-action-section>
            <x-slot name="title">
                <small class="text-gray-400 font-bold">{{ $career->id }} » </small>{{ $career->name }}
            </x-slot>
            <x-slot name="description">
                <div class="flex justify-evenly">
                    {{-- Edit Career --}}
                    <x-jet-button wire:click="showModalForm({{ $career }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                        </svg> Carrera
                    </x-jet-button>

                    {{-- Delete Career --}}
                    <a class="hover:text-red-700 flex place-items-center" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            class="w-5 h-5 hover:bg-gray-200 hover:text-blue-700 rounded-xl">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                        <small> Carrera</small>
                    </a>
                </div>
                {{-- Add Materias --}}
                <a class="hover:text-blue-700 flex place-items-center" href="#">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="w-5 h-5 hover:bg-gray-200 hover:text-blue-700 rounded-xl" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <small> Materias</small>
                </a>



            </x-slot>
            <x-slot name="content">
                @livewire('subjects-component',['career_id'=>$career->id])
            </x-slot>
        </x-jet-action-section>
        <hr class="my-2" />
    @endforeach
</div>
