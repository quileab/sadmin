<div class="col-span-12 sm:col-span-8 border-t border-b border-gray-300 p-3 ">
  <div class="flex justify-between">
      <div class="w-full">Permisos</div>
      <div class="flex justify-end w-1/2">
      <div class="1/4">
          <x-jet-input id="selectall" name="selectall" wire:model="checkall" type="checkbox" class="mt-1" />
      </div>
      <div class="text-wrap 3/4">
          <x-jet-label class="ml-1 mt-0" for="selectall" value="Todos" />
      </div>
   </div>
  </div>
</div>

<div class="col-span-12 sm:col-span-8">
  <div class="flex flex-wrap mt-1 justify-between px-3 w-full">
      @foreach($permissions as $key=>$permission)
          <div class="flex flex-wrap mr-3 mt-3 w-1/3">
              <div class="flex">
                  <div class="1/4">
                      <x-jet-input name="rolepermissions" wire:model="selectedpermissions.{{$key}}"
                        type="checkbox" class="" />
                  </div>
                  <div class="text-wrap 3/4">
                      <x-jet-label class="ml-1 mt-0" for="{{$permission->name}}" value="{{$permission->name}}" />
                  </div>
              </div>
          </div>
      @endforeach
  </div>
</div>