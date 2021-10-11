<div wire:init="loadData">

  {{-- Formulario --}}
  <x-jet-dialog-modal icon='edit' wire:model="openModal">
    <x-slot name="title">Calificaciones » <small>{{ $subjID }} »</small> {{ $subjName }}</x-slot>
    <x-slot name="content">
      {{-- Altas --}}
      <div class="flex mb-2">
        <div class="w-1/3">
        <x-jet-label value="Fecha" />
        @if ($edittingGrade)
          <x-jet-input disabled wire:model.defer="date" class="w-full" />
        @else
          <x-jet-input type='date' wire:model.defer='date' value='{{ $date }}' class="w-full" />
        @endif
        <x-jet-input-error for="date" />
        </div>
        <div class="w-2/3 ml-3">
        <x-jet-label value="Descripción" />
        <x-jet-input type='text' wire:model.defer='name' value='{{ $name }}' class="w-full" />
        <x-jet-input-error for="name" />
        </div>
      </div>

      <div class="flex mb-2 justify-between">
        <div class="w-2/4">
          <x-jet-label value="Calificación" />
          <x-jet-input type='text' wire:model.defer='grade' value='{{ $grade }}' class="w-full" />
          <x-jet-input-error for="grade" />
        </div>

        <div class="w-2/4 mx-2">
          {{-- Approved --}}
          <x-jet-label value="Aprobado" />
          <input type="checkbox" value="@if ($approved) 0 @else 1 @endif" wire:model.lazy="approved"
          class="border-4 focus:border-gray-700 form-checkbox mt-1 h-9 w-9 text-green-600">
          <x-jet-input-error for="approved" />
        </div>
        
        <div class="w-full mt-6 text-right">
        @if ($edittingGrade)
        <x-jet-button color="indigo" wire:click="updateGrade">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
          </svg>&nbsp;Corregir
        </x-jet-button>
        <x-jet-button wire:click="cancelEditGrades" class="ml-2">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>&nbsp;Cancelar
        </x-jet-button>

        @else
          <x-jet-button wire:click="addGrade">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>&nbsp;Agregar
          </x-jet-button>
        @endif
        </div>

      </div>


      <div class="mx-6 px-0">
      <x-table>
        <table class="w-full divide-y divide-gray-200">
          <thead class="text-gray-100 bg-cool-gray-700">
            <tr>
              <th class="py-2" scope="col">Fecha</th>
              <th scope="col">Descripción</th>
              <th scope="col">Calificación</th>
              <th scope="col" class="relative px-4">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            @foreach ($grades as $grade)
              <tr class="hover:bg-gray-100">
                <td class="px-6 py-4">
                  {{ $grade->date_id }}<br />
                </td>
                <td class="px-6 py-4">
                  {{$grade->name}}
                </td>
                <td class="px-6 py-4">
                  {{$grade->grade}}
                </td>
                <td class="w-28 bg-gray-100 px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                  {{-- Edit --}}
                  <button wire:click="editGrade('{{ $grade->date_id }}')" class="mr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                  </button>
                  {{-- Delete --}}
                  <button wire:click="$emit('confirmDelete','{{$grade->date_id}}, {{ $grade->name }}','{{ $grade->date_id }}','deleteGrade')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="red">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                  </svg>
                  </button>
                </td>
              </tr>
            @endforeach
            <!-- More items... -->
          </tbody>
        </table>
      </x-table>
      </div>
    </x-slot>

    <x-slot name="footer">
      <div class="flex justify-between">
        <x-jet-secondary-button wire:click="$toggle('openModal')" wire:loading.attr="disabled">
          Cerrar
        </x-jet-secondary-button>
        <x-jet-action-message class='mt-2' on="saved">
          Cambio realizado
        </x-jet-action-message>
      </div>
    </x-slot>
  </x-jet-dialog-modal>

  <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <x-table>
      <div class="px-6 py-2 flex items-center d2c">
        <div class="flex flex-1 justify-between place-items-center">
          <span class="text-2xl">
            <strong>{{ $lastname }}</strong>, {{ $firstname }} »
            <small>({{ $uid }})</small>
          </span>
          <span>Carrera&nbsp;
            <select wire:model.lazy="selectedCareer">
              {{-- opcion 0 por default --}}
              @foreach ($careers as $career)
                <option value="{{ $career->id }}">
                  {{ $career->name }}
                </option>
              @endforeach
            </select>
          </span>
        </div>

        {{-- <x-jet-button wire:click="$set('openModal',true)" color="green">
          Nuevo Libro
        </x-jet-button> --}}

      </div>

      <table class="min-w-full divide-y divide-gray-200">
        <thead class="text-gray-100 bg-cool-gray-700">
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Materia</th>
            <th scope="col">Calif.</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
          @foreach ($subjects as $subject)
            <tr class="hover:bg-gray-100">
              <td class="px-6 py-1">
                {{ $subject->id }}
              </td>
              <td class="px-6 py-1">
                {{ $subject->name }}
              </td>
              <td class="w-28 bg-gray-100 px-6 py-1 whitespace-nowrap text-right text-sm font-medium">
                <x-jet-button wire:click="setGrades('{{ $subject->id }}','{{ $subject->name }}')">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z" />
                    <path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd" />
                  </svg>

                </x-jet-button>
              </td>
            </tr>
          @endforeach
          <!-- More items... -->
        </tbody>
      </table>
    </x-table>
  </div>

</div>
