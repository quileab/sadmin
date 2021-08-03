<x-app-layout>
  <x-slot name="header">
    {{-- not in use --}}
  </x-slot>

  <div class="bg-gray-200 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-4">
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
        <h1>Planes de Pago</h1>

    </div>
    <div class="p-4">
        @livewire('pay-plans')
    </div>
</div>
 
</x-app-layout>
