<x-app-layout>
  {{-- qb has removed Header from template --}}
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Grades
      </h2>
  </x-slot>

  @livewire('grades-component',compact('id'))

</x-app-layout>