<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{-- not used --}}
    </h2>
  </x-slot>

  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    @livewire('user-payment-component',['uid'=>$id])
  </div>
</x-app-layout>
