<div class="mb-3">
    <x-jet-dialog-modal wire:model="updateForm" icon='edit'>
        <x-slot name="title">
            {{ $description }}
        </x-slot>

        <x-slot name="content">
            <small>{{ $uid }}</small>&nbsp;
            @if (strtolower($value) == 'true')
                <x-jet-button color="green" wire:click="$set('value','false')">Habilitado</x-jet-button>
            @elseif (strtolower($value)=='false')
                <x-jet-button color="red" wire:click="$set('value','true')">Deshabilitado</x-jet-button>
            @else
                <x-jet-input wire:model='value' value={{ $value }} class="w-full" />
            @endif
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

                @if (strtolower($config->value) == 'true')
                    <div class="bg-green-600 inline-flex items-center px-4 py-2 rounded-md font-semibold text-white uppercase"> Habilitado </div>
                @elseif (strtolower($config->value)=='false')
                    <div class="bg-red-600 inline-flex items-center px-4 py-2 rounded-md font-semibold text-white uppercase"> Deshabilitado </div>
                @else
                    <span class="mt-2">{{ $config->value }}</span>
                @endif
                </div>
            </x-slot>
        </x-jet-action-section>
        </div>
    @endforeach
</div>
