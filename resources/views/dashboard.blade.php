 {{-- Data came from web route --}}
 <x-app-layout>
   <x-slot name="header">
     <h2 class="leading-tight">
       {{ __('Dashboard') }}
     </h2>
   </x-slot>

   <div class="mx-auto max-w-7xl sm:px-6 lg:px-8 py-6">
     <div class="overflow-hidden bg-gray-100 shadow-xl rounded-lg">
       {{-- <x-jet-welcome /> --}}
       {{-- begin: this is the welcome.blade --}}
       <div class="flex items-center justify-between px-8 py-2 text-white bg-gray-600 d2c">
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

       <div class="grid grid-cols-1 bg-gray-400 md:grid-cols-2">
         <div class="m-3 p-3 bg-gray-200 rounded-md overflow-hidden">
           {{-- Institucion  --}}
           <div class="flex items-center">
             <x-svg.house class="w-[2rem] h-[2rem] text-gray-400" />
             <div class="ml-2 text-lg font-semibold leading-7 text-gray-700">
               Institución
             </div>
           </div>

           <div>
             <div class="mt-2 text-sm text-gray-500">
               {{ $dashInfo['shortname'] }}, {{ $dashInfo['longname'] }}
             </div>

             <table class="w-full mt-2 text-sm text-gray-800">
               @foreach ($inscriptions as $inscription)
                 <tr class="border-y border-y-gray-400">
                   <td>
                     {{ $inscription['description'] }}&nbsp;
                   </td>
                   <td>
                     @if ($inscription['value'] == 'true')
                       <span class="font-bold text-green-700">Abierta</span>
                     @else
                       <span class="font-bold text-red-700">Cerrada</span>
                     @endif
                   </td>
                 </tr>
               @endforeach
             </table>

           </div>
         </div>

         {{-- Elevated Permissions show users stats --}}
         @if (Auth::user()->hasanyrole('admin|principal|superintendent|administrative'))
           <div class="m-3 p-3 bg-gray-200 rounded-md overflow-hidden">
             <div class="flex items-center">
               <x-svg.users class="w-[2rem] h-[2rem] text-gray-400" />
               <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
                 Usuarios</div>
             </div>

             <div>
               <div class="overflow-hidden text-xs text-gray-500 rounded-sm flex justify-center">
                 <table>
                   <tbody>
                     @foreach ($dashInfo['rolesUsersCount'] as $role => $count)
                       <tr class="border-y border-y-gray-300">
                         <td class="px-2">{{ $role }}</td>
                         <td class="px-2 text-right strong">{{ $count }}</td>
                       </tr>
                     @endforeach
                   </tbody>
                 </table>
               </div>

             </div>
           </div>
         @endif

         <div class="m-3 p-3 bg-gray-200 rounded-md overflow-hidden">
           <div class="flex items-center">
             <x-svg.notepad class="w-[2rem] h-[2rem] text-gray-400" />
             <div class="ml-4 text-lg font-semibold leading-7 text-gray-700">
               Materias y Calificaciones
             </div>
           </div>

           <div class="flex justify-between">
             <div class="mt-2 text-sm text-gray-500">
               @foreach ($dashInfo['careers'] as $career)
                 {{ $career->name }}<br />
               @endforeach
               @if (Auth::user()->hasRole('student'))
                 <a target='_blank' href="printStudentsReportCard/{{ Auth::user()->id }}">
                   <x-jet-button class="mt-1">
                     Libreta Digital
                   </x-jet-button>
                 </a>

                   <form method="get" action="{{ route('printclassbooks') }}">
                     <!-- CROSS Site Request Forgery Protection -->
                     @csrf
                     Materia <select name="subject" class="border border-gray-400 shadow-md w-full">
                       @foreach ($subjects as $subject)
                         <option value='{{ $subject['id'] }}'>{{ $subject['name'] }}</option>
                       @endforeach
                     </select>
                      @if(Session::has('error'))
                      <p class="bg-red-200 border-red-800 text-red-900">{{ Session::get('error') }}</p>
                      @endif
                     <x-jet-button type="submit" class="mt-1" >
                       Libro de Temas
                     </x-jet-button>
                   </form>


               @endif

               @if (Auth::user()->hasanyrole('admin|principal|superintendent|administrative'))
                 <a href="quickgrade">
                   <x-jet-button class="mt-1">
                     Calificación Rápida
                   </x-jet-button>
                 </a>
               @endif
             </div>
           </div>
         </div>

         <div class="m-3 bg-gray-200 rounded-md overflow-hidden">
           @livewire('infocard-component')
         </div>

       </div>

       {{-- end: welcome.blade --}}

     </div>
   </div>

 </x-app-layout>
