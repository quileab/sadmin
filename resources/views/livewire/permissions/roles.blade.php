<div class="col-span-6 bg-gray-300 p-1 rounded-md shadow-md">
  <select wire:model="selectedrole">
      <option value="">Seleccione Rol</option>
      @foreach($roles as $role)
          <option value="{{$role->id}}" >{{$role->name}}</option>
      @endforeach
  </select>
  
  @if (session('bookmark'))
  <x-jet-button wire:click="assignRole" wire:loading.attr="disabled" class="py-3">
  Asignar a&nbsp;<x-svg.arrowRight />
  </x-jet-button>&nbsp;
  <strong>{{ $selectedUser->lastname }}, {{ $selectedUser->firstname }}</strong>
  @endif
</div>