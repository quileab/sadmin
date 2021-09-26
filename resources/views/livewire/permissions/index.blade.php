<div>
  <x-jet-form-section submit="saveRolePermissions">
    <x-slot name="title">
      Roles & Permissions
    </x-slot>
    <x-slot name="description">
      Administrar Roles y permisos

      <div class="flex flex-wrap">
      <x-jet-input class="w-3/4" type="text" wire:model.lazy="newrole" placeholder="Nombre del Rol" />
      <x-jet-button wire:loading.attr="disabled" wire:click="createRole" class="my-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
          <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
        </svg>
      </x-jet-button>
      </div>

      <div class="flex flex-wrap">
      <x-jet-input class="w-3/4" type="text" wire:model.lazy="newpermission" placeholder="Nombre del Permiso" />
      <x-jet-button wire:loading.attr="disabled" wire:click="createPermission" class="my-1">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-save" viewBox="0 0 16 16">
          <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
        </svg>
      </x-jet-button>
      </div>

    </x-slot>
    <x-slot name="form">
      @include('livewire.permissions.roles')
      @include('livewire.permissions.permissions')
    </x-slot>

    <x-slot name="actions">
      <x-jet-action-message class="mr-3" on="saved">
        {{ __('Saved.') }}
      </x-jet-action-message>

      <x-jet-button wire:loading.attr="disabled" wire:target="selectedrole">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>&nbsp;Guardar
      </x-jet-button>
    </x-slot>
  </x-jet-form-section>
</div>
