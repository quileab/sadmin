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
         <div class="d2c flex justify-between items-center py-2 px-8 text-white bg-gray-600 border-b border-gray-300">
           <div class="flex text-2xl">
             <div class="flex">
               <x-jet-application-mark class="w-auto h-8" />&nbsp;
               Bienvenidos
             </div>
           </div>
           <p class="opacity-60 text-sm">
            {{ app()->version() }} » {{ phpversion() }} » 
            {{ env('APP_ENV') }} » {{ env('APP_DEBUG') }}
          </p>
         </div>

         <div class="grid grid-cols-1 bg-gray-200 bg-opacity-25 md:grid-cols-2">
           <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
             <div class="flex items-center">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
               </svg>
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
               <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
               </svg>
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
                 Usuarios Registrados</div>
             </div>

             <div class="ml-12">
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

             </div>
           </div>

           <div class="p-6 border-t border-gray-200">
             <div class="flex items-center">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
               </svg>
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
                 Materias y Calificaciones
               </div>
             </div>

             <div class="ml-12">
               <div class="mt-2 text-sm text-gray-500">
                 @foreach ($dashInfo['careers'] as $career)
                   {{ $career->name }}<br />
                   @foreach ($career->subjects() as $subject)
                     » {{ $subject->name }}<br />
                   @endforeach
                 @endforeach
               </div>
             </div>
           </div>

           <div class="p-6 border-t border-gray-200 md:border-l">
             <div class="flex items-center">
               <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                   d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
               </svg>
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">Mensajes</div>
             </div>

             <div class="ml-12">
               <div class="mt-2 text-sm text-gray-500">
                 🗒✏
               </div>
             </div>
           </div>

         </div>

         {{-- end: welcome.blade --}}
       </div>
     </div>
   </div>
 </x-app-layout>
