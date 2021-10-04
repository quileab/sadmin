<div class="m-4">
  <div class="flex justify-between">
    <div>
    Carrera&nbsp; 
    <select wire:model.lazy="career" name="career" id="career">
      {{-- opcion 0 por default --}}
      @foreach ($careers as $c)
        <option value="{{ $c->id }}">
          {{ $c->name }}
        </option>
      @endforeach
    </select>
    </div>
    {{-- {{ $inputType }} --}}
    @if (session('success'))
    <div id="message" class="border border-green-600 bg-green-200 rounded-md px-4 py-2 align-middle">
        {{ session('success') }}
        <button onclick="document.getElementById('message').remove()"><svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg></button>
    </div>
    @endif
  </div>
    <section class="container mx-auto p-4">
      <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
        <div class="w-full overflow-x-auto">
          <table class="w-full">
            <thead>
              <tr class="text-md font-semibold tracking-wide text-center text-gray-100 bg-gray-800 uppercase border-b border-gray-600">
                <th class="px-4 py-2">ID</th>
                <th class="px-4 py-2">Materias</th>
                <th class="px-4 py-2">{{-- Seleccion --}}
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                  </svg>
                </th>
                <th class="px-4 py-2 flex justify-center">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  </svg>
                </th>
              </tr>
            </thead>
            <tbody class="bg-white">
              @foreach ($subjects as $subject)
              
              <tr class="text-gray-700 even:bg-gray-300">
                <td class="px-3 py-2 border">
                  <div class="flex items-center text-sm">
                    {{ $subject->id }}
                  </div>
                </td>
                <td class="px-3 py-2 text-ms font-semibold border">{{ $subject->name }}</td>
                <td @class(['px-3 py-2 text-xs border text-left',
                    'bg-red-200'=>($inscriptionStudent[$subject->id]!=$inscriptionUpdated[$subject->id])])>
                  @switch($inputType)
                  @case('csv-1')
                  <fieldset>
                    @foreach (str_getcsv($inscriptionValues[$subject->id],",",'"',"\\") as $value)
                    @php $value = trim($value); @endphp
                      @if ($value)
                      <x-jet-button wire:click="csv1AddRemove('{{$subject->id}}','{{$value}}')" class="mb-1"
                        color='{{(strpos($inscriptionStudent[$subject->id],$value) === false) ? "gray" : "green" }}'>
                        @if (strpos($inscriptionStudent[$subject->id],$value) === false)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @endif
                          &nbsp;{{$value}}
                      </x-jet-button>  
                      @endif
                    @endforeach
                  </fieldset>
                @break
                  @case('csv-n')
                    <fieldset>
                        @foreach (str_getcsv($inscriptionValues[$subject->id],",",'"',"\\") as $value)
                        @php $value = trim($value); @endphp
                          @if ($value)
                          <x-jet-button wire:click="csvnAddRemove('{{$subject->id}}','{{$value}}')" class="mb-1"
                            color='{{(strpos($inscriptionStudent[$subject->id],$value) === false) ? "gray" : "green" }}'>
                            @if (strpos($inscriptionStudent[$subject->id],$value) === false)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                            </svg>
                            @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            @endif
                              &nbsp;{{$value}}
                          </x-jet-button>  
                          @endif
                        @endforeach
                      </fieldset>
                    @break
                  @case('text')
                    <x-jet-input name="value{{$subject->id}}" wire:model.lazy="inscriptionValues.{{$subject->id}}"
                        type="text" class="w-full border border-gray-500" /> 
                    @break
                  @case('int')
                    <x-jet-input name="value{{$subject->id}}" wire:model.lazy="inscriptionValues.{{$subject->id}}"
                        type="number" class="w-full border border-gray-500" /> 
                    @break
                  @case('bool')
                  <fieldset>
                    @foreach (str_getcsv($inscriptionValues[$subject->id],",",'"',"\\") as $value)
                    @php $value = trim($value); @endphp
                      @if ($value)
                      <x-jet-button wire:click="csv1AddRemove('{{$subject->id}}','{{$value}}')" class="mb-1" 
                        color='{{(strpos($inscriptionStudent[$subject->id],$value) === false) ? "gray" : "green" }}'>
                        @if (strpos($inscriptionStudent[$subject->id],$value) === false)
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636" />
                        </svg>
                        @else
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        @endif
                          &nbsp;{{$value}}
                      </x-jet-button>  
                      @endif
                    @endforeach
                  </fieldset>
                @break
                  @default
                    ERROR EN FORMA DE INGRESO!!    
                    @break
                @endswitch

                </td>
                <td class="px-3 py-2 text-sm inline-flex">
                  <button wire:click="updateOrCreateValue({{$subject->id}})" class="flex items-center justify-center bg-green-500 hover:bg-green-700 text-white font-semibold rounded-full m-1 px-1 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                  </button>
                  <button wire:click="clearValue({{$subject->id}})" class="flex items-center justify-center bg-red-500 hover:bg-red-700 text-white font-semibold rounded-full m-1 px-1 py-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
      <a class="bg-blue-600 hover:bg-blue-700 rounded-md mx-1 px-3 py-2 text-white uppercase text-sm"
        href="{{ url('/inscriptionsPDF/'.Auth::user()->id.'/'.$career) }}"
        target="_blank">
        Vista Previa
      </a>
      <a class="bg-blue-600 hover:bg-blue-700 rounded-md mx-1 px-3 py-2 text-white uppercase text-sm"
        href="{{ url('/inscriptionsSavePDF/'.Auth::user()->id.'/'.$career) }}"
        target="_self">
        Enviar Inscripción
      </a>
    </section>
  </div>
  