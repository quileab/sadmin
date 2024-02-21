<div id="permission-index">
  <x-jet-form-section submit="saveRolePermissions" class="m-4">
    <x-slot name="title">
      Roles & Permissions
    </x-slot>
    <x-slot name="description">
      <div class="flex flex-wrap">
      <x-jet-input class="w-3/4" type="text" wire:model.lazy="newrole" placeholder="Nombre del Rol" />
      <x-jet-button wire:loading.attr="disabled" wire:click="createRole" class="my-1">
        <x-svg.plusCircle class="w-6 h-6" />
      </x-jet-button>
      </div>

      <div class="flex flex-wrap">
      <x-jet-input class="w-3/4" type="text" wire:model.lazy="newpermission" placeholder="Nombre del Permiso" />
      <x-jet-button wire:loading.attr="disabled" wire:click="createPermission" class="my-1">
        <x-svg.plusCircle class="w-6 h-6" />
      </x-jet-button>
      </div>

      {{-- Red Buttons of assigned Roles --}}
      <div class="flex flex-wrap">
        @foreach ($selectedUser->roles()->get() as $role)
        <x-jet-danger-button wire:click="removeRole({{ $role->id }})" class="my-1 w-full">
          {{ $role->name }}
          <x-svg.trash class="w-5 h-5" />  
        </x-jet-danger-button> 
        @endforeach
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
        <x-svg.check />&nbsp;Guardar
      </x-jet-button>
    </x-slot>
  </x-jet-form-section>
</div>
