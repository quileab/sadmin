<div>
    <x-jet-button wire:click="alertOn">
        Visible
    </x-jet-button>
    
    <x-confirm-modal wire:model="cancelConfirmVisible" color="{{$color}}">
        
        <x-slot name="title">{{$title}}</x-slot>
    
        <x-slot name="content">{{$message}}</x-slot>
    
        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$toggle('cancelConfirmVisible')" wire:loading.attr="disabled">
                <span class="material-icons">clear</span> Cancelar
            </x-jet-secondary-button>
    
            <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                <span class="material-icons">delete_forever</span> Aceptar
            </x-jet-danger-button>
        </x-slot>
    </x-confirm-modal>
</div>
