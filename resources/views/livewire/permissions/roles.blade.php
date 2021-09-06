<div class="col-span-12 sm:col-span-8">
  <select class="w-1/2" wire:model="selectedrole">
      <option value="">Seleccione Rol</option>
      @foreach($roles as $role)
          <option value="{{$role->id}}" >{{$role->name}}</option>
      @endforeach
  </select>
</div>