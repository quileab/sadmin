<div class="bg-gray-300">
  <div class="flex justify-between w-full d2c px-4 py-2">
    <h1 class="text-xl">Mantenimiento</h1>
  </div>

  <div class="rounded-md shadow-md m-3 p-3">

    <div class="m-2 p-2 bg-gray-200 rounded-md shadow flex justify-between">
      Limpieza de elementos Internos del Sistema
      <a href="/clear"><x-jet-button>
          <x-svg.gear />&nbsp; Iniciar
        </x-jet-button></a>
    </div>

    <div class="m-2 p-2 bg-gray-200 rounded-md shadow flex justify-between">
      Crear Backup de la Base de Datos
      <x-jet-button wire:click='backupDatabase'>
        <x-svg.gear />&nbsp; Iniciar
      </x-jet-button>
    </div>
  </div>
</div>
