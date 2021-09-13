<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Assign Roles
      </h2>
  </x-slot>

  <div class="bg-gray-300 rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
      <div class="w-full d2c px-4 py-3 text-white flex justify-between">
        <div class="flex">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="currentColor" class="bi bi-person-check" viewBox="0 0 16 16">
            <path d="M6 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0zm4 8c0 1-1 1-1 1H1s-1 0-1-1 1-4 6-4 6 3 6 4zm-1-.004c-.001-.246-.154-.986-.832-1.664C9.516 10.68 8.289 10 6 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10z"/>
            <path fill-rule="evenodd" d="M15.854 5.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 0 1 .708-.708L12.5 7.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
          </svg>&nbsp;
        <h1>Asignar Roles</h1>
        </div>
      </div>
      <div class="p-4">
        {{-- @livewire('permissions.roles') --}}
      </div>
  </div>

</x-app-layout>