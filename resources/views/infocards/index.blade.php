<x-app-layout>
  <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
          Infocards
      </h2>
  </x-slot>

  @php
  $color="blue";
  $title="Esto es una prueba";
  $message="Esto es una prueba";
  @endphp

  <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 text-white">
      <h1>Esto es H1</h1>
      <h2>Esto es H2</h2>
      <h3>Esto es H3</h3>
      <h4>Esto es H4</h4>
      <h5>Esto es H5</h5>

      <x-jet-button>Botón</x-jet-button>

      <x-confirm-modal wire:model="alertVisible" color="{{ $color }}">
          <x-slot name="title">{{ $title }}</x-slot>
          <x-slot name="content">{{ $message }}</x-slot>

          <x-slot name="footer">
              <x-jet-secondary-button wire:click="$toggle('alertVisible')" wire:loading.attr="disabled">
                  <span class="material-icons">clear</span> Cancelar
              </x-jet-secondary-button>

              <x-jet-danger-button class="ml-2" wire:click="deleteUser" wire:loading.attr="disabled">
                  <span class="material-icons">delete_forever</span> Eliminar
              </x-jet-danger-button>
          </x-slot>
      </x-confirm-modal>
</x-app-layout>