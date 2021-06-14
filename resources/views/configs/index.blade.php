<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl leading-tight">
            Configuration
        </h2>
    </x-slot>

    <!-- Formulario -->
    <div class="bg-gray-100 rounded-md shadow-md overflow-hidden max-w-6xl mx-auto mb-2 mt-4">
        <div class="w-full d2c px-4 py-3 text-white">
            <h1>Variables de Entorno</h1>
        </div>
        <div class="p-5 shadow-md">
            @livewire('configs-component')
        </div>
    </div>

</x-app-layout>
