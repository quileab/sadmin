<div>
  <x-jet-form-section submit="saveRolePermissions">
    <x-slot name="title">
      Roles & Permissions
    </x-slot>
    <x-slot name="description">
      Administrar Roles y permisos
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
        {{ __('Save') }}
      </x-jet-button>
    </x-slot>
  </x-jet-form-section>
</div>
