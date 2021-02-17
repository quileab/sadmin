<div>
    {{-- Formulario de Carreras --}}
    <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
        <x-slot name="title">
            <strong>{{ $fullname }} » </strong>

            <small>
                {{ \Carbon\Carbon::parse($datetime)->format('d-m-Y') }} » 
                {{ \Carbon\Carbon::parse($datetime)->format('H:i') }}
            </small>
        </x-slot>

        <x-slot name="content">
            Email: <strong>{{ $email }}</strong><br />
            Teléfono: <strong>{{ $phone }}</strong><br />
            <hr>
            Asunto:<br />
            <strong>{{ $subject }}</strong><br />
            <hr>
            Estado: <strong>{{ $status }}</strong><br />
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
                    </x-jet-danger-button>
            @endif

            </div>
        </x-slot>
    </x-jet-confirmation-modal>


    Oficina de Atención » {{ $office }}
    <select wire:model.lazy="office" wire:change.lazy="officeChanged" name="office" id="office">
        {{-- opcion 0 por default --}}
        <option value="0">Seleccione una Opción</option>

        @foreach ($offices as $off)
            <option value="{{ $off->user_id }}">
                {{ $off->description }}
            </option>
        @endforeach
    </select><br />

    <table class="min-w-full bg-white rounded-lg overflow-hidden">
        <thead class="bg-gray-700 text-white">
            <tr>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Oficina</th>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Fecha</th>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Hora</th>
                <th class="w-2/7 text-center py-2 px-3 uppercase font-semibold text-sm">Nombre</th>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Estado</th>
                <th class="w-1/7 text-center py-2 px-3 uppercase font-semibold text-sm">Acciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-700">

            @foreach ($schedules as $schedule)
            @php
            switch($schedule->status){
                case 'C': $sttext="Cancelado"; $stcolor="bg-purple-500 text-white"; break;
                case 'D': $sttext="Hecho"; $stcolor="bg-green-700 text-white"; break;
                case 'N': $sttext="NUEVO"; $stcolor="bg-blue-700 text-white"; break;
                case 'O': $sttext="En curso"; $stcolor="bg-green-300"; break;
                case 'P': $sttext="Pausado"; $stcolor="bg-yellow-300"; break;
                case 'S': $sttext="Trabado"; $stcolor="bg-red-600 text-white"; break;
            }
            @endphp

                <tr>
                    <td class="w-1/7 text-left py-2 px-3 border-b">{{ $schedule->user->name }}</td>
                    <td class="w-1/7 text-center py-2 px-3 border-b">
                        {{ \Carbon\Carbon::parse($schedule->datetime)->format('d-m-Y') }}</td>
                    <td class="w-1/7 text-center py-2 px-3 border-b">
                        {{ \Carbon\Carbon::parse($schedule->datetime)->format('H:i') }}</td>
                    <td class="w-2/7 text-left py-2 px-3 border-b">{{ $schedule->fullname }}</td>
                    <td class="w-1/7 text-center py-2 px-3 border-b {{ $stcolor }}">{{ $sttext }}</td>
                    <td class="text-center py-2 px-3 border-b">
                        <div class="flex justify-between">
                            {{-- Edit Schedule --}}
                            <x-jet-button wire:click="edit({{ $schedule }})">
                                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </x-jet-button>

                        </div>
                    </td>
                </tr>

            @endforeach

        </tbody>
    </table>

</div>
