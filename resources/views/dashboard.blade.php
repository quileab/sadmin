 {{-- Data came from web route --}}
 <x-app-layout>
   <x-slot name="header">
     <h2 class="leading-tight">
       {{ __('Dashboard') }}
     </h2>
   </x-slot>

   <div class="py-10">
     <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
       <div class="overflow-hidden bg-gray-200 shadow-xl sm:rounded-lg">
         {{-- <x-jet-welcome /> --}}
         {{-- begin: this is the welcome.blade --}}
         <div class="flex items-center justify-between px-8 py-2 text-white bg-gray-600 border-b border-gray-300 d2c">
           <div class="flex text-2xl">
             <div class="flex">
               <x-jet-application-mark class="w-auto h-8" />&nbsp;
               Bienvenidos
             </div>
           </div>
           <p class="text-sm opacity-60">
            {{ app()->version() }} » {{ phpversion() }} » 
            {{ env('APP_ENV') }} » {{ env('APP_DEBUG') }}
          </p>
         </div>

         <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-2">
           <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
             <div class="flex items-center">
               <x-svg.house class="w-[2rem] h-[2rem] text-gray-400" />
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">Institución
               </div>
             </div>

             <div class="ml-12">
               <div class="mt-2 text-sm text-gray-500">
                 {{ $dashInfo['shortname'] }}, {{ $dashInfo['longname'] }}
               </div>

               <div class="mt-2 text-sm text-gray-700">
                 @foreach ($inscriptions as $inscription)
                   {{ $inscription->description }}:&nbsp;
                   @if ($inscription->value == 'true')
                     <span class="font-bold text-green-700">Abiertas</span>
                   @else
                     <span class="font-bold text-red-700">Cerradas</span>
                   @endif
                   <br />
                 @endforeach
               </div>

             </div>
           </div>

           <div class="p-6">
             <div class="flex items-center">
               <x-svg.users class="w-[2rem] h-[2rem] text-gray-400" />
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
                 Usuarios Registrados</div>
             </div>

             <div class="ml-12">
              @if(Auth::user()->hasanyrole('admin|principal|superintendent|administrative')) 
              <div class="overflow-hidden text-xs text-gray-500 rounded-sm">
                 <table>
                   <thead class="text-white bg-gray-800">
                     <tr>
                       <th class="px-2">Categ.</th>
                       <th class="px-2">Cant.</th>
                     </tr>
                   </thead>
                   <tbody>
                     @foreach ($dashInfo['rolesUsersCount'] as $role => $count)
                       <tr>
                         <td class="px-2">{{ $role }}</td>
                         <td class="px-2 text-right strong">{{ $count }}</td>
                       </tr>
                     @endforeach
                   </tbody>
                 </table>
              </div>
              @endif

             </div>
           </div>

           <div class="p-6 border-t border-gray-200">
             <div class="flex items-center">
               <x-svg.notepad class="w-[2rem] h-[2rem] text-gray-400" />
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
                 Materias y Calificaciones <small>{{ Auth::user()->hasRole('student') ? '('.Auth::user()->id.')' : '»' }}</small>
               </div>
             </div>

             <div class="ml-12">
               <div class="mt-2 text-sm text-gray-500">
                 @foreach ($dashInfo['careers'] as $career)
                 {{ $career->name }}<br />
                 @endforeach
                 @if(Auth::user()->hasRole('student'))
                 <a href="grades/{{Auth::user()->id}}">
                  <x-jet-button class="mt-1">
                    Libreta Digital
                  </x-jet-button>
                 </a>
                 @endif


                 @if(Auth::user()->hasanyrole('admin|principal|superintendent|administrative'))
                 <a href="quickgrade">
                  <x-jet-button class="mt-1">
                    Calificación Rápida
                  </x-jet-button>
                 </a>
                 @endif
               </div>
             </div>
           </div>

           <div class="p-6 border-t border-gray-200 md:border-l">
               @livewire('infocard-component')
           </div>

         </div>

         {{-- end: welcome.blade --}}

       </div>
     </div>
   </div>
 </x-app-layout>
