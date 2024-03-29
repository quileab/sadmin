<div class="m-4">
  <div class="flex">
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

  &nbsp; » Tipo de ingreso
  <select wire:model.lazy="inputType" name="inputtype" id="">
    {{-- <option value="text">Texto Simple</option> --}}
    {{-- <option value="bool">Si/No (Ej. Habilitar/Deshabilitar)</option> --}}
    <option value="csv-1">Texto separado por comas. Acepta solo un valor</option>
    <option value="csv-n">Texto separado por comas. Acepta varios valores</option>
    {{-- <option value="num">Valor numerico</option> --}}
  </select>
  </div>

  </div>

  <section class="container mx-auto p-4">
    <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
          <thead>
            <tr class="text-md font-semibold tracking-wide text-center text-gray-100 bg-gray-800 uppercase border-b border-gray-600">
              <th class="px-4 py-2">ID</th>
              <th class="px-4 py-2">Materias</th>
              <th class="px-4 py-2">Selección</th>
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
              <td class="px-3 py-2 text-xs border
                @if(isset($inscriptionValues[$subject->id]) && $inscriptionValues[$subject->id]!=$inscriptionUpdated[$subject->id])
                    bg-red-200
                @endif
                ">
                <x-jet-input name="value{{$subject->id}}" wire:model.lazy="inscriptionValues.{{$subject->id}}"
                  type="text" class="w-full border border-gray-500" /> 
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
  </section>

</div>
