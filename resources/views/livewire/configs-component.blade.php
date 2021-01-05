<div>
    <x-jet-confirmation-modal wire:model="updateForm">
        <x-slot name="title">
            {{ $description }}<br /><small>{{ $uid }}</small>
        </x-slot>

        <x-slot name="content">
            @if (strtolower($value) == 'true')
                <x-jet-button color="green" wire:click="$set('value','false')"> Habilitado </x-jet-button>
            @elseif (strtolower($value)=='false')
                <x-jet-button color="red" wire:click="$set('value','true')"> Deshabilitado </x-jet-button>
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
        <div class='d2c max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8'>
            $config->group
        </div>";
        $section=$config->group;
        }
        @endphp

        <x-jet-action-section>
            <x-slot name="title">
                <small>{{ $config->description }}</small>
            </x-slot>
            <x-slot name="description">
                <small>({{ $config->id }})</small>
            </x-slot>
            <x-slot name="content">
                <x-jet-button wire:click="showModalForm({{ $config }})" class="mr-4">Cambiar</x-jet-button>

                @if (strtolower($config->value) == 'true')
                    <x-jet-button disabled color="green"> Habilitado </x-jet-button>
                @elseif (strtolower($config->value)=='false')
                    <x-jet-button disabled color="red"> Deshabilitado </x-jet-button>
                @else
                    {{ $config->value }}
                @endif
            </x-slot>
        </x-jet-action-section>

    @endforeach
</div>
