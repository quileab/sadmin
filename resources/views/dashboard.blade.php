<x-app-layout>
    <x-slot name="header">
        <h2 class="leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-200 overflow-hidden shadow-xl sm:rounded-lg">
                {{-- <x-jet-welcome /> --}}
                {{-- begin: this is the welcome.blade --}}
                <div class="p-3 sm:px-20 bg-gray-600 border-b border-gray-300 text-white">
                    <div class="flex items-center">
                      <div>
                        <x-jet-application-mark class="block h-12 w-auto" />
                      </div>
                  
                      <div class="ml-4 text-2xl">
                        Bienvenido
                      </div>
                    </div>
                    <div class="mt-5 text-gray-300">
                      <b>Sistema en progreso: </b> Administración y control general e integrado.
                    </div>
                  </div>
                  
                  <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
                    <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                      <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <div class="ml-4 text-lg text-gray-700 leading-7 font-semibold">Institución
                        </div>
                      </div>
                  
                      <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500 text-lg">
                          {{$institution}}
                        </div>
                  
                          <div class="mt-2 text-sm text-gray-700">
                            Inscripciones a Ciclo Lectivo:&nbsp;
                            @if ($inscriptions=="true")
                              <span class="font-bold text-green-600">Habilitadas</span>                     
                            @else
                              <span class="font-bold text-red-600">Cerradas</span>  
                            @endif
                            <br />

                            Inscripciones a Modalidades:&nbsp;
                            @if ($modalities=="true")
                              <span class="font-bold text-green-600">Abiertas</span>                     
                            @else
                              <span class="font-bold text-red-600">Cerradas</span>  
                            @endif
                            <br />

                            Inscripciones a Exámenes:&nbsp;
                            @if ($exams=="true")
                              <span class="font-bold text-green-600">Abiertas</span>                     
                            @else
                              <span class="font-bold text-red-600">Cerradas</span>  
                            @endif

                          </div>
                  
                      </div>
                    </div>
                  
                    <div class="p-6">
                      <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <div class="ml-4 text-lg text-gray-700 leading-7 font-semibold">
                          Estudiantes Registrados</div>
                      </div>
                  
                      <div class="ml-12">
                        <div class="mt-2 text-xl text-gray-500">
                          {{ Auth::user()->userCount() }}
                        </div>
                  
                      </div>
                    </div>
                  
                    <div class="p-6 border-t border-gray-200">
                      <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                          <path
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                          </path>
                        </svg>
                        <div class="ml-4 text-lg text-gray-700 leading-7 font-semibold"><a href="https://tailwindcss.com/">Tailwind</a>
                        </div>
                      </div>
                  
                      <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                          Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way.
                          You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at
                          your fingertips.
                        </div>
                      </div>
                    </div>
                  
                    <div class="p-6 border-t border-gray-200 md:border-l">
                      <div class="flex items-center">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          viewBox="0 0 24 24" class="w-8 h-8 text-gray-400">
                          <path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                          </path>
                        </svg>
                        <div class="ml-4 text-lg text-gray-700 leading-7 font-semibold">Authentication</div>
                      </div>
                  
                      <div class="ml-12">
                        <div class="mt-2 text-sm text-gray-500">
                          Authentication and registration views are included with Laravel Jetstream, as well as support for user email
                          verification and resetting forgotten passwords. So, you're free to get started what matters most: building your
                          application.
                        </div>
                      </div>
                    </div>
                    
                  </div>
                  
                {{-- end: welcome.blade --}}
            </div>
        </div>
    </div>
</x-app-layout>
