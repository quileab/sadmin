<x-app-layout>
  <x-slot name="header">
    {{-- not in use --}}
  </x-slot>

  <div class="bg-gray-200 rounded-lg shadow-md w-full overflow-hidden">
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
      <h1>Planes de Pago</h1>
    </div>
    @livewire('pay-plans')
  </div>
  <br />
  <div class="bg-gray-200 rounded-lg shadow-md w-full overflow-hidden">
    <div class="w-full d2c px-4 py-3 text-white flex justify-between">
      <h1>Reportes</h1>
    </div>
    @livewire('report-payments')
  </div>
</x-app-layout>
