<div>
    <x-jet-confirmation-modal wire:model="updateForm" icon='edit'>
        <x-slot name="title">
            {{ $uid }}
        </x-slot>

        <x-slot name="content">
            {{ $description }}&nbsp;
            @if (strtolower($value) == 'true')
                <x-jet-button color="green" wire:click="$set('value','false')">Habilitado</x-jet-button>
            @elseif (strtolower($value)=='false')
                <x-jet-button color="red" wire:click="$set('value','true')">Deshabilitado</x-jet-button>
            @else
                <x-jet-input wire:model='value' value={{ $value }} />
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('updateForm')" wire:loading.attr="disabled">
                Cancelar
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="saveChange" wire:loading.attr="disabled">
                Modificar
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    @php
    $section='';
    @endphp
    @foreach ($configs as $config)
        @php
        if ($section!=$config->group){
        echo "
        <div class='bg-gray-700 text-gray-200 uppercase 
            mx-auto py-2 px-4 sm:px-6 lg:px-8'>
            $config->group
        </div>";
        $section=$config->group;
        }
        @endphp

        <div class="px-5 bg-gray-100">
        <x-jet-action-section>
            <x-slot name="title">
                {{ $config->description }}
            </x-slot>
            <x-slot name="description">
                <small>({{ $config->id }})</small>
            </x-slot>
            <x-slot name="content">
                <x-jet-button wire:click="showModalForm({{ $config }})" class="mr-4 pt-1 py-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                </svg>

                </x-jet-button>

                @if (strtolower($config->value) == 'true')
                    <div class="bg-green-500 inline-flex items-center px-4 py-2 rounded-md font-semibold text-white uppercase"> Habilitado </div>
                @elseif (strtolower($config->value)=='false')
                    <div class="bg-red-500 inline-flex items-center px-4 py-2 rounded-md font-semibold text-white uppercase"> Deshabilitado </div>
                @else
                    {{ $config->value }}
                @endif
            </x-slot>
        </x-jet-action-section>
        </div>
    @endforeach
</div>
