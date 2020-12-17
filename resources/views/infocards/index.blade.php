<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Infocards
      </h2>
  </x-slot>

  @livewire('cancel-confirm',[
    'title'=>'Live Alert',
    'message'=>'Text of the message',
    'color'=>'blue'
    ])

</x-app-layout>