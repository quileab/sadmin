<div class="col-span-6">
  <div class="flex bg-gray-100 justify-between shadow p-3">
    <div>Permisos</div>

    <div class="flex">
      <x-jet-input id="selectall" name="selectall" wire:model="checkall" type="checkbox" class="form-checkbox text-green-500" />
      <x-jet-label class="ml-1 mt-0" for="selectall" value="Todos" />
    </div>
  </div>

  <div class="flex flex-wrap mt-0 justify-evenly px-3 w-full">
    @foreach ($permissions as $key => $permission)
      <div class="flex flex-wrap mr-3 mt-2 w-1/3">
        <div class="flex">
          <div>
            <x-jet-input type="checkbox" name="rolepermissions" wire:model="selectedpermissions.{{ $permission->id }}" class="form-checkbox text-green-500" />
          </div>
          <div class="text-wrap">
            <x-jet-label class="ml-1 mt-0" for="{{ $permission->id }}" value="{{ $permission->name }}" />
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>