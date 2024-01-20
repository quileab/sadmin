<div class="mb-3">
    <x-jet-dialog-modal wire:model="updateForm" icon='edit'>
        <x-slot name="title">
            {{ $description }}
        </x-slot>

        <x-slot name="content">
            <small>{{ $uid }}</small>&nbsp;
            @if ($type == 'bool')
                @if (strtolower($value) == 'true')
                    <x-jet-button wire:click="$set('value','false')">
                        HABILITADAS
                    </x-jet-button>
                @else
                    <x-jet-button wire:click="$set('value','true')">
                        CERRADAS
                    </x-jet-button>
                @endif
            @else
                <x-jet-input wire:model='value' value={{ $value }} />
            @endif
            <br>
            <select name="type" wire:model.lazy='type' class="border border-gray-400 shadow-md">
                <option value="bool" @if ($type == 'bool') selected @endif>Bool</option>
                <option value="text" @if ($type == 'text') selected @endif>Texto</option>
                <option value="int" @if ($type == 'int') selected @endif>Número Entero</option>
                <option value="csv-1" @if ($type == 'csv-1') selected @endif>Opciones Separadas por Coma, solo seleccionar UNA</option>
                <option value="csv-n" @if ($type == 'csv-n') selected @endif>Opciones Separadas por Coma, seleccionar VARIAS</option>
            </select>
        </x-slot>

        <x-slot name="footer">
            <div class="flex justify-between">
            <x-jet-danger-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-danger-button>

            <x-jet-button class="ml-2" wire:click="saveChange" wire:loading.attr="disabled">
                Modificar
            </x-jet-button>
            </div>
        </x-slot>
    </x-jet-dialog-modal>

    @php
    $section='';
    @endphp
    @foreach ($configs as $config)
        @php
        if ($section!=$config->group){
        echo "
        <div class='bg-gray-700 text-gray-200 uppercase rounded-t-md
            mx-auto py-2 px-4 sm:px-6 lg:px-8 mt-3'>
            $config->group
        </div>";
        $section=$config->group;
        }
        @endphp

        <div class="pl-5 bg-gray-200">
        <x-jet-action-section>
            <x-slot name="title">
                {{ $config->description }}
            </x-slot>
            <x-slot name="description">
                <small>{{ $config->id }}</small>
            </x-slot>
            <x-slot name="content">
                <div class="flex flex-inline">
                <x-jet-button wire:click="showModalForm({{ $config }})"
                    class="mr-4 pt-2 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>
                </x-jet-button>

                @if ($config->type == 'bool')
                @if (strtolower($config->value) == 'true')
                    <span class="text-green-600 pt-1 font-bold">
                        HABILITADAS
                    </span>
                @else
                    <span class="text-red-600 pt-1 font-bold">
                        CERRADAS
                    </span>
                @endif
            @else
            <span class="pt-1 text-lg">{{ $config->value }}</span>
            @endif
                
                </div>
            </x-slot>
        </x-jet-action-section>
        </div>
    @endforeach
</div>
