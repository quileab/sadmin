<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Calendarios
      </h2>
  </x-slot>

  <div class="bg-gray-200 rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
      <div class="w-full d2c px-4 py-3 text-white flex justify-between">
          <h1>Calendarios</h1>

      </div>
      <div class="p-4">
          @livewire('calendars-component')
      </div>
  </div>

</x-app-layout>
