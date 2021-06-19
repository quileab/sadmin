<div>
    {{-- Formulario de Carreras --}}
    <x-jet-confirmation-modal icon='edit' wire:model="updateForm">
        <x-slot name="title">
                {{ \Carbon\Carbon::parse($datetime)->format('d-m-Y') }} » 
                {{ \Carbon\Carbon::parse($datetime)->format('H:i') }}
        </x-slot>

        <x-slot name="content">
            <p class="mb-3 text-lg">
            <strong>{{ $fullname }}</strong>
            </p>
            <span class="mr-4">
            Email: <strong>{{ $email }}</strong>
            </span>
            <span class="mb-3">
            Teléfono: <strong>{{ $phone }}</strong>
            </span>
            <p class="my-2">
            Asunto:&nbsp;
            <strong>{{ $subject }}</strong><br />
            </p>

            @if ($target_file!='')
                <p class="my-2">
                    <a href="{{ $target_file }}" target="_blank">
                    <x-jet-button>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-paperclip" viewBox="0 0 16 16">
                            <path d="M4.5 3a2.5 2.5 0 0 1 5 0v9a1.5 1.5 0 0 1-3 0V5a.5.5 0 0 1 1 0v7a.5.5 0 0 0 1 0V3a1.5 1.5 0 1 0-3 0v9a2.5 2.5 0 0 0 5 0V5a.5.5 0 0 1 1 0v7a3.5 3.5 0 1 1-7 0V3z"/>
                        </svg> Archivo adjunto
                    </x-jet-button>
                    </a>
                </p>
            @endif

            <x-jet-button color='{{ $status=== "S" ? "red" : "gray" }}' class="ml-2"
            wire:click="changeStatus('S')">Trabado
            </x-jet-button>
            <x-jet-button color='{{ $status=== "P" ? "yellow" : "gray" }}' class="ml-2"
            wire:click="changeStatus('P')">Pausar
            </x-jet-button>
            <x-jet-button color='{{ $status=== "C" ? "purple" : "gray" }}' class="ml-2"
            wire:click="changeStatus('C')">Cancelar
            </x-jet-button>
            <x-jet-button color='{{ $status=== "D" ? "green" : "gray" }}' class="ml-2"
            wire:click="changeStatus('D')">Hecho!!
            </x-jet-button>
            <x-jet-button color='{{ $status=== "O" ? "green" : "gray" }}' class="ml-2"
            wire:click="changeStatus('O')">En curso
            </x-jet-button>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
            <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
                Cerrar
            </x-jet-secondary-button>
            <x-jet-action-message class='mt-2' on="saved">
                Cambio realizado
            </x-jet-action-message>
            </div>
        </x-slot>
    </x-jet-confirmation-modal>


    Oficina de Atención
    <select wire:model.lazy="office" wire:change.lazy="officeChanged" name="office" id="office">
        {{-- opcion 0 por default --}}
        <option value="0">Seleccione una Opción</option>

        @foreach ($offices as $off)
            <option value="{{ $off->user_id }}">
                {{ $off->title }}
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
                            <x-jet-button wire:click="edit('{{ $schedule->user_id }}','{{ $schedule->datetime }}')">
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
