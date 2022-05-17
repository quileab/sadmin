<div class="col-span-12 sm:col-span-8 bg-gray-400 pl-1 rounded-md">
  <select class="w-1/3" wire:model="selectedrole">
      <option value="">Seleccione Rol</option>
      @foreach($roles as $role)
          <option value="{{$role->id}}" >{{$role->name}}</option>
      @endforeach
  </select>
  
  @if (session('bookmark'))
  <x-jet-button class='mx-1' wire:click="assignRole" wire:loading.attr="disabled">
  Asignar a
  </x-jet-button>
  <strong>{{ $selectedUser->lastname }}</strong>, {{ $selectedUser->firstname }}
  @endif

</div>