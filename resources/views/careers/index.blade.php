<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Carreras
        </h2>

        <a class="hover:text-blue-700 flex place-items-center" href="#">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:bg-gray-200 hover:text-blue-700 rounded-xl"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </a>



    </x-slot>

    <div class="bg-white rounded-md shadow-md overflow-hidden max-w-4xl mx-auto mb-2 mt-4">
        <div class="w-full d2c px-4 py-3 text-white">
            <h1>Carreras</h1>
        </div>
        <div class="p-4">
            @livewire('career-component')
        </div>
    </div>

    {{-- @livewire('subjects-component') --}}

</x-app-layout>
