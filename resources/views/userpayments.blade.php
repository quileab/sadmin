<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      {{-- not used --}}
    </h2>
  </x-slot>

    @livewire('user-payment-component',['uid'=>$id])

</x-app-layout>
